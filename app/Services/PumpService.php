<?php

namespace App\Services;

use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use App\Models\Doador;
use App\Models\ManutencaoBomba;
use App\Models\ModeloBomba;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PumpService
{
    public function search(?string $search, string $status, string $model): Collection
    {
        return $this->baseQuery()
            ->when($status !== 'all' && $status !== 'overdue', fn (Builder $query) => $query->where('bomba_leite.situacao', $status))
            ->when($status === 'overdue', fn (Builder $query) => $query->whereHas('cessoes', fn (Builder $query) => $query->whereIn('situacao', ['ativa', 'atrasada'])->whereNull('data_devolucao')->whereDate('data_prevista_devolucao', '<', now()->toDateString())))
            ->when($model !== 'all', fn (Builder $query) => $query->where('bomba_leite.id_modelo', $model))
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('bomba_leite.codigo', 'like', "%{$search}%")
                        ->orWhere('bomba_leite.num_serie', 'like', "%{$search}%")
                        ->orWhereHas('modelo', fn (Builder $query) => $query->where('modelo', 'like', "%{$search}%")->orWhere('fabricante', 'like', "%{$search}%"))
                        ->orWhereHas('cessoes.beneficiaria', fn (Builder $query) => $query->where('nome', 'like', "%{$search}%"));
                });
            })
            ->orderBy('bomba_leite.codigo')
            ->get()
            ->map(fn (BombaLeite $pump) => $this->tableRow($pump));
    }

    public function kpis(): array
    {
        $activeLoans = CessaoBomba::whereIn('situacao', ['ativa', 'atrasada'])->count();
        $overdueLoans = $this->overdueLoans()->count();

        return [
            ['label' => 'Bombas cadastradas', 'value' => BombaLeite::where('situacao', '!=', 'baixada')->count(), 'context' => 'Equipamentos ativos no sistema', 'trend' => null, 'trendType' => 'up', 'icon' => 'coffee-maker-o', 'tone' => 'rose'],
            ['label' => 'Disponíveis', 'value' => BombaLeite::where('situacao', 'disponivel')->count(), 'context' => 'Prontas para novo empréstimo', 'trend' => null, 'trendType' => 'up', 'icon' => 'check', 'tone' => 'green'],
            ['label' => 'Emprestadas', 'value' => $activeLoans, 'context' => 'Em uso por beneficiárias', 'trend' => null, 'trendType' => 'up', 'icon' => 'trending-up', 'tone' => 'blue'],
            ['label' => 'Devoluções atrasadas', 'value' => $overdueLoans, 'context' => 'Exigem contato da equipe', 'trend' => null, 'trendType' => $overdueLoans > 0 ? 'down' : 'up', 'icon' => 'report-problem-o', 'tone' => 'amber'],
        ];
    }

    public function formOptions(): array
    {
        return [
            'models' => ModeloBomba::orderBy('fabricante')->orderBy('modelo')->get()->mapWithKeys(fn (ModeloBomba $model) => [$model->id => $this->modelName($model)])->all(),
            'donors' => Doador::orderBy('nome')->pluck('nome', 'id')->all(),
            'statuses' => $this->statuses(),
            'origins' => $this->origins(),
        ];
    }

    public function create(array $data): BombaLeite
    {
        return BombaLeite::create($this->attributes($data));
    }

    public function update(BombaLeite $pump, array $data): BombaLeite
    {
        $pump->update($this->attributes($data));

        return $pump->refresh();
    }

    public function renewLoan(BombaLeite $pump, string $expiresAt): CessaoBomba
    {
        $loan = $pump->cessoes()
            ->whereIn('situacao', ['ativa', 'atrasada'])
            ->latest('data_retirada')
            ->first();

        abort_unless($loan, 409);

        $loan->update([
            'data_prevista_devolucao' => $expiresAt,
            'situacao' => 'ativa',
            'observacao_retirada' => collect([$loan->observacao_retirada, 'Renovado em '.now()->format('d/m/Y').' até '.Carbon::parse($expiresAt)->format('d/m/Y')])->filter()->join("\n"),
        ]);
        $pump->update(['situacao' => 'alugada']);

        return $loan->refresh();
    }

    public function destroy(BombaLeite $pump): bool
    {
        if ($pump->cessoes()->exists() || $pump->manutencoes()->exists()) {
            $pump->update(['situacao' => 'baixada']);

            return false;
        }

        $pump->delete();

        return true;
    }

    public function showData(BombaLeite $pump): array
    {
        $pump->load(['modelo', 'doador', 'cessoes.beneficiaria', 'cessoes.usuarioRetirada', 'cessoes.pagamentos', 'manutencoes.usuario']);
        $currentContract = $this->currentContract($pump);
        $isAvailable = $pump->situacao === 'disponivel';
        $isRental = $currentContract?->tipo === 'aluguel';

        return [
            'pump' => $pump,
            'pumpData' => [
                'code' => $pump->codigo,
                'model' => $this->modelName($pump->modelo),
                'serial_number' => $pump->num_serie ?: '-',
                'status' => $this->statusLabel($pump->situacao, $currentContract),
                'location' => $currentContract ? 'Com beneficiária' : 'Estoque',
                'kit_status' => filled($pump->acessorios) ? 'Com acessórios registrados' : 'Sem acessórios registrados',
                'last_sanitized_at' => $this->lastSanitization($pump),
                'next_maintenance_at' => $this->nextMaintenance($pump),
                'registered_at' => $pump->data_aquisicao?->format('d/m/Y') ?? '-',
                'origin' => $this->originLabel($pump->origem),
                'accessories' => $pump->acessorios ?: '-',
            ],
            'currentContract' => $currentContract ? $this->contractData($currentContract) : null,
            'kpis' => [
                ['label' => 'Situação atual', 'value' => $this->statusLabel($pump->situacao, $currentContract), 'context' => $isAvailable ? 'Pronta para nova saída' : 'Contrato ativo ou manutenção', 'trend' => null, 'trendType' => $isAvailable ? 'up' : 'down', 'icon' => 'check', 'tone' => $isAvailable ? 'green' : 'blue'],
                ['label' => 'Expiração', 'value' => $currentContract?->data_prevista_devolucao?->format('d/m/Y') ?? '-', 'context' => $currentContract ? 'Data prevista de devolução' : 'Sem contrato ativo', 'trend' => null, 'trendType' => 'down', 'icon' => 'calendar-month-o', 'tone' => $currentContract ? 'amber' : 'green'],
                ['label' => 'Histórico de saídas', 'value' => $pump->cessoes->count(), 'context' => 'Empréstimos e aluguéis registrados', 'trend' => null, 'trendType' => 'up', 'icon' => 'autorenew', 'tone' => 'rose'],
                ['label' => 'Mensalidade', 'value' => $isRental ? $this->money($currentContract->valor_mensalidade) : '-', 'context' => $isRental ? 'Aluguel ativo' : 'Sem cobrança recorrente', 'trend' => null, 'trendType' => 'up', 'icon' => 'receipt', 'tone' => $isRental ? 'blue' : 'green'],
            ],
            'loanHistory' => $this->loanHistory($pump),
            'payments' => $this->payments($pump),
            'maintenanceHistory' => $this->maintenanceHistory($pump),
            'history' => $this->history($pump),
        ];
    }

    public function editData(BombaLeite $pump): array
    {
        $pump->load('cessoes');

        return [
            'pump' => $pump,
            'pumpData' => [
                'codigo' => $pump->codigo,
                'id_modelo' => $pump->id_modelo,
                'num_serie' => $pump->num_serie,
                'situacao' => $pump->cessoes()->whereIn('situacao', ['ativa', 'atrasada'])->exists() ? 'alugada' : $pump->situacao,
                'data_aquisicao' => $pump->data_aquisicao?->format('Y-m-d'),
                'origem' => $pump->origem,
                'id_doador' => $pump->id_doador,
                'acessorios' => $pump->acessorios,
            ],
            'hasActiveLoan' => $pump->cessoes()->whereIn('situacao', ['ativa', 'atrasada'])->exists(),
            ...$this->formOptions(),
        ];
    }

    public function emptyData(): array
    {
        return [
            'pumpData' => [
                'codigo' => '',
                'id_modelo' => '',
                'num_serie' => '',
                'situacao' => 'disponivel',
                'data_aquisicao' => '',
                'origem' => 'doacao',
                'id_doador' => '',
                'acessorios' => '',
            ],
            'hasActiveLoan' => false,
            ...$this->formOptions(),
        ];
    }

    public function modelFilters(): array
    {
        return ModeloBomba::orderBy('fabricante')->orderBy('modelo')->get()->map(fn (ModeloBomba $model) => ['value' => $model->id, 'label' => $this->modelName($model)])->all();
    }

    private function baseQuery(): Builder
    {
        return BombaLeite::query()->with(['modelo', 'cessoes' => fn ($query) => $query->with('beneficiaria')->whereIn('situacao', ['ativa', 'atrasada'])->latest('data_retirada')]);
    }

    private function tableRow(BombaLeite $pump): array
    {
        $loan = $this->currentContract($pump);

        return [
            'code' => $pump->codigo,
            'model' => $this->modelName($pump->modelo),
            'beneficiary' => $loan?->beneficiaria?->nome ?? '-',
            'withdrawn_at' => $loan?->data_retirada?->format('d/m/Y') ?? '-',
            'expected_return' => $loan?->data_prevista_devolucao?->format('d/m/Y') ?? '-',
            'status' => $this->statusLabel($pump->situacao, $loan),
            '_actions' => [
                'view' => route('pumps.show', $pump),
                'items' => [
                    ['icon' => 'visibility-o', 'route' => route('pumps.show', $pump), 'title' => 'Visualizar bomba'],
                    ['icon' => 'edit-o', 'route' => route('pumps.edit', $pump), 'title' => 'Editar bomba'],
                    ['icon' => 'delete-o', 'route' => route('pumps.destroy', $pump), 'title' => 'Excluir bomba', 'variant' => 'danger', 'confirmation' => ['method' => 'DELETE']],
                ],
            ],
        ];
    }

    private function attributes(array $data): array
    {
        return collect($data)->only(['codigo', 'id_modelo', 'num_serie', 'situacao', 'data_aquisicao', 'origem', 'id_doador', 'acessorios'])->all();
    }

    private function currentContract(BombaLeite $pump): ?CessaoBomba
    {
        return $pump->cessoes
            ->whereIn('situacao', ['ativa', 'atrasada'])
            ->sortByDesc('data_retirada')
            ->first();
    }

    private function overdueLoans(): Collection
    {
        return CessaoBomba::whereIn('situacao', ['ativa', 'atrasada'])
            ->whereNull('data_devolucao')
            ->whereDate('data_prevista_devolucao', '<', now()->toDateString())
            ->get();
    }

    private function contractData(CessaoBomba $contract): array
    {
        $isOverdue = $contract->data_prevista_devolucao?->isPast() && ! $contract->data_devolucao;

        return [
            'id' => $contract->id,
            'type' => $contract->tipo === 'aluguel' ? 'Aluguel' : 'Empréstimo',
            'beneficiary' => $contract->beneficiaria?->nome ?? '-',
            'phone' => $contract->beneficiaria?->telefone ?? '-',
            'withdrawn_at' => $contract->data_retirada?->format('d/m/Y') ?? '-',
            'expires_at' => $contract->data_prevista_devolucao?->format('d/m/Y') ?? '-',
            'expires_at_input' => $contract->data_prevista_devolucao?->toDateString(),
            'renewal_min_date' => ($contract->data_prevista_devolucao?->isFuture() ? $contract->data_prevista_devolucao : now())->copy()->addDay()->toDateString(),
            'next_renewal_at' => $contract->data_prevista_devolucao?->copy()->subDays(3)->format('d/m/Y') ?? '-',
            'monthly_fee' => $contract->tipo === 'aluguel' ? $this->money($contract->valor_mensalidade) : 'Sem custo',
            'billing_due_day' => $contract->tipo === 'aluguel' ? 'Conforme vencimentos cadastrados' : '-',
            'responsible' => $contract->usuarioRetirada?->nome ?? '-',
            'term_status' => 'Registrado',
            'notes' => $contract->observacao_retirada ?: 'Bomba em uso por beneficiária.',
            'is_overdue' => $isOverdue,
            'is_renewable' => in_array($contract->situacao, ['ativa', 'atrasada'], true),
        ];
    }

    private function loanHistory(BombaLeite $pump): array
    {
        return $pump->cessoes
            ->sortByDesc('data_retirada')
            ->map(fn (CessaoBomba $loan) => [
                'period' => ($loan->data_retirada?->format('d/m/Y') ?? '-').' - '.($loan->data_devolucao?->format('d/m/Y') ?? ($loan->data_prevista_devolucao?->format('d/m/Y') ?? '-')),
                'type' => $loan->tipo === 'aluguel' ? 'Aluguel' : 'Empréstimo',
                'beneficiary' => $loan->beneficiaria?->nome ?? '-',
                'responsible' => $loan->usuarioRetirada?->nome ?? '-',
                'status' => $this->loanStatusLabel($loan->situacao),
            ])
            ->values()
            ->all();
    }

    private function payments(BombaLeite $pump): array
    {
        return $pump->cessoes
            ->flatMap->pagamentos
            ->sortByDesc('data_vencimento')
            ->map(fn ($payment) => [
                'date' => ($payment->data_pagamento ?? $payment->data_vencimento)?->format('d/m/Y') ?? '-',
                'reference' => $payment->competencia?->translatedFormat('m/Y') ?? '-',
                'method' => $payment->data_pagamento ? 'Registrado' : '-',
                'value' => $this->money($payment->valor),
                'status' => $this->paymentStatusLabel($payment->situacao),
            ])
            ->values()
            ->all();
    }

    private function maintenanceHistory(BombaLeite $pump): array
    {
        return $pump->manutencoes
            ->sortByDesc('data_inicio')
            ->map(fn (ManutencaoBomba $maintenance) => [
                'date' => $maintenance->data_inicio?->format('d/m/Y') ?? '-',
                'type' => $this->maintenanceTypeLabel($maintenance->tipo),
                'description' => $maintenance->descricao,
                'responsible' => $maintenance->usuario?->nome ?? '-',
                'status' => $this->maintenanceStatusLabel($maintenance->situacao),
            ])
            ->values()
            ->all();
    }

    private function history(BombaLeite $pump): array
    {
        $items = collect([
            ['date' => $pump->data_aquisicao, 'type' => 'Cadastro da bomba', 'description' => 'Equipamento registrado no sistema.', 'responsible' => $pump->doador?->nome ?? 'Equipe', 'icon' => 'milk'],
        ]);

        $loans = $pump->cessoes->map(fn (CessaoBomba $loan) => [
            'date' => $loan->data_retirada,
            'type' => 'Saída registrada',
            'description' => 'Bomba entregue para '.$this->loanTypeLabel($loan->tipo).'.',
            'responsible' => $loan->usuarioRetirada?->nome ?? '-',
            'icon' => 'arrow-up-right',
        ]);

        $maintenances = $pump->manutencoes->map(fn (ManutencaoBomba $maintenance) => [
            'date' => $maintenance->data_inicio,
            'type' => $this->maintenanceTypeLabel($maintenance->tipo),
            'description' => $maintenance->descricao,
            'responsible' => $maintenance->usuario?->nome ?? '-',
            'icon' => $maintenance->tipo === 'higienizacao' ? 'sparkles' : 'wrench',
        ]);

        return $items
            ->merge($loans)
            ->merge($maintenances)
            ->filter(fn (array $item) => $item['date'])
            ->sortByDesc('date')
            ->map(fn (array $item) => [
                ...$item,
                'date' => $item['date'] instanceof Carbon ? $item['date']->format('d/m/Y') : Carbon::parse($item['date'])->format('d/m/Y'),
            ])
            ->values()
            ->all();
    }

    private function lastSanitization(BombaLeite $pump): string
    {
        $maintenance = $pump->manutencoes->where('tipo', 'higienizacao')->where('situacao', 'concluida')->sortByDesc('data_fim')->first();

        return $maintenance?->data_fim?->format('d/m/Y') ?? '-';
    }

    private function nextMaintenance(BombaLeite $pump): string
    {
        $maintenance = $pump->manutencoes->whereIn('situacao', ['aberta', 'em_andamento'])->sortBy('data_inicio')->first();

        return $maintenance?->data_inicio?->format('d/m/Y') ?? '-';
    }

    private function modelName(?ModeloBomba $model): string
    {
        return $model ? trim($model->fabricante.' '.$model->modelo) : '-';
    }

    private function statusLabel(string $status, ?CessaoBomba $loan = null): string
    {
        if ($loan && $loan->data_prevista_devolucao?->isPast() && ! $loan->data_devolucao) {
            return 'Em atraso';
        }

        return $this->statuses()[$status] ?? $status;
    }

    private function statuses(): array
    {
        return ['disponivel' => 'Disponível', 'alugada' => 'Emprestada', 'manutencao' => 'Manutenção', 'baixada' => 'Inativa'];
    }

    private function origins(): array
    {
        return ['doacao' => 'Doação', 'compra' => 'Compra', 'emprestimo' => 'Empréstimo'];
    }

    private function originLabel(string $origin): string
    {
        return $this->origins()[$origin] ?? $origin;
    }

    private function loanTypeLabel(string $type): string
    {
        return $type === 'aluguel' ? 'aluguel' : 'empréstimo';
    }

    private function loanStatusLabel(string $status): string
    {
        return ['ativa' => 'Emprestada', 'finalizada' => 'Realizado', 'cancelada' => 'Cancelado', 'atrasada' => 'Em atraso'][$status] ?? $status;
    }

    private function paymentStatusLabel(string $status): string
    {
        return ['pendente' => 'Pendente', 'pago' => 'Pago', 'cancelado' => 'Cancelado', 'atrasado' => 'Em atraso'][$status] ?? $status;
    }

    private function maintenanceTypeLabel(string $type): string
    {
        return ['preventiva' => 'Preventiva', 'corretiva' => 'Corretiva', 'higienizacao' => 'Higienização'][$type] ?? $type;
    }

    private function maintenanceStatusLabel(string $status): string
    {
        return ['aberta' => 'Agendado', 'em_andamento' => 'Em andamento', 'concluida' => 'Realizado', 'cancelada' => 'Cancelado'][$status] ?? $status;
    }

    private function money(mixed $value): string
    {
        return $value ? 'R$ '.number_format((float) $value, 2, ',', '.') : 'Sem custo';
    }
}
