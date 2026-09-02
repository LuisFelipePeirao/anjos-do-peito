@extends('layouts.main-pages')

@section('title', 'Relatórios')
@section('active-menu', 'reports.index')
@section('breadcrumb', 'Relatórios')
@section('page-title', 'Relatórios')

@section('content')
    <section class="space-y-6">
        <x-app.page-info subheading="Painel analítico" title="Relatórios operacionais"
            description="Análises por área para investigar prazos, desempenho, cobertura de estoque e sustentabilidade dos contratos."
            :firstButton="[
            'label' => 'Exportar relatório',
            'link' => '#exportar-relatorio',
            'icon' => 'download',
        ]" />

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <form action="{{ route('reports.index') }}" method="GET"
                class="grid gap-3 md:grid-cols-2 xl:grid-cols-[minmax(180px,0.8fr)_minmax(180px,0.8fr)_minmax(220px,1fr)_minmax(220px,1fr)_auto]">
                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">Período inicial</span>
                    <span class="relative block">
                        <x-gmdi-calendar-month-o
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="h-11 w-full rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </span>
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">Período final</span>
                    <span class="relative block">
                        <x-gmdi-calendar-month-o
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="h-11 w-full rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </span>
                </label>

                <x-material.outlined-select
                    name="section"
                    label="Seções"
                    icon="gmdi-filter-alt-o"
                    :selected="$section"
                    :options="[
                        'all' => 'Todas as seções',
                        'pumps' => 'Bombas de leite',
                        'attendances' => 'Atendimentos',
                        'stock' => 'Itens de estoque',
                    ]"
                />

                <x-material.outlined-select
                    name="location"
                    label="Unidades"
                    icon="gmdi-filter-alt-o"
                    :selected="$location"
                    :options="$locationOptions"
                />

                <button type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#111827] px-4 text-sm font-semibold text-white transition hover:bg-[#252f3f] xl:mt-5">
                    <x-gmdi-filter-alt-o class="h-4 w-4" />
                    Aplicar filtros
                </button>
            </form>
        </article>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($reportKpis as $kpi)
                <x-cards.dashboard-card :label="$kpi['label']" :value="$kpi['value']" :context="$kpi['context']"
                    :tone="$kpi['tone']" :icon="$kpi['icon']" :arrow="$kpi['trendType']" :percent="$kpi['trend']" />
            @endforeach
        </div>

        @if ($section === 'all' || $section === 'pumps')
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Bombas de leite</h3>
                    <p class="mt-1 text-sm text-[#667085]">Acompanhamento de contratos, renovações, atrasos e impacto dos
                        aluguéis.</p>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($pumpOverview as $item)
                        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                            <span
                                class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $item['tone'] }}">{{ $item['label'] }}</span>
                            <p class="mt-4 text-3xl font-bold text-[#111827]">{{ $item['value'] }}</p>
                            <p class="mt-2 text-sm leading-6 text-[#667085]">{{ $item['description'] }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
                    <x-chart.metric-bars title="Contratos por tipo"
                        description="Comparativo entre empréstimos gratuitos e aluguéis com cobrança."
                        :data="$pumpContractChart" />

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
                                            <p class="text-base font-bold text-[#111827]">{{ $loan['pump'] }} · {{ $loan['type'] }}
                                            </p>
                                            <p class="mt-1 text-sm text-[#667085]">{{ $loan['beneficiary'] }}</p>
                                        </div>
                                        <span
                                            class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
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
                    <p class="mt-1 text-sm text-[#667085]">Indicadores de qualidade, retorno e distribuição entre atendimentos
                        presenciais e remotos.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <x-chart.metric-bars title="Modalidades no período"
                        description="Participação de atendimentos presenciais e remotos no total."
                        :data="$attendanceModalityChart" />

                    <x-chart.metric-bars title="Capacidade por profissional"
                        description="Volume de atendimentos com retornos e distribuições vinculadas."
                        :data="$professionalChart" />
                </div>
            </section>
        @endif

        @if ($section === 'all' || $section === 'stock')
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Itens de estoque</h3>
                    <p class="mt-1 text-sm text-[#667085]">Leitura de cobertura, necessidade futura e origem das doações.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
                    <x-chart.metric-bars title="Cobertura por item"
                        description="Estimativa de duração do estoque pelos itens de maior saída."
                        :data="$stockCoverageChart" />

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
                                            <p class="mt-1 text-sm text-[#667085]">{{ $source['main_category'] }} ·
                                                {{ $source['recurrence'] }}</p>
                                        </div>
                                        <span
                                            class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
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
