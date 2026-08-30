<?php

namespace App\Services;

use App\Models\Beneficiaria;
use App\Models\CategoriaMaterial;
use App\Models\Distribuicao;
use App\Models\Doacao;
use App\Models\Doador;
use App\Models\EstoqueMovimentacao;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementService
{
    public function indexData(?string $search, string $type): array
    {
        $query = EstoqueMovimentacao::with([
            'material',
            'usuario',
            'doacaoItem.doacao.doador',
            'distribuicaoItem.distribuicao.beneficiaria',
        ])->latest('data_hora');

        if ($type !== 'all') {
            $query->where('tipo', $type);
        }

        $movements = $query->get()
            ->filter(fn (EstoqueMovimentacao $movement) => $search === '' || str_contains(mb_strtolower($this->rowSearchText($movement)), mb_strtolower($search)))
            ->map(fn (EstoqueMovimentacao $movement) => $this->movementRow($movement))
            ->values()
            ->all();

        return [
            'movements' => $movements,
            'search' => $search,
            'type' => $type,
        ];
    }

    public function createData(string $movementType, ?int $selectedMaterial): array
    {
        return [
            ...$this->formOptions(),
            'movementType' => in_array($movementType, ['entrada', 'saida', 'ajuste'], true) ? $movementType : null,
            'selectedMaterial' => $selectedMaterial,
        ];
    }

    public function showData(EstoqueMovimentacao $movement): array
    {
        $movement->load([
            'material.categoria',
            'usuario',
            'doacaoItem.doacao.doador',
            'distribuicaoItem.distribuicao.beneficiaria',
        ]);

        return [
            'movement' => $movement,
            'summary' => [
                'title' => 'Movimentação #'.$movement->id,
                'type' => $this->typeLabel($movement->tipo),
                'date' => $movement->data_hora?->format('d/m/Y H:i') ?? '-',
                'origin' => $this->originLabel($movement),
                'responsible' => $movement->usuario?->nome ?? '-',
                'status' => $this->statusLabel($movement),
                'observation' => $movement->observacao ?: '-',
            ],
            'items' => [[
                'material' => $movement->material?->nome ?? '-',
                'category' => $movement->material?->categoria?->nome ?? '-',
                'quantity' => $this->quantity($movement->quantidade, $movement->material?->unidade_medida ?? 'un.'),
                'status' => $this->typeLabel($movement->tipo),
            ]],
        ];
    }

    public function create(array $data, int $userId): EstoqueMovimentacao
    {
        return match ($data['tipo']) {
            'entrada' => $this->createEntry($data, $userId),
            'saida' => $this->createExit($data, $userId),
            'ajuste' => $this->createAdjustment($data, $userId),
        };
    }

    private function formOptions(): array
    {
        $materials = Material::orderBy('nome')->get();

        return [
            'categories' => CategoriaMaterial::where('ativo', true)
                ->orderBy('nome')
                ->get()
                ->map(fn (CategoriaMaterial $category) => ['value' => $category->id, 'label' => $category->nome])
                ->all(),
            'materials' => $materials
                ->map(fn (Material $material) => ['value' => $material->id, 'label' => $material->nome])
                ->all(),
            'materialBalances' => $materials
                ->mapWithKeys(fn (Material $material) => [
                    $material->id => [
                        'available' => $material->movimentacoes()->get()->sum(fn (EstoqueMovimentacao $movement) => $this->balanceImpact($movement)),
                        'unit' => $material->unidade_medida,
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

    private function createEntry(array $data, int $userId): EstoqueMovimentacao
    {
        return DB::transaction(function () use ($data, $userId) {
            if (! filled($data['id_doador'] ?? null)) {
                return $this->createDirectEntry($data, $userId);
            }

            $donation = Doacao::create([
                'id_doador' => $data['id_doador'],
                'id_usuario' => $userId,
                'data_doacao' => $data['data_hora'],
                'observacao' => $data['observacao'] ?? null,
                'situacao' => $data['situacao'] ?? 'recebida',
            ]);

            $firstMovement = null;

            foreach ($this->cleanItems($data['items']) as $itemData) {
                $item = $donation->itens()->create($itemData);

                if ($donation->situacao !== 'recebida') {
                    continue;
                }

                $movement = EstoqueMovimentacao::create([
                    'id_material' => $item->id_material,
                    'tipo' => 'entrada',
                    'quantidade' => $item->quantidade,
                    'data_hora' => $donation->data_doacao,
                    'id_usuario' => $userId,
                    'id_doacao_item' => $item->id,
                    'observacao' => 'Entrada por doação.',
                ]);

                $firstMovement ??= $movement;
            }

            return $firstMovement ?? EstoqueMovimentacao::create([
                'id_material' => $donation->itens()->firstOrFail()->id_material,
                'tipo' => 'entrada',
                'quantidade' => 0,
                'data_hora' => $donation->data_doacao,
                'id_usuario' => $userId,
                'observacao' => 'Doação cancelada.',
            ]);
        });
    }

    private function createDirectEntry(array $data, int $userId): EstoqueMovimentacao
    {
        if (($data['situacao'] ?? 'recebida') !== 'recebida') {
            throw ValidationException::withMessages([
                'id_doador' => 'Informe um doador para manter entradas canceladas no histórico de doações.',
            ]);
        }

        $firstMovement = null;

        foreach ($this->cleanItems($data['items']) as $itemData) {
            $movement = EstoqueMovimentacao::create([
                'id_material' => $itemData['id_material'],
                'tipo' => 'entrada',
                'quantidade' => $itemData['quantidade'],
                'data_hora' => $data['data_hora'],
                'id_usuario' => $userId,
                'observacao' => $itemData['observacao'] ?: ($data['observacao'] ?? 'Entrada sem doador informado.'),
            ]);

            $firstMovement ??= $movement;
        }

        return $firstMovement;
    }

    private function createExit(array $data, int $userId): EstoqueMovimentacao
    {
        return DB::transaction(function () use ($data, $userId) {
            $items = $this->cleanItems($data['items']);
            $status = $data['situacao'] ?? 'entregue';

            if ($status !== 'cancelada') {
                $this->ensureStock($items);
            }

            $distribution = Distribuicao::create([
                'id_beneficiaria' => $data['id_beneficiaria'],
                'id_usuario' => $userId,
                'data_hora' => $data['data_hora'],
                'situacao' => $status,
                'observacao' => $data['observacao'] ?? null,
            ]);

            $firstMovement = null;

            foreach ($items as $itemData) {
                $item = $distribution->itens()->create($itemData);

                if ($distribution->situacao === 'cancelada') {
                    continue;
                }

                $movement = EstoqueMovimentacao::create([
                    'id_material' => $item->id_material,
                    'tipo' => 'saida',
                    'quantidade' => $item->quantidade,
                    'data_hora' => $distribution->data_hora,
                    'id_usuario' => $userId,
                    'id_distribuicao_item' => $item->id,
                    'observacao' => 'Saída por movimentação.',
                ]);

                $firstMovement ??= $movement;
            }

            return $firstMovement ?? EstoqueMovimentacao::create([
                'id_material' => $distribution->itens()->firstOrFail()->id_material,
                'tipo' => 'saida',
                'quantidade' => 0,
                'data_hora' => $distribution->data_hora,
                'id_usuario' => $userId,
                'observacao' => 'Saída cancelada.',
            ]);
        });
    }

    private function createAdjustment(array $data, int $userId): EstoqueMovimentacao
    {
        $material = Material::with('movimentacoes.distribuicaoItem.distribuicao')->findOrFail($data['id_material']);
        $quantity = (int) $data['quantidade'];

        if ($data['operacao'] === 'subtrair') {
            $available = $this->balance($material);

            if ($available < $quantity) {
                throw ValidationException::withMessages([
                    'quantidade' => 'Saldo insuficiente para '.$material->nome.'. Disponível: '.$available.', solicitado: '.$quantity.'.',
                ]);
            }

            $quantity *= -1;
        }

        return EstoqueMovimentacao::create([
            'id_material' => $material->id,
            'tipo' => 'ajuste',
            'quantidade' => $quantity,
            'data_hora' => $data['data_hora'],
            'id_usuario' => $userId,
            'observacao' => $data['observacao'],
        ]);
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

    private function movementRow(EstoqueMovimentacao $movement): array
    {
        return [
            'date' => $movement->data_hora?->format('d/m/Y H:i') ?? '-',
            'type' => $this->typeLabel($movement->tipo),
            'origin' => $this->originLabel($movement),
            'materials' => $movement->material?->nome ?? '-',
            'responsible' => $movement->usuario?->nome ?? '-',
            'status' => $this->statusLabel($movement),
            '_actions' => [
                'view' => route('movements.show', $movement),
                'items' => [
                    ['icon' => 'visibility-o', 'route' => route('movements.show', $movement), 'title' => 'Visualizar movimentação'],
                ],
            ],
        ];
    }

    private function rowSearchText(EstoqueMovimentacao $movement): string
    {
        return implode(' ', [
            $movement->material?->nome,
            $movement->usuario?->nome,
            $this->originLabel($movement),
            $this->typeLabel($movement->tipo),
        ]);
    }

    private function originLabel(EstoqueMovimentacao $movement): string
    {
        if ($movement->doacaoItem) {
            return $movement->doacaoItem->doacao?->doador?->nome ?? 'Doação';
        }

        if ($movement->distribuicaoItem) {
            return $movement->distribuicaoItem->distribuicao?->beneficiaria?->nome ?? 'Saída';
        }

        return match ($movement->tipo) {
            'entrada' => 'Entrada direta',
            'ajuste' => 'Ajuste manual',
            default => $this->typeLabel($movement->tipo),
        };
    }

    private function statusLabel(EstoqueMovimentacao $movement): string
    {
        if ($movement->doacaoItem) {
            return ucfirst($movement->doacaoItem->doacao?->situacao ?? 'recebida');
        }

        if ($movement->distribuicaoItem) {
            return match ($movement->distribuicaoItem->distribuicao?->situacao) {
                'pendente' => 'Pendente',
                'entregue' => 'Entregue',
                'cancelada' => 'Cancelado',
                default => '-',
            };
        }

        return match ($movement->tipo) {
            'entrada' => 'Entrada',
            'ajuste' => 'Ajuste',
            default => '-',
        };
    }

    private function typeLabel(string $type): string
    {
        return ['entrada' => 'Entrada', 'saida' => 'Saída', 'ajuste' => 'Ajuste'][$type] ?? $type;
    }

    private function quantity(int $amount, string $unit): string
    {
        $absolute = abs($amount);

        return $absolute.' '.$unit.($absolute === 1 || str_ends_with($unit, 's') ? '' : 's');
    }

    private function balanceImpact(EstoqueMovimentacao $movement): int
    {
        return match ($movement->tipo) {
            'entrada' => $movement->quantidade,
            'saida' => $this->movementAffectsStock($movement) ? -$movement->quantidade : 0,
            'ajuste' => $movement->quantidade,
            default => 0,
        };
    }

    private function balance(Material $material): int
    {
        return $material->movimentacoes->sum(fn (EstoqueMovimentacao $movement) => $this->balanceImpact($movement));
    }

    private function movementAffectsStock(EstoqueMovimentacao $movement): bool
    {
        return $movement->distribuicaoItem?->distribuicao?->situacao !== 'cancelada';
    }
}
