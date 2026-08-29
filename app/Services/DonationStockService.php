<?php

namespace App\Services;

use App\Models\Beneficiaria;
use App\Models\CategoriaMaterial;
use App\Models\Distribuicao;
use App\Models\Doacao;
use App\Models\Doador;
use App\Models\EstoqueMovimentacao;
use App\Models\Material;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DonationStockService
{
    public function indexData(?string $search, string $status, string $category): array
    {
        $materials = $this->materialsWithBalance()
            ->when($category !== 'all', fn (Collection $items) => $items->where('category_id', (int) $category))
            ->when($status !== 'all', fn (Collection $items) => $items->where('status', $status))
            ->when($search !== '', function (Collection $items) use ($search) {
                $needle = mb_strtolower($search);

                return $items->filter(fn (array $item) => str_contains(mb_strtolower($item['description']), $needle)
                    || str_contains(mb_strtolower($item['category']), $needle));
            })
            ->values();

        return [
            'materials' => $materials->map(fn (array $material) => $this->materialRow($material))->all(),
            'kpis' => $this->kpis(),
            'stock' => $this->stockByCategory(),
            'totalStock' => $this->totalStock(),
            'alerts' => $this->alerts(),
            'recent' => $this->recentMovements(),
            'search' => $search,
            'status' => $status,
            'category' => $category,
            'categories' => CategoriaMaterial::where('ativo', true)->orderBy('nome')->get(['id', 'nome']),
        ];
    }

    public function showData(Material $material): array
    {
        $material->load(['categoria', 'movimentacoes.usuario', 'distribuicaoItens.distribuicao.beneficiaria', 'distribuicaoItens.distribuicao.usuario']);
        $balance = $this->balance($material);
        $status = $this->status($balance, $material->estoque_minimo);

        return [
            'item' => $material->id,
            'material' => $material,
            'stockItem' => [
                'description' => $material->nome,
                'category' => $material->categoria?->nome ?? '-',
                'quantity' => $this->quantity($balance, $material->unidade_medida),
                'status' => $status,
                'minimum' => $this->quantity($material->estoque_minimo, $material->unidade_medida),
                'monthly_demand' => $this->quantity($this->monthlyDemand($material), $material->unidade_medida),
                'last_movement' => $this->lastMovementText($material),
                'unit' => $material->unidade_medida,
            ],
            'kpis' => [
                ['label' => 'Quantidade atual', 'value' => $this->quantity($balance, $material->unidade_medida), 'context' => 'Disponível para distribuição', 'trend' => null, 'trendType' => 'up', 'icon' => 'inventory-2-o', 'tone' => 'rose'],
                ['label' => 'Estoque mínimo', 'value' => $this->quantity($material->estoque_minimo, $material->unidade_medida), 'context' => 'Limite operacional recomendado', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => $status === 'Normal' ? 'blue' : 'amber'],
                ['label' => 'Demanda mensal', 'value' => $this->quantity($this->monthlyDemand($material), $material->unidade_medida), 'context' => 'Saídas dos últimos 30 dias', 'trend' => null, 'trendType' => 'up', 'icon' => 'volunteer-activism-o', 'tone' => 'green'],
                ['label' => 'Situação', 'value' => $status, 'context' => $this->lastMovementText($material), 'trend' => null, 'trendType' => $status === 'Normal' ? 'up' : 'down', 'icon' => 'check', 'tone' => $status === 'Crítico' ? 'amber' : 'blue'],
            ],
            'movements' => $this->movements($material),
            'distributions' => $this->distributions($material),
            'history' => $this->history($material),
        ];
    }

    public function formOptions(): array
    {
        $materialBalances = $this->materialsWithBalance();

        return [
            'categories' => CategoriaMaterial::where('ativo', true)
                ->orderBy('nome')
                ->get()
                ->map(fn (CategoriaMaterial $category) => ['value' => $category->id, 'label' => $category->nome])
                ->all(),
            'materials' => $materialBalances
                ->map(fn (array $material) => ['value' => $material['id'], 'label' => $material['description']])
                ->values()
                ->all(),
            'materialBalances' => $materialBalances
                ->mapWithKeys(fn (array $material) => [
                    $material['id'] => [
                        'available' => $material['balance'],
                        'unit' => $material['unit'],
                    ],
                ])
                ->all(),
            'donors' => Doador::orderBy('nome')
                ->get()
                ->map(fn (Doador $donor) => ['value' => $donor->id, 'label' => $donor->nome])
                ->all(),
            'beneficiaries' => Beneficiaria::where('situacao', 'ativo')
                ->orderBy('nome')
                ->get()
                ->map(fn (Beneficiaria $beneficiary) => ['value' => $beneficiary->id, 'label' => $beneficiary->nome])
                ->all(),
        ];
    }

    public function createMaterial(array $data): Material
    {
        return Material::create($data);
    }

    public function createDonor(array $data): Doador
    {
        return Doador::create($data);
    }

    public function createDonation(array $data, int $userId): Doacao
    {
        return DB::transaction(function () use ($data, $userId) {
            $donation = Doacao::create([
                'id_doador' => $data['id_doador'],
                'id_usuario' => $userId,
                'data_doacao' => $data['data_doacao'],
                'observacao' => $data['observacao'] ?? null,
                'situacao' => $data['situacao'],
            ]);

            foreach ($this->cleanItems($data['items']) as $itemData) {
                $item = $donation->itens()->create($itemData);

                if ($donation->situacao === 'recebida') {
                    $this->movement([
                        'id_material' => $item->id_material,
                        'tipo' => 'entrada',
                        'quantidade' => $item->quantidade,
                        'data_hora' => $donation->data_doacao,
                        'id_usuario' => $userId,
                        'id_doacao_item' => $item->id,
                        'observacao' => 'Entrada por doação.',
                    ]);
                }
            }

            return $donation->refresh();
        });
    }

    public function createDistribution(array $data, int $userId): Distribuicao
    {
        return DB::transaction(function () use ($data, $userId) {
            $items = $this->cleanItems($data['items']);

            if ($data['situacao'] !== 'cancelada') {
                $this->ensureStock($items);
            }

            $distribution = Distribuicao::create([
                'id_beneficiaria' => $data['id_beneficiaria'],
                'id_usuario' => $userId,
                'data_hora' => $data['data_hora'],
                'situacao' => $data['situacao'],
                'observacao' => $data['observacao'] ?? null,
            ]);

            foreach ($items as $itemData) {
                $item = $distribution->itens()->create($itemData);

                if ($distribution->situacao !== 'cancelada') {
                    $this->movement([
                        'id_material' => $item->id_material,
                        'tipo' => 'saida',
                        'quantidade' => $item->quantidade,
                        'data_hora' => $distribution->data_hora,
                        'id_usuario' => $userId,
                        'id_distribuicao_item' => $item->id,
                        'observacao' => 'Saída por distribuição.',
                    ]);
                }
            }

            return $distribution->refresh();
        });
    }

    private function materialsWithBalance(): Collection
    {
        return Material::with(['categoria', 'movimentacoes.distribuicaoItem.distribuicao'])
            ->orderBy('nome')
            ->get()
            ->map(function (Material $material) {
                $balance = $this->balance($material);

                return [
                    'id' => $material->id,
                    'category_id' => $material->id_categoria,
                    'description' => $material->nome,
                    'category' => $material->categoria?->nome ?? '-',
                    'balance' => $balance,
                    'unit' => $material->unidade_medida,
                    'minimum' => $material->estoque_minimo,
                    'used' => $this->used($material),
                    'status' => $this->status($balance, $material->estoque_minimo),
                    'last_movement' => $this->lastMovementText($material),
                ];
            });
    }

    private function materialRow(array $material): array
    {
        return [
            'description' => $material['description'],
            'category' => $material['category'],
            'quantity' => $this->quantity($material['balance'], $material['unit']),
            'status' => $material['status'],
            'last_movement' => $material['last_movement'],
            '_actions' => [
                'view' => route('donations.show', $material['id']),
                'items' => [
                    ['icon' => 'visibility-o', 'route' => route('donations.show', $material['id']), 'title' => 'Visualizar material'],
                    ['icon' => 'volunteer-activism-o', 'route' => route('donations.distributions.create', ['material' => $material['id']]), 'title' => 'Distribuir'],
                ],
            ],
        ];
    }

    private function kpis(): array
    {
        $balances = $this->materialsWithBalance();
        $monthStart = now()->startOfMonth();

        return [
            ['label' => 'Itens em estoque', 'value' => $balances->sum('balance'), 'context' => 'Unidades disponíveis para distribuição', 'trend' => null, 'trendType' => 'up', 'icon' => 'inventory-2-o', 'tone' => 'rose'],
            ['label' => 'Doações no mês', 'value' => Doacao::where('situacao', 'recebida')->where('data_doacao', '>=', $monthStart)->count(), 'context' => 'Entradas registradas no mês', 'trend' => null, 'trendType' => 'up', 'icon' => 'card-giftcard-o', 'tone' => 'green'],
            ['label' => 'Distribuições', 'value' => Distribuicao::where('situacao', 'entregue')->where('data_hora', '>=', $monthStart)->count(), 'context' => 'Entregas realizadas no mês', 'trend' => null, 'trendType' => 'up', 'icon' => 'volunteer-activism-o', 'tone' => 'blue'],
            ['label' => 'Itens críticos', 'value' => $balances->where('status', 'Crítico')->count(), 'context' => 'Abaixo de metade do mínimo', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => 'amber'],
        ];
    }

    private function stockByCategory(): array
    {
        return $this->materialsWithBalance()
            ->groupBy('category')
            ->map(fn (Collection $items, string $category) => [
                'label' => $category,
                'available' => $items->sum('balance'),
                'used' => $items->sum('used'),
                'minimum' => $items->sum('minimum'),
            ])
            ->values()
            ->all();
    }

    private function totalStock(): int
    {
        return $this->materialsWithBalance()->sum('balance');
    }

    private function alerts(): array
    {
        return $this->materialsWithBalance()
            ->whereIn('status', ['Crítico', 'Baixo'])
            ->take(3)
            ->map(fn (array $item) => [
                'title' => "{$item['description']} com estoque {$item['status']}",
                'description' => $this->quantity($item['balance'], $item['unit']).' disponíveis para mínimo de '.$this->quantity($item['minimum'], $item['unit']).'.',
                'tone' => $item['status'] === 'Crítico' ? 'red' : 'amber',
            ])
            ->values()
            ->all();
    }

    private function recentMovements(): array
    {
        return EstoqueMovimentacao::with(['material', 'usuario'])
            ->latest('data_hora')
            ->take(5)
            ->get()
            ->map(fn (EstoqueMovimentacao $movement) => [
                'time' => $movement->data_hora?->format('H:i') ?? '-',
                'title' => $this->movementTypeLabel($movement->tipo).' de '.$this->quantity($movement->quantidade, $movement->material?->unidade_medida ?? 'un.').' em '.$movement->material?->nome.'.',
                'meta' => 'Registro por '.($movement->usuario?->nome ?? '-'),
            ])
            ->all();
    }

    private function movements(Material $material): array
    {
        return $material->movimentacoes
            ->sortByDesc('data_hora')
            ->map(fn (EstoqueMovimentacao $movement) => [
                'date' => $movement->data_hora?->format('d/m/Y H:i') ?? '-',
                'type' => $this->movementTypeLabel($movement->tipo),
                'quantity' => $this->quantity($movement->quantidade, $material->unidade_medida),
                'origin' => filled($movement->id_doacao_item) ? 'Doação' : (filled($movement->id_distribuicao_item) ? 'Distribuição' : 'Ajuste'),
                'responsible' => $movement->usuario?->nome ?? '-',
                'status' => $movement->tipo === 'entrada' ? 'Entrada' : 'Saída',
            ])
            ->values()
            ->all();
    }

    private function distributions(Material $material): array
    {
        return $material->distribuicaoItens
            ->sortByDesc(fn ($item) => $item->distribuicao?->data_hora)
            ->map(fn ($item) => [
                'date' => $item->distribuicao?->data_hora?->format('d/m/Y') ?? '-',
                'beneficiary' => $item->distribuicao?->beneficiaria?->nome ?? '-',
                'quantity' => $this->quantity($item->quantidade, $material->unidade_medida),
                'responsible' => $item->distribuicao?->usuario?->nome ?? '-',
                'status' => $this->distributionStatusLabel($item->distribuicao?->situacao),
            ])
            ->values()
            ->all();
    }

    private function history(Material $material): array
    {
        return $material->movimentacoes
            ->sortByDesc('data_hora')
            ->take(10)
            ->map(fn (EstoqueMovimentacao $movement) => [
                'date' => $movement->data_hora?->format('d/m/Y') ?? '-',
                'type' => $this->movementTypeLabel($movement->tipo).' registrada',
                'description' => $movement->observacao ?: 'Movimentação de estoque.',
                'responsible' => $movement->usuario?->nome ?? '-',
                'icon' => $movement->tipo === 'entrada' ? 'card-giftcard-o' : 'volunteer-activism-o',
            ])
            ->values()
            ->all();
    }

    private function ensureStock(array $items): void
    {
        foreach (collect($items)->groupBy('id_material') as $materialId => $materialItems) {
            $material = Material::with('movimentacoes.distribuicaoItem.distribuicao')->findOrFail($materialId);
            $requested = $materialItems->sum('quantidade');
            $available = $this->balance($material);

            if ($available < $requested) {
                throw ValidationException::withMessages([
                    'items' => 'Saldo insuficiente para '.$material->nome.'. Disponível: '.$available.', solicitado: '.$requested.'.',
                ]);
            }
        }
    }

    private function cleanItems(array $items): array
    {
        return collect($items)
            ->filter(fn (array $item) => filled($item['id_material'] ?? null) && filled($item['quantidade'] ?? null))
            ->map(fn (array $item) => [
                'id_material' => (int) $item['id_material'],
                'quantidade' => (int) $item['quantidade'],
                'observacao' => $item['observacao'] ?? null,
            ])
            ->values()
            ->all();
    }

    private function movement(array $data): EstoqueMovimentacao
    {
        return EstoqueMovimentacao::create($data);
    }

    private function balance(Material $material): int
    {
        return $material->movimentacoes->sum(fn (EstoqueMovimentacao $movement) => match ($movement->tipo) {
            'entrada' => $movement->quantidade,
            'saida' => $this->movementAffectsStock($movement) ? -$movement->quantidade : 0,
            'ajuste' => $movement->quantidade,
            default => 0,
        });
    }

    private function used(Material $material): int
    {
        return $material->movimentacoes
            ->where('tipo', 'saida')
            ->filter(fn (EstoqueMovimentacao $movement) => $this->movementAffectsStock($movement))
            ->sum('quantidade');
    }

    private function status(int $balance, int $minimum): string
    {
        if ($balance <= max(0, (int) floor($minimum / 2))) {
            return 'Crítico';
        }

        return $balance < $minimum ? 'Baixo' : 'Normal';
    }

    private function monthlyDemand(Material $material): int
    {
        return $material->movimentacoes
            ->where('tipo', 'saida')
            ->filter(fn (EstoqueMovimentacao $movement) => $this->movementAffectsStock($movement))
            ->where('data_hora', '>=', now()->subDays(30))
            ->sum('quantidade');
    }

    private function movementAffectsStock(EstoqueMovimentacao $movement): bool
    {
        return $movement->distribuicaoItem?->distribuicao?->situacao !== 'cancelada';
    }

    private function lastMovementText(Material $material): string
    {
        $movement = $material->movimentacoes->sortByDesc('data_hora')->first();

        if (! $movement) {
            return 'Sem movimentação';
        }

        return $this->movementTypeLabel($movement->tipo).' em '.$movement->data_hora?->format('d/m/Y');
    }

    private function quantity(int $amount, string $unit): string
    {
        return $amount.' '.$unit.($amount === 1 || str_ends_with($unit, 's') ? '' : 's');
    }

    private function movementTypeLabel(string $type): string
    {
        return ['entrada' => 'Entrada', 'saida' => 'Saída', 'ajuste' => 'Ajuste'][$type] ?? $type;
    }

    private function distributionStatusLabel(?string $status): string
    {
        return ['pendente' => 'Pendente', 'entregue' => 'Distribuído', 'cancelada' => 'Cancelado'][$status] ?? '-';
    }
}
