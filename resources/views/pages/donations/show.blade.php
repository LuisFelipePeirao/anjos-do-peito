@extends('layouts.main-pages')

@section('title', $stockItem['description'])
@section('active-menu', 'donations.index')
@section('breadcrumb', 'Doações e estoque')
@section('page-title', $stockItem['description'])

@section('content')
    @php
        $tabs = [
            'overview' => 'Visão geral',
            'movements' => 'Movimentações',
            'distributions' => 'Distribuições',
            'history' => 'Histórico',
        ];

        $statusClass = match ($stockItem['status']) {
            'Normal' => 'bg-[#e8f8ee] text-[#23845a]',
            'Baixo' => 'bg-[#fff7e6] text-[#b76b00]',
            'Crítico' => 'bg-[#fff1f1] text-[#c2414b]',
            default => 'bg-[#f2f4f7] text-[#667085]',
        };
    @endphp

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">{{ $stockItem['description'] }}</h2>
                <p class="mt-1 text-sm text-[#667085]">Detalhes do material, saldo atual, necessidade e histórico de distribuição.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="{{ route('donations.index') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-arrow-left class="h-4 w-4" />
                    Voltar
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#bf5d6f] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a94f60]">
                    <x-lucide-hand-heart class="h-4 w-4" />
                    Registrar distribuição
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-gift class="h-4 w-4" />
                    Registrar entrada
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-pencil class="h-4 w-4" />
                    Editar
                </a>
            </div>
        </div>

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-[#8f4050]">
                        <x-gmdi-inventory-2-o class="h-7 w-7" />
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-bold text-[#111827]">{{ $stockItem['description'] }}</h3>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                <x-gmdi-check class="h-3.5 w-3.5" />
                                {{ $stockItem['status'] }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-[#667085]">Material da categoria {{ $stockItem['category'] }} usado nas distribuições às beneficiárias.</p>
                    </div>
                </div>

                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Categoria</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $stockItem['category'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Quantidade</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $stockItem['quantity'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Estoque mínimo</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $stockItem['minimum'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Última movimentação</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $stockItem['last_movement'] }}</dd>
                    </div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                @foreach ($tabs as $key => $label)
                    <a
                        href="{{ route('donations.show', ['item' => $item, 'tab' => $key]) }}"
                        class="shrink-0 border-b-2 px-1 py-4 text-sm font-medium transition {{ $tab === $key ? 'border-[#bf5d6f] text-[#bf5d6f]' : 'border-transparent text-[#4b5563] hover:text-[#bf5d6f]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </nav>

        @if ($tab === 'overview')
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($kpis as $kpi)
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

            <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="flex items-start gap-3">
                    <x-gmdi-report-problem-o class="mt-0.5 h-5 w-5 shrink-0 text-[#bf5d6f]" />
                    <div>
                        <h3 class="text-lg font-bold text-[#111827]">Prioridade de distribuição</h3>
                        <p class="mt-2 text-sm leading-6 text-[#667085]">
                            Situação atual: {{ $stockItem['status'] }}. Use a quantidade, demanda mensal e estoque mínimo para priorizar novas doações e distribuições.
                        </p>
                    </div>
                </div>
            </article>
        @elseif ($tab === 'movements')
            <x-tables.datatable
                :header="['Data e hora', 'Tipo', 'Quantidade', 'Origem', 'Responsável', 'Situação']"
                :data="$movements"
                :show-actions="false"
            />
        @elseif ($tab === 'distributions')
            <x-tables.datatable
                :header="['Data', 'Beneficiária', 'Quantidade', 'Responsável', 'Situação']"
                :data="$distributions"
                :show-actions="false"
            />
        @elseif ($tab === 'history')
            <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Histórico do material</h3>
                    <p class="mt-1 text-sm text-[#667085]">Eventos relevantes de estoque e distribuição.</p>
                </div>

                <div class="space-y-5 p-5">
                    @foreach ($history as $event)
                        @php
                            $icon = 'gmdi-' . $event['icon'];
                        @endphp
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#f0dadd] bg-white text-[#bf5d6f]">
                                    <x-dynamic-component :component="$icon" class="h-4 w-4" />
                                </span>
                                @if (!$loop->last)
                                    <span class="mt-2 h-full min-h-8 w-px bg-[#eadfe0]"></span>
                                @endif
                            </div>
                            <div class="pb-1">
                                <p class="text-xs font-semibold text-[#667085]">{{ $event['date'] }}</p>
                                <p class="mt-1 text-sm font-bold text-[#111827]">{{ $event['type'] }}</p>
                                <p class="mt-1 text-sm text-[#667085]">{{ $event['description'] }}</p>
                                <p class="mt-1 text-xs text-[#667085]">Responsável: {{ $event['responsible'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        @endif
    </section>
@endsection
