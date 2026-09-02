<?php

namespace App\Services;

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeDashboardService
{
    public function indexData(): array
    {
        $monthlyAttendances = $this->monthlyAttendances();
        $stock = $this->stock();
        $pipeline = $this->pipeline();
        $risks = $this->risks();
        $recent = $this->recent();

        return [
            'kpis' => $this->kpis($monthlyAttendances, $stock, $risks),
            'monthlyAttendances' => $monthlyAttendances,
            'stock' => $stock,
            'pipeline' => $pipeline,
            'risks' => $risks,
            'recent' => $recent,
            'maxAttendance' => $monthlyAttendances['values'] ? max(array_column($monthlyAttendances['values'], 'total')) : 0,
            'totalStock' => array_sum(array_column($stock, 'available')) + array_sum(array_column($stock, 'used')),
        ];
    }

    private function kpis(array $monthlyAttendances, array $stock, array $risks): array
    {
        $currentMonth = now()->startOfMonth();
        $previousMonth = now()->subMonthNoOverflow()->startOfMonth();
        $currentAttendances = (int) collect($monthlyAttendances['values'])->last()['total'];
        $previousAttendances = $this->realizedAttendancesBetween($previousMonth, $previousMonth->copy()->endOfMonth());
        $activeBeneficiaries = Beneficiaria::where('situacao', 'ativo')->count();
        $newBeneficiaries = Beneficiaria::whereBetween('created_at', [$currentMonth, now()->endOfDay()])->count();
        $availablePumps = DB::table('bomba_leite')->where('situacao', 'disponivel')->count();
        $operationalPumps = DB::table('bomba_leite')->whereIn('situacao', ['disponivel', 'alugada', 'manutencao'])->count();
        $stockCritical = collect($stock)->filter(fn (array $item) => $item['available'] < $item['minimum'])->count();
        $overduePumps = $this->overduePumpCount();

        return [
            [
                'label' => 'Beneficiárias ativas',
                'value' => $activeBeneficiaries,
                'context' => $newBeneficiaries.' novos cadastros no mês',
                'trend' => '+'.$newBeneficiaries,
                'trendType' => 'up',
                'icon' => 'people-o',
                'tone' => 'rose',
            ],
            [
                'label' => 'Atendimentos no mês',
                'value' => $currentAttendances,
                'context' => 'Meta calculada: '.(collect($monthlyAttendances['values'])->last()['target'] ?? 0).' atendimentos',
                'trend' => $this->signedDelta($currentAttendances - $previousAttendances),
                'trendType' => $currentAttendances >= $previousAttendances ? 'up' : 'down',
                'icon' => 'content-paste-o',
                'tone' => 'blue',
            ],
            [
                'label' => 'Bombas disponíveis',
                'value' => $availablePumps,
                'context' => $operationalPumps > 0 ? round(($availablePumps / $operationalPumps) * 100).'% do parque operacional livre' : 'Nenhuma bomba operacional cadastrada',
                'trend' => $this->signedDelta($availablePumps),
                'trendType' => $availablePumps > 0 ? 'up' : 'down',
                'icon' => 'inventory-2-o',
                'tone' => 'green',
            ],
            [
                'label' => 'Riscos operacionais',
                'value' => count($risks),
                'context' => $overduePumps.' devoluções e '.$stockCritical.' itens críticos',
                'trend' => $this->signedDelta(count($risks)),
                'trendType' => count($risks) > 0 ? 'down' : 'up',
                'icon' => 'report-problem-o',
                'tone' => 'amber',
            ],
        ];
    }

    private function monthlyAttendances(): array
    {
        $months = collect(range(5, 0))->map(fn (int $monthsAgo) => now()->subMonthsNoOverflow($monthsAgo)->startOfMonth());
        $values = $months->map(function (Carbon $month) {
            $total = $this->realizedAttendancesBetween($month, $month->copy()->endOfMonth());
            $historicalAverage = max(1, $this->realizedAttendancesBefore($month, 3));
            $target = max($total, (int) ceil($historicalAverage * 1.1));

            return [
                'month' => $this->monthLabel($month),
                'total' => $total,
                'target' => $target,
            ];
        })->values()->all();

        $current = collect($values)->last();
        $percent = ($current['target'] ?? 0) > 0 ? min(100, round(($current['total'] / $current['target']) * 100)) : 0;

        return ['percent' => $percent.'%', 'values' => $values];
    }

    private function stock(): array
    {
        $materialStock = DB::table('materiais')
            ->join('categorias_materiais', 'categorias_materiais.id', '=', 'materiais.id_categoria')
            ->leftJoin('estoque_movimentacoes', 'estoque_movimentacoes.id_material', '=', 'materiais.id')
            ->select(
                'categorias_materiais.nome as label',
                DB::raw("COALESCE(SUM(CASE WHEN estoque_movimentacoes.tipo = 'entrada' THEN estoque_movimentacoes.quantidade WHEN estoque_movimentacoes.tipo = 'ajuste' THEN estoque_movimentacoes.quantidade WHEN estoque_movimentacoes.tipo = 'saida' THEN -estoque_movimentacoes.quantidade ELSE 0 END), 0) as available"),
                DB::raw("COALESCE(SUM(CASE WHEN estoque_movimentacoes.tipo = 'saida' THEN estoque_movimentacoes.quantidade ELSE 0 END), 0) as used"),
                DB::raw('COALESCE(SUM(materiais.estoque_minimo), 0) as minimum')
            )
            ->groupBy('categorias_materiais.id', 'categorias_materiais.nome')
            ->orderBy('categorias_materiais.nome')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->label,
                'available' => max(0, (int) $item->available),
                'used' => (int) $item->used,
                'minimum' => (int) $item->minimum,
            ]);

        $pumpStock = collect([[
            'label' => 'Bombas',
            'available' => DB::table('bomba_leite')->where('situacao', 'disponivel')->count(),
            'used' => DB::table('cessoes_bombas')->whereIn('situacao', ['ativa', 'atrasada'])->count(),
            'minimum' => 1,
        ]]);

        return $pumpStock->merge($materialStock)->values()->all();
    }

    private function pipeline(): array
    {
        $steps = [
            'Triagem' => Beneficiaria::where('situacao', 'ativo')->count(),
            'Agendado' => Atendimento::where('situacao', 'agendado')->where('rascunho', false)->count(),
            'Atendimento' => Atendimento::where('situacao', 'em_atendimento')->count(),
            'Realizado' => Atendimento::where('situacao', 'realizado')->whereBetween('data_hora', [now()->startOfMonth(), now()->endOfMonth()])->count(),
        ];
        $max = max($steps ?: [1]);

        return collect($steps)->map(fn (int $value, string $label) => [
            'label' => $label,
            'value' => $value,
            'percent' => $max > 0 ? round(($value / $max) * 100) : 0,
        ])->values()->all();
    }

    private function risks(): array
    {
        $risks = [];
        $overduePumps = DB::table('cessoes_bombas')
            ->join('bomba_leite', 'bomba_leite.id', '=', 'cessoes_bombas.id_bomba')
            ->whereIn('cessoes_bombas.situacao', ['ativa', 'atrasada'])
            ->whereNull('cessoes_bombas.data_devolucao')
            ->whereDate('cessoes_bombas.data_prevista_devolucao', '<', now()->toDateString())
            ->pluck('bomba_leite.codigo');

        if ($overduePumps->isNotEmpty()) {
            $risks[] = [
                'title' => $overduePumps->count().' bombas com devolução atrasada',
                'description' => $overduePumps->take(3)->join(', ').' estão fora do prazo previsto.',
                'tone' => 'red',
            ];
        }

        $lowStock = collect($this->stock())->filter(fn (array $item) => $item['available'] < $item['minimum']);
        if ($lowStock->isNotEmpty()) {
            $risks[] = [
                'title' => $lowStock->count().' itens abaixo do estoque mínimo',
                'description' => $lowStock->pluck('label')->take(3)->join(', ').' exigem reposição.',
                'tone' => 'amber',
            ];
        }

        $beneficiariesWithoutReturn = Beneficiaria::where('situacao', 'ativo')
            ->whereDoesntHave('atendimentos', fn ($query) => $query->where('data_hora', '>=', now()->subDays(7)))
            ->count();

        if ($beneficiariesWithoutReturn > 0) {
            $risks[] = [
                'title' => $beneficiariesWithoutReturn.' beneficiárias sem retorno',
                'description' => 'Casos ativos sem atendimento registrado nos últimos 7 dias.',
                'tone' => 'blue',
            ];
        }

        return $risks ?: [[
            'title' => 'Nenhum risco prioritário',
            'description' => 'Estoque, devoluções e retornos sem pendências críticas.',
            'tone' => 'blue',
        ]];
    }

    private function recent(): array
    {
        $attendances = Atendimento::query()
            ->with(['beneficiaria', 'detalhe'])
            ->whereNotNull('data_hora')
            ->latest('data_hora')
            ->limit(3)
            ->get()
            ->map(fn (Atendimento $attendance) => [
                'date' => $attendance->data_hora,
                'title' => 'Atendimento registrado para '.($attendance->beneficiaria?->nome ?? 'beneficiária').'.',
                'meta' => $attendance->detalhe?->resumo ?: $this->attendanceStatusLabel($attendance->situacao),
            ]);

        $pumpLoans = DB::table('cessoes_bombas')
            ->join('bomba_leite', 'bomba_leite.id', '=', 'cessoes_bombas.id_bomba')
            ->join('beneficiarias', 'beneficiarias.id', '=', 'cessoes_bombas.id_beneficiaria')
            ->select('cessoes_bombas.data_retirada as date', 'bomba_leite.codigo', 'beneficiarias.nome', 'cessoes_bombas.data_prevista_devolucao')
            ->latest('cessoes_bombas.data_retirada')
            ->limit(3)
            ->get()
            ->map(fn ($loan) => [
                'date' => Carbon::parse($loan->date),
                'title' => 'Bomba '.$loan->codigo.' emprestada para '.$loan->nome.'.',
                'meta' => $loan->data_prevista_devolucao ? 'Previsão de devolução em '.Carbon::parse($loan->data_prevista_devolucao)->format('d/m/Y') : 'Sem previsão de devolução',
            ]);

        $movements = DB::table('estoque_movimentacoes')
            ->join('materiais', 'materiais.id', '=', 'estoque_movimentacoes.id_material')
            ->select('estoque_movimentacoes.data_hora as date', 'estoque_movimentacoes.tipo', 'estoque_movimentacoes.quantidade', 'materiais.nome', 'materiais.unidade_medida')
            ->latest('estoque_movimentacoes.data_hora')
            ->limit(3)
            ->get()
            ->map(fn ($movement) => [
                'date' => Carbon::parse($movement->date),
                'title' => ucfirst($movement->tipo).' de '.$movement->quantidade.' '.$movement->unidade_medida.' de '.$movement->nome.'.',
                'meta' => 'Movimentação de estoque',
            ]);

        return $attendances
            ->merge($pumpLoans)
            ->merge($movements)
            ->sortByDesc('date')
            ->take(3)
            ->map(fn (array $activity) => [
                'date' => $activity['date']->isToday() ? 'Hoje' : $activity['date']->format('d/m/Y'),
                'time' => $activity['date']->format('H:i'),
                'title' => $activity['title'],
                'meta' => $activity['meta'],
            ])
            ->values()
            ->all();
    }

    private function realizedAttendancesBetween(Carbon $start, Carbon $end): int
    {
        return Atendimento::where('situacao', 'realizado')
            ->where('rascunho', false)
            ->whereBetween('data_hora', [$start, $end])
            ->count();
    }

    private function realizedAttendancesBefore(Carbon $month, int $months): int
    {
        $start = $month->copy()->subMonthsNoOverflow($months)->startOfMonth();
        $end = $month->copy()->subMonthNoOverflow()->endOfMonth();

        return (int) ceil($this->realizedAttendancesBetween($start, $end) / max($months, 1));
    }

    private function overduePumpCount(): int
    {
        return DB::table('cessoes_bombas')
            ->whereIn('situacao', ['ativa', 'atrasada'])
            ->whereNull('data_devolucao')
            ->whereDate('data_prevista_devolucao', '<', now()->toDateString())
            ->count();
    }

    private function signedDelta(int $value): string
    {
        return ($value >= 0 ? '+' : '').$value;
    }

    private function monthLabel(Carbon $date): string
    {
        return [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez',
        ][(int) $date->format('n')];
    }

    private function attendanceStatusLabel(string $status): string
    {
        return [
            'agendado' => 'Atendimento agendado',
            'em_atendimento' => 'Atendimento em andamento',
            'realizado' => 'Atendimento realizado',
            'cancelado' => 'Atendimento cancelado',
        ][$status] ?? $status;
    }
}
