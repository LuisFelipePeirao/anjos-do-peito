@extends('layouts.main-pages')

@section('title', 'Relatórios')
@section('active-menu', 'reports.index')
@section('breadcrumb', 'Relatórios')
@section('page-title', 'Relatórios')

@php
    $reportKpis = [
        ['label' => 'Renovações no prazo', 'value' => '67%', 'context' => 'Contratos renovados antes do vencimento', 'trend' => '+8%', 'trendType' => 'up', 'icon' => 'autorenew', 'tone' => 'green'],
        ['label' => 'Aluguéis em aberto', 'value' => 'R$ 110,00', 'context' => '1 mensalidade a receber no período', 'trend' => '-22%', 'trendType' => 'up', 'icon' => 'attach-money', 'tone' => 'amber'],
        ['label' => 'Retornos concluídos', 'value' => '86%', 'context' => 'Acompanhamentos finalizados no período', 'trend' => '+11%', 'trendType' => 'up', 'icon' => 'check', 'tone' => 'blue'],
        ['label' => 'Cobertura de estoque', 'value' => '12 dias', 'context' => 'Estimativa pelos itens de maior saída', 'trend' => '-4 dias', 'trendType' => 'down', 'icon' => 'inventory-o', 'tone' => 'rose'],
    ];

    $pumpOverview = [
        ['label' => 'Gratuidade', 'value' => '80%', 'description' => '8 de 10 contratos ativos são empréstimos sem cobrança.', 'tone' => 'bg-[#eefbf3] text-[#047857]'],
        ['label' => 'Receita recorrente', 'value' => 'R$ 220,00', 'description' => 'Valor previsto pelos aluguéis ativos neste mês.', 'tone' => 'bg-[#fff7ed] text-[#b45309]'],
        ['label' => 'Risco de não devolução', 'value' => '3', 'description' => 'Bombas com renovação ou expiração vencida.', 'tone' => 'bg-[#fdecef] text-[#bf2f63]'],
    ];

    $pumpContractChart = [
        ['label' => 'Empréstimos', 'value' => '8 ativos', 'percent' => 80, 'tone' => 'green', 'description' => 'Contratos gratuitos em andamento.', 'details' => ['No prazo' => '5', 'Atrasos' => '3', 'Receita' => 'Sem cobrança']],
        ['label' => 'Aluguéis', 'value' => '2 ativos', 'percent' => 20, 'tone' => 'amber', 'description' => 'Contratos com mensalidade registrada.', 'details' => ['No prazo' => '2', 'Atrasos' => '0', 'Receita' => 'R$ 220,00']],
    ];

    $pumpDueDates = [
        ['pump' => 'BP-004', 'type' => 'Empréstimo', 'beneficiary' => 'Maria da Silva', 'expires_at' => '22/08/2026', 'renewal_at' => '15/08/2026', 'status' => 'Pendente'],
        ['pump' => 'BP-009', 'type' => 'Aluguel', 'beneficiary' => 'Amanda Souza', 'expires_at' => '30/08/2026', 'renewal_at' => '23/08/2026', 'status' => 'Normal'],
        ['pump' => 'BP-012', 'type' => 'Empréstimo', 'beneficiary' => 'Patrícia Lima', 'expires_at' => '05/08/2026', 'renewal_at' => '29/07/2026', 'status' => 'Em atraso'],
    ];

    $attendanceModalityChart = [
        ['label' => 'Presencial', 'value' => '67%', 'percent' => 67, 'tone' => 'rose', 'description' => '28 atendimentos realizados no período.', 'details' => ['Retornos pendentes' => '3', 'Tempo médio' => '42 min']],
        ['label' => 'Remota', 'value' => '33%', 'percent' => 33, 'tone' => 'blue', 'description' => '14 atendimentos realizados no período.', 'details' => ['Retornos pendentes' => '2', 'Tempo médio' => '26 min']],
    ];

    $professionalChart = [
        ['label' => 'Fernanda Souza', 'value' => '16', 'percent' => 100, 'tone' => 'green', 'description' => 'Maior volume de orientações no período.', 'details' => ['Retornos' => '5', 'Distribuições' => '8']],
        ['label' => 'Camila Rocha', 'value' => '13', 'percent' => 81, 'tone' => 'blue', 'description' => 'Alta relação entre atendimento e entrega de materiais.', 'details' => ['Retornos' => '4', 'Distribuições' => '10']],
        ['label' => 'Juliana Matos', 'value' => '9', 'percent' => 56, 'tone' => 'amber', 'description' => 'Retornos exigem acompanhamento.', 'details' => ['Retornos' => '3', 'Distribuições' => '2']],
    ];

    $stockCoverageChart = [
        ['label' => 'Leite em pó 400g', 'value' => '12 dias', 'percent' => 22, 'tone' => 'rose', 'description' => '32 unidades em alimentação.', 'details' => ['Consumo médio' => '18/semana', 'Situação' => 'Crítico']],
        ['label' => 'Kit higiene recém-nascido', 'value' => '18 dias', 'percent' => 33, 'tone' => 'amber', 'description' => '41 unidades em higiene.', 'details' => ['Consumo médio' => '16/semana', 'Situação' => 'Baixo']],
        ['label' => 'Fralda tamanho P', 'value' => '24 dias', 'percent' => 44, 'tone' => 'green', 'description' => '78 unidades em fraldas.', 'details' => ['Consumo médio' => '22/semana', 'Situação' => 'Normal']],
        ['label' => 'Body manga curta', 'value' => '54 dias', 'percent' => 100, 'tone' => 'blue', 'description' => '70 unidades em roupas.', 'details' => ['Consumo médio' => '9/semana', 'Situação' => 'Normal']],
    ];

    $donationSources = [
        ['source' => 'Campanha Agosto Dourado', 'entries' => '7', 'items' => '118', 'main_category' => 'Alimentação', 'recurrence' => 'Pontual', 'status' => 'Normal'],
        ['source' => 'Doadores recorrentes', 'entries' => '12', 'items' => '96', 'main_category' => 'Higiene', 'recurrence' => 'Mensal', 'status' => 'Normal'],
        ['source' => 'Parceiros locais', 'entries' => '4', 'items' => '35', 'main_category' => 'Fraldas', 'recurrence' => 'Irregular', 'status' => 'Baixo'],
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Painel analítico"
            title="Relatórios operacionais"
            description="Análises por área para investigar prazos, desempenho, cobertura de estoque e sustentabilidade dos contratos."
            :firstButton="[
                'label' => 'Exportar relatório',
                'link' => '#exportar-relatorio',
                'icon' => 'download',
            ]" />

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <form action="{{ route('reports.index') }}" method="GET" class="grid gap-3 md:grid-cols-2 xl:grid-cols-[minmax(180px,0.8fr)_minmax(180px,0.8fr)_minmax(220px,1fr)_minmax(220px,1fr)_auto]">
                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">Início do período</span>
                    <span class="relative block">
                        <x-lucide-calendar-days class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                        <input
                            type="date"
                            name="start_date"
                            value="{{ $startDate }}"
                            class="h-11 w-full rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </span>
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">Fim do período</span>
                    <span class="relative block">
                        <x-lucide-calendar-days class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                        <input
                            type="date"
                            name="end_date"
                            value="{{ $endDate }}"
                            class="h-11 w-full rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </span>
                </label>

                <label class="relative block xl:mt-5">
                    <span class="sr-only">Seção</span>
                    <x-lucide-filter class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                    <select name="section" class="h-11 w-full appearance-none rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-9 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]">
                        <option value="all" @selected($section === 'all')>Todas as seções</option>
                        <option value="pumps" @selected($section === 'pumps')>Bombas de leite</option>
                        <option value="attendances" @selected($section === 'attendances')>Atendimentos</option>
                        <option value="stock" @selected($section === 'stock')>Doações e estoque</option>
                    </select>
                </label>

                <label class="relative block xl:mt-5">
                    <span class="sr-only">Unidade</span>
                    <x-lucide-map-pin class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                    <select name="location" class="h-11 w-full appearance-none rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-9 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]">
                        <option value="all" @selected($location === 'all')>Todas as unidades</option>
                        <option value="ong" @selected($location === 'ong')>ONG</option>
                        <option value="home" @selected($location === 'home')>Domiciliar</option>
                        <option value="remote" @selected($location === 'remote')>Remoto</option>
                    </select>
                </label>

                <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#111827] px-4 text-sm font-semibold text-white transition hover:bg-[#252f3f] xl:mt-5">
                    <x-lucide-filter class="h-4 w-4" />
                    Aplicar filtros
                </button>
            </form>
        </article>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($reportKpis as $kpi)
                <x-cards.dashboard-card
                    :label="$kpi['label']"
                    :value="$kpi['value']"
                    :context="$kpi['context']"
                    :tone="$kpi['tone']"
                    :icon="$kpi['icon']"
                    :arrow="$kpi['trendType']"
                    :percent="$kpi['trend']"
                />
            @endforeach
        </div>

        @if ($section === 'all' || $section === 'pumps')
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Bombas de leite</h3>
                    <p class="mt-1 text-sm text-[#667085]">Acompanhamento de contratos, renovações, atrasos e impacto dos aluguéis.</p>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($pumpOverview as $item)
                        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $item['tone'] }}">{{ $item['label'] }}</span>
                            <p class="mt-4 text-3xl font-bold text-[#111827]">{{ $item['value'] }}</p>
                            <p class="mt-2 text-sm leading-6 text-[#667085]">{{ $item['description'] }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
                    <x-chart.metric-bars
                        title="Contratos por tipo"
                        description="Comparativo entre empréstimos gratuitos e aluguéis com cobrança."
                        :data="$pumpContractChart"
                    />

                    <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                        <div class="border-b border-[#f0e7e8] pb-5">
                            <h3 class="text-lg font-bold text-[#111827]">Prazos de renovação</h3>
                            <p class="mt-1 text-sm text-[#667085]">Bombas com datas de expiração e próxima renovação.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            @foreach ($pumpDueDates as $loan)
                                @php
                                    $statusClass = match ($loan['status']) {
                                        'Normal' => 'bg-[#e8f8ee] text-[#23845a]',
                                        'Pendente' => 'bg-[#fff7e6] text-[#b76b00]',
                                        'Em atraso' => 'bg-[#fff1f1] text-[#c2414b]',
                                        default => 'bg-[#f2f4f7] text-[#667085]',
                                    };
                                @endphp

                                <div class="rounded-lg border border-[#f0e7e8] p-4">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-base font-bold text-[#111827]">{{ $loan['pump'] }} · {{ $loan['type'] }}</p>
                                            <p class="mt-1 text-sm text-[#667085]">{{ $loan['beneficiary'] }}</p>
                                        </div>
                                        <span class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ $loan['status'] }}
                                        </span>
                                    </div>
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Expiração</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]">{{ $loan['expires_at'] }}</p>
                                        </div>
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Renovação</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]">{{ $loan['renewal_at'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </div>
            </section>
        @endif

        @if ($section === 'all' || $section === 'attendances')
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Atendimentos</h3>
                    <p class="mt-1 text-sm text-[#667085]">Indicadores de qualidade, retorno e distribuição entre atendimentos presenciais e remotos.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <x-chart.metric-bars
                        title="Modalidades no período"
                        description="Participação de atendimentos presenciais e remotos no total."
                        :data="$attendanceModalityChart"
                    />

                    <x-chart.metric-bars
                        title="Capacidade por profissional"
                        description="Volume de atendimentos com retornos e distribuições vinculadas."
                        :data="$professionalChart"
                    />
                </div>
            </section>
        @endif

        @if ($section === 'all' || $section === 'stock')
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Doações e estoque</h3>
                    <p class="mt-1 text-sm text-[#667085]">Leitura de cobertura, necessidade futura e origem das doações.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
                    <x-chart.metric-bars
                        title="Cobertura por item"
                        description="Estimativa de duração do estoque pelos itens de maior saída."
                        :data="$stockCoverageChart"
                    />

                    <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                        <div class="border-b border-[#f0e7e8] pb-5">
                            <h3 class="text-lg font-bold text-[#111827]">Origem das doações</h3>
                            <p class="mt-1 text-sm text-[#667085]">Entradas recentes agrupadas por campanha ou recorrência.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            @foreach ($donationSources as $source)
                                @php
                                    $statusClass = $source['status'] === 'Normal'
                                        ? 'bg-[#e8f8ee] text-[#23845a]'
                                        : 'bg-[#fff7e6] text-[#b76b00]';
                                @endphp

                                <div class="rounded-lg border border-[#f0e7e8] p-4">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-base font-bold text-[#111827]">{{ $source['source'] }}</p>
                                            <p class="mt-1 text-sm text-[#667085]">{{ $source['main_category'] }} · {{ $source['recurrence'] }}</p>
                                        </div>
                                        <span class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ $source['status'] }}
                                        </span>
                                    </div>
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Entradas</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]">{{ $source['entries'] }}</p>
                                        </div>
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Itens</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]">{{ $source['items'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </div>
            </section>
        @endif
    </section>
@endsection
