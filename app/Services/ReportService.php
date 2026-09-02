<?php

namespace App\Services;

use App\Models\Atendimento;
use App\Models\CessaoBomba;
use App\Models\Doacao;
use App\Models\Distribuicao;
use App\Models\EstoqueMovimentacao;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function indexData(array $filters): array
    {
        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();
        $section = $filters['section'];
        $location = $filters['location'];

        $attendanceQuery = $this->attendanceQuery($start, $end, $location);
        $stockCoverage = $this->stockCoverage($start, $end);
        $pumpStats = $this->pumpStats($start, $end);

        return [
            'startDate' => $start->toDateString(),
            'endDate' => $end->toDateString(),
            'section' => $section,
            'location' => $location,
            'locationOptions' => $this->locationOptions(),
            'reportKpis' => $this->kpis($start, $end, $attendanceQuery, $stockCoverage, $pumpStats),
            'pumpOverview' => $this->pumpOverview($pumpStats),
            'pumpContractChart' => $this->pumpContractChart($pumpStats),
            'pumpDueDates' => $this->pumpDueDates($start, $end),
            'attendanceModalityChart' => $this->attendanceModalityChart($attendanceQuery),
            'professionalChart' => $this->professionalChart($start, $end, $location),
            'stockCoverageChart' => $stockCoverage,
            'donationSources' => $this->donationSources($start, $end),
        ];
    }

    private function kpis(Carbon $start, Carbon $end, Builder $attendanceQuery, array $stockCoverage, array $pumpStats): array
    {
        $attendanceCount = (clone $attendanceQuery)->count();
        $previousAttendanceCount = $this->previousAttendanceCount($start, $end);
        $distributionCount = Distribuicao::where('situacao', 'entregue')->whereBetween('data_hora', [$start, $end])->count();
        $openPayments = DB::table('pagamentos_alugueis')
            ->whereIn('situacao', ['pendente', 'atrasado'])
            ->whereBetween('data_vencimento', [$start->toDateString(), $end->toDateString()])
            ->sum('valor');
        $criticalStock = collect($stockCoverage)->whereIn('details.Situação', ['Baixo', 'Crítico'])->count();

        return [
            [
                'label' => 'Atendimentos realizados',
                'value' => $attendanceCount,
                'context' => 'No período selecionado',
                'trend' => $this->signedPercent($attendanceCount, $previousAttendanceCount),
                'trendType' => $attendanceCount >= $previousAttendanceCount ? 'up' : 'down',
                'icon' => 'content-paste-o',
                'tone' => 'rose',
            ],
            [
                'label' => 'Bombas em uso',
                'value' => $pumpStats['active'],
                'context' => $pumpStats['free'].' empréstimos e '.$pumpStats['rentals'].' aluguéis',
                'trend' => $this->signedNumber($pumpStats['active']),
                'trendType' => $pumpStats['active'] > 0 ? 'up' : 'down',
                'icon' => 'inventory-2-o',
                'tone' => 'blue',
            ],
            [
                'label' => 'Distribuições registradas',
                'value' => $distributionCount,
                'context' => 'Materiais entregues às beneficiárias',
                'trend' => $this->signedNumber($distributionCount),
                'trendType' => $distributionCount > 0 ? 'up' : 'down',
                'icon' => 'volunteer-activism-o',
                'tone' => 'green',
            ],
            [
                'label' => 'Alertas críticos',
                'value' => $pumpStats['overdue'] + $criticalStock,
                'context' => 'Estoque, devoluções e pagamentos pendentes',
                'trend' => $this->money($openPayments),
                'trendType' => ($pumpStats['overdue'] + $criticalStock) > 0 ? 'down' : 'up',
                'icon' => 'report-problem-o',
                'tone' => 'amber',
            ],
        ];
    }

    private function pumpOverview(array $stats): array
    {
        return [
            [
                'label' => 'Gratuidade',
                'value' => $this->percent($stats['free'], max($stats['active'], 1)),
                'description' => $stats['free'].' de '.$stats['active'].' contratos ativos são empréstimos sem cobrança.',
                'tone' => 'bg-[#eefbf3] text-[#047857]',
            ],
            [
                'label' => 'Receita recorrente',
                'value' => $this->money($stats['revenue']),
                'description' => 'Valor previsto pelos aluguéis ativos neste período.',
                'tone' => 'bg-[#fff7ed] text-[#b45309]',
            ],
            [
                'label' => 'Risco de não devolução',
                'value' => $stats['overdue'],
                'description' => 'Bombas com devolução prevista vencida.',
                'tone' => 'bg-[#fdecef] text-[#bf2f63]',
            ],
        ];
    }

    private function pumpContractChart(array $stats): array
    {
        return [
            [
                'label' => 'Empréstimos',
                'value' => $stats['free'].' ativos',
                'percent' => $stats['active'] > 0 ? round(($stats['free'] / $stats['active']) * 100) : 0,
                'tone' => 'green',
                'description' => 'Contratos gratuitos em andamento.',
                'details' => ['No prazo' => $stats['freeOnTime'], 'Atrasos' => $stats['freeOverdue'], 'Receita' => 'Sem cobrança'],
            ],
            [
                'label' => 'Aluguéis',
                'value' => $stats['rentals'].' ativos',
                'percent' => $stats['active'] > 0 ? round(($stats['rentals'] / $stats['active']) * 100) : 0,
                'tone' => 'amber',
                'description' => 'Contratos com mensalidade registrada.',
                'details' => ['No prazo' => $stats['rentalsOnTime'], 'Atrasos' => $stats['rentalsOverdue'], 'Receita' => $this->money($stats['revenue'])],
            ],
        ];
    }

    private function pumpDueDates(Carbon $start, Carbon $end): array
    {
        return $this->pumpLoanPeriodQuery($start, $end)
            ->with(['bomba', 'beneficiaria'])
            ->orderBy('data_prevista_devolucao')
            ->limit(6)
            ->get()
            ->map(fn (CessaoBomba $loan) => [
                'pump' => $loan->bomba?->codigo ?? '-',
                'type' => $loan->tipo === 'aluguel' ? 'Aluguel' : 'Empréstimo',
                'beneficiary' => $loan->beneficiaria?->nome ?? '-',
                'expires_at' => ($loan->data_devolucao ?? $loan->data_prevista_devolucao)?->format('d/m/Y') ?? '-',
                'renewal_at' => $loan->data_prevista_devolucao?->copy()->subDays(7)->format('d/m/Y') ?? '-',
                'status' => $this->loanStatus($loan),
            ])
            ->all();
    }

    private function attendanceModalityChart(Builder $attendanceQuery): array
    {
        $counts = (clone $attendanceQuery)
            ->select('modalidade', DB::raw('COUNT(*) as total'))
            ->groupBy('modalidade')
            ->pluck('total', 'modalidade');
        $total = max((int) $counts->sum(), 1);

        return collect(['presencial' => 'Presencial', 'remota' => 'Remota'])
            ->map(fn (string $label, string $modality) => [
                'label' => $label,
                'value' => $this->percent((int) ($counts[$modality] ?? 0), $total),
                'percent' => round(((int) ($counts[$modality] ?? 0) / $total) * 100),
                'tone' => $modality === 'presencial' ? 'rose' : 'blue',
                'description' => (int) ($counts[$modality] ?? 0).' atendimentos realizados no período.',
                'details' => ['Acompanhamentos' => (int) ($counts[$modality] ?? 0), 'Tempo médio' => '-'],
            ])
            ->values()
            ->all();
    }

    private function professionalChart(Carbon $start, Carbon $end, string $location): array
    {
        $query = $this->attendanceQuery($start, $end, $location)
            ->join('usuarios', 'usuarios.id', '=', 'atendimentos.id_usuario')
            ->select('usuarios.id', 'usuarios.nome', DB::raw('COUNT(*) as total'))
            ->groupBy('usuarios.id', 'usuarios.nome')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $max = max((int) $query->max('total'), 1);

        return $query->map(function ($row) use ($start, $end, $max) {
            $distributions = Distribuicao::where('id_usuario', $row->id)
                ->whereBetween('data_hora', [$start, $end])
                ->count();

            return [
                'label' => $row->nome,
                'value' => (string) $row->total,
                'percent' => round(($row->total / $max) * 100),
                'tone' => 'green',
                'description' => 'Volume de atendimentos no período.',
                'details' => ['Retornos' => $row->total, 'Distribuições' => $distributions],
            ];
        })->all();
    }

    private function stockCoverage(Carbon $start, Carbon $end): array
    {
        $periodDays = max(1, $start->diffInDays($end) + 1);

        return Material::query()
            ->with('categoria')
            ->orderBy('nome')
            ->get()
            ->map(function (Material $material) use ($start, $end, $periodDays) {
                $available = EstoqueMovimentacao::where('id_material', $material->id)
                    ->where('data_hora', '<=', $end)
                    ->selectRaw("COALESCE(SUM(CASE WHEN tipo IN ('entrada', 'ajuste') THEN quantidade WHEN tipo = 'saida' THEN -quantidade ELSE 0 END), 0) as total")
                    ->value('total');
                $used = EstoqueMovimentacao::where('id_material', $material->id)
                    ->where('tipo', 'saida')
                    ->whereBetween('data_hora', [$start, $end])
                    ->sum('quantidade');
                $days = $used > 0 ? (int) ceil(((int) $available / ($used / $periodDays))) : ((int) $available > 0 ? 90 : 0);
                $status = $this->stockStatus((int) $available, (int) $material->estoque_minimo);

                return [
                    'label' => $material->nome,
                    'value' => $days.' dias',
                    'percent' => min(100, $days > 0 ? round(($days / 60) * 100) : 0),
                    'tone' => $status === 'Crítico' ? 'rose' : ($status === 'Baixo' ? 'amber' : 'green'),
                    'description' => (int) $available.' '.$material->unidade_medida.' em '.($material->categoria?->nome ?? 'sem categoria').'.',
                    'details' => ['Consumo médio' => $used.'/período', 'Situação' => $status],
                ];
            })
            ->take(6)
            ->all();
    }

    private function donationSources(Carbon $start, Carbon $end): array
    {
        return Doacao::query()
            ->with(['doador', 'itens.material.categoria'])
            ->where('situacao', 'recebida')
            ->whereBetween('data_doacao', [$start, $end])
            ->latest('data_doacao')
            ->limit(6)
            ->get()
            ->map(function (Doacao $donation) {
                $items = $donation->itens->sum('quantidade');
                $mainCategory = $donation->itens
                    ->groupBy(fn ($item) => $item->material?->categoria?->nome ?? 'Sem categoria')
                    ->sortByDesc(fn ($group) => $group->sum('quantidade'))
                    ->keys()
                    ->first() ?? 'Sem categoria';

                return [
                    'source' => $donation->doador?->nome ?? ($donation->observacao ?: 'Doação sem doador'),
                    'entries' => (string) $donation->itens->count(),
                    'items' => (string) $items,
                    'main_category' => $mainCategory,
                    'recurrence' => 'Pontual',
                    'status' => $items > 0 ? 'Normal' : 'Baixo',
                ];
            })
            ->all();
    }

    private function pumpStats(Carbon $start, Carbon $end): array
    {
        $loans = $this->pumpLoanPeriodQuery($start, $end)->get();
        $revenue = DB::table('pagamentos_alugueis')
            ->whereBetween('data_vencimento', [$start->toDateString(), $end->toDateString()])
            ->where('situacao', '!=', 'cancelado')
            ->sum('valor');

        return [
            'active' => $loans->count(),
            'free' => $loans->where('tipo', 'gratuita')->count(),
            'rentals' => $loans->where('tipo', 'aluguel')->count(),
            'freeOnTime' => $loans->where('tipo', 'gratuita')->filter(fn (CessaoBomba $loan) => $this->loanStatus($loan) !== 'Em atraso')->count(),
            'freeOverdue' => $loans->where('tipo', 'gratuita')->filter(fn (CessaoBomba $loan) => $this->loanStatus($loan) === 'Em atraso')->count(),
            'rentalsOnTime' => $loans->where('tipo', 'aluguel')->filter(fn (CessaoBomba $loan) => $this->loanStatus($loan) !== 'Em atraso')->count(),
            'rentalsOverdue' => $loans->where('tipo', 'aluguel')->filter(fn (CessaoBomba $loan) => $this->loanStatus($loan) === 'Em atraso')->count(),
            'overdue' => $loans->filter(fn (CessaoBomba $loan) => $this->loanStatus($loan) === 'Em atraso')->count(),
            'revenue' => $revenue,
        ];
    }

    private function pumpLoanPeriodQuery(Carbon $start, Carbon $end): Builder
    {
        return CessaoBomba::query()
            ->where('data_retirada', '<=', $end)
            ->where(function (Builder $query) use ($start) {
                $query
                    ->where('data_devolucao', '>=', $start)
                    ->orWhere(function (Builder $query) use ($start) {
                        $query
                            ->whereNull('data_devolucao')
                            ->where('data_prevista_devolucao', '>=', $start);
                    })
                    ->orWhere(function (Builder $query) {
                        $query
                            ->whereNull('data_devolucao')
                            ->whereNull('data_prevista_devolucao');
                    });
            });
    }

    private function attendanceQuery(Carbon $start, Carbon $end, string $location): Builder
    {
        return Atendimento::query()
            ->where('situacao', 'realizado')
            ->where('rascunho', false)
            ->whereBetween('data_hora', [$start, $end])
            ->when($location === 'remote', fn (Builder $query) => $query->where('modalidade', 'remota'))
            ->when(is_numeric($location), fn (Builder $query) => $query->where('id_local', (int) $location));
    }

    private function previousAttendanceCount(Carbon $start, Carbon $end): int
    {
        $days = $start->diffInDays($end) + 1;
        $previousEnd = $start->copy()->subDay()->endOfDay();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return Atendimento::where('situacao', 'realizado')
            ->where('rascunho', false)
            ->whereBetween('data_hora', [$previousStart, $previousEnd])
            ->count();
    }

    private function locationOptions(): array
    {
        return ['all' => 'Todas as unidades', 'remote' => 'Remoto'] + DB::table('locais_atendimento')->orderBy('nome')->pluck('nome', 'id')->all();
    }

    private function loanStatus(CessaoBomba $loan): string
    {
        if ($loan->situacao === 'atrasada' || ($loan->data_prevista_devolucao && $loan->data_prevista_devolucao->isPast())) {
            return 'Em atraso';
        }

        return $loan->data_prevista_devolucao && $loan->data_prevista_devolucao->diffInDays(now(), false) >= -7 ? 'Pendente' : 'Normal';
    }

    private function stockStatus(int $available, int $minimum): string
    {
        if ($available < $minimum) {
            return 'Crítico';
        }

        return $minimum > 0 && $available <= $minimum * 1.25 ? 'Baixo' : 'Normal';
    }

    private function percent(int|float $value, int|float $total): string
    {
        return round(($value / max($total, 1)) * 100).'%';
    }

    private function signedPercent(int $current, int $previous): string
    {
        if ($previous === 0) {
            return $this->signedNumber($current);
        }

        return $this->signedNumber((int) round((($current - $previous) / $previous) * 100)).'%';
    }

    private function signedNumber(int $value): string
    {
        return ($value >= 0 ? '+' : '').$value;
    }

    private function money(int|float|string $value): string
    {
        return 'R$ '.number_format((float) $value, 2, ',', '.');
    }
}
