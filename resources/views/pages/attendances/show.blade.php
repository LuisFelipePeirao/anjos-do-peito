@extends('layouts.main-pages')

@section('title', 'Atendimento #' . $attendanceData['id'])
@section('active-menu', 'attendances.index')
@section('breadcrumb', 'Atendimentos')
@section('page-title', 'Atendimento #' . $attendanceData['id'])

@section('content')
    @php
        $tabs = [
            'overview' => 'Visão geral',
            'evolution' => 'Evolução',
            'referrals' => 'Encaminhamentos',
            'history' => 'Histórico',
        ];

        $statusClass = match ($attendanceData['status']) {
            'Realizado' => 'bg-[#e8f8ee] text-[#23845a]',
            'Agendado' => 'bg-[#eef4ff] text-[#2f66d0]',
            'Retorno pendente' => 'bg-[#fff7e6] text-[#b76b00]',
            'Cancelado' => 'bg-[#fff1f1] text-[#c2414b]',
            default => 'bg-[#f2f4f7] text-[#667085]',
        };
    @endphp

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">
                    Atendimento de {{ $attendanceData['beneficiary'] }}
                </h2>
                <p class="mt-1 text-sm text-[#667085]">
                    Registro detalhado do atendimento, orientações, retornos e histórico operacional.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="{{ route('attendances.index') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-arrow-left class="h-4 w-4" />
                    Voltar
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center rounded-[8px] bg-[#bf5d6f] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a94f60]">
                    Concluir atendimento
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    Agendar retorno
                </a>
                <a href="{{ route('attendances.edit', $attendance) }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-pencil class="h-4 w-4" />
                    Editar
                </a>
            </div>
        </div>

        <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-xl font-bold text-[#8f4050]">
                        {{ $attendanceData['beneficiary_initials'] }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-bold text-[#111827]">{{ $attendanceData['beneficiary'] }}</h3>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                <x-lucide-circle-check class="h-3.5 w-3.5" />
                                {{ $attendanceData['status'] }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-[#667085]">{{ $attendanceData['summary'] }}</p>
                    </div>
                </div>

                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Data e horário</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['date'] }} às {{ $attendanceData['time'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Profissional</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['professional'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Modalidade</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['modality'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Local</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['location'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">CPF</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['cpf'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Telefone</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['phone'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Nome do bebê</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['baby_name'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Retorno</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $attendanceData['return_date'] }}</dd>
                    </div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                @foreach ($tabs as $key => $label)
                    <a
                        href="{{ route('attendances.show', ['attendance' => $attendance, 'tab' => $key]) }}"
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

            <div class="grid gap-4 lg:grid-cols-2">
                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="flex items-start gap-3">
                        <x-lucide-target class="mt-0.5 h-5 w-5 shrink-0 text-[#bf5d6f]" />
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Objetivo</h3>
                            <p class="mt-2 text-sm leading-6 text-[#667085]">{{ $attendanceData['objective'] }}</p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="flex items-start gap-3">
                        <x-lucide-clipboard-check class="mt-0.5 h-5 w-5 shrink-0 text-[#bf5d6f]" />
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Conduta</h3>
                            <p class="mt-2 text-sm leading-6 text-[#667085]">{{ $attendanceData['conduct'] }}</p>
                        </div>
                    </div>
                </article>
            </div>
        @elseif ($tab === 'evolution')
            <x-tables.datatable
                :header="['Item', 'Descrição', 'Responsável']"
                :data="$evolution"
                :show-actions="false"
            />
        @elseif ($tab === 'referrals')
            <x-tables.datatable
                :header="['Data', 'Tipo', 'Descrição', 'Situação']"
                :data="$referrals"
                :show-actions="false"
            />
        @elseif ($tab === 'history')
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Histórico do atendimento</h3>
                    <p class="mt-1 text-sm text-[#667085]">Movimentações e registros relacionados a este atendimento.</p>
                </div>

                <div class="space-y-5 p-5">
                    @foreach ($history as $item)
                        @php
                            $icon = 'lucide-' . $item['icon'];
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
                                <p class="text-xs font-semibold text-[#667085]">{{ $item['date'] }}</p>
                                <p class="mt-1 text-sm font-bold text-[#111827]">{{ $item['type'] }}</p>
                                <p class="mt-1 text-sm text-[#667085]">{{ $item['description'] }}</p>
                                <p class="mt-1 text-xs text-[#667085]">Responsável: {{ $item['responsible'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        @endif
    </section>
@endsection
