@extends('layouts.main-pages')

@section('title', $pumpData['code'])
@section('active-menu', 'pumps.index')
@section('breadcrumb', 'Bombas de leite')
@section('page-title', $pumpData['code'])

@section('content')
    @php
        $tabs = [
            'overview' => 'Visão geral',
            'loans' => 'Empréstimos',
            'payments' => 'Pagamentos',
            'maintenance' => 'Manutenções',
            'history' => 'Histórico',
        ];

        $statusClass = match ($pumpData['status']) {
            'Disponível' => 'bg-[#e8f8ee] text-[#23845a]',
            'Emprestada' => 'bg-[#eef4ff] text-[#2f66d0]',
            'Em atraso' => 'bg-[#fff7e6] text-[#b76b00]',
            'Manutenção' => 'bg-[#f2f4f7] text-[#667085]',
            default => 'bg-[#fff1f1] text-[#c2414b]',
        };
    @endphp

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">
                    {{ $pumpData['code'] }} - {{ $pumpData['model'] }}
                </h2>
                <p class="mt-1 text-sm text-[#667085]">
                    Detalhes do equipamento, contrato atual, renovações, pagamentos e manutenções.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="{{ route('pumps.index') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-arrow-left class="h-4 w-4" />
                    Voltar
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-wrench class="h-4 w-4" />
                    Registrar manutenção
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-pencil class="h-4 w-4" />
                    Editar
                </a>
            </div>
        </div>

        <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-[#8f4050]">
                        <x-lucide-milk class="h-7 w-7" />
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-bold text-[#111827]">{{ $pumpData['code'] }}</h3>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                <x-lucide-circle-check class="h-3.5 w-3.5" />
                                {{ $pumpData['status'] }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-[#667085]">
                            {{ $currentContract ? $currentContract['notes'] : 'Bomba sem contrato ativo no momento, disponível para nova saída.' }}
                        </p>
                    </div>
                </div>

                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Modelo</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['model'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Série</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['serial_number'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Beneficiária atual</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['beneficiary'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Tipo atual</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['type'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Expiração</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['expires_at'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Renovação em</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['next_renewal_at'] ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <a href="{{ route('pumps.loans.create') }}" class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-[8px] bg-[#bf5d6f] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a94f60]">
                            <x-lucide-refresh-cw class="h-4 w-4" />
                            Renovar empréstimo
                        </a>
                    </div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                @foreach ($tabs as $key => $label)
                    <a
                        href="{{ route('pumps.show', ['pump' => $pump, 'tab' => $key]) }}"
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
                        <x-lucide-handshake class="mt-0.5 h-5 w-5 shrink-0 text-[#bf5d6f]" />
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Contrato atual</h3>
                            @if ($currentContract)
                                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Tipo</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['type'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Mensalidade</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['monthly_fee'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Vencimento</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['billing_due_day'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Termo</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $currentContract['term_status'] }}</dd>
                                    </div>
                                </dl>
                            @else
                                <p class="mt-2 text-sm leading-6 text-[#667085]">Não há empréstimo ou aluguel ativo para esta bomba.</p>
                            @endif
                        </div>
                    </div>
                </article>

                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="flex items-start gap-3">
                        <x-lucide-wrench class="mt-0.5 h-5 w-5 shrink-0 text-[#bf5d6f]" />
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Controle do equipamento</h3>
                            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Origem</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['origin'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Cadastro</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['registered_at'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Última higienização</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['last_sanitized_at'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Próxima revisão</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['next_maintenance_at'] }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </article>
            </div>
        @elseif ($tab === 'loans')
            <x-tables.datatable
                :header="['Período', 'Tipo', 'Beneficiária', 'Responsável', 'Situação']"
                :data="$loanHistory"
                :show-actions="false"
            />
        @elseif ($tab === 'payments')
            @if (count($payments))
                <x-tables.datatable
                    :header="['Data e hora', 'Referência', 'Forma', 'Valor', 'Situação']"
                    :data="$payments"
                    :show-actions="false"
                />
            @else
                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-8 text-center shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#fdecef] text-[#ef5b97]">
                        <x-lucide-receipt class="h-5 w-5" />
                    </div>
                    <p class="mt-3 font-semibold text-[#111827]">Nenhum pagamento registrado</p>
                    <p class="mt-1 text-sm text-[#667085]">Esta bomba não possui aluguel ativo ou cobranças registradas.</p>
                </article>
            @endif
        @elseif ($tab === 'maintenance')
            <x-tables.datatable
                :header="['Data', 'Tipo', 'Descrição', 'Responsável', 'Situação']"
                :data="$maintenanceHistory"
                :show-actions="false"
            />
        @elseif ($tab === 'history')
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Histórico operacional</h3>
                    <p class="mt-1 text-sm text-[#667085]">Movimentações relevantes da bomba em ordem cronológica.</p>
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
