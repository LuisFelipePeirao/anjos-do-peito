@extends('layouts.main-pages')

@section('title', $beneficiary['name'])
@section('active-menu', 'beneficiaries.index')
@section('breadcrumb', 'Beneficiárias')
@section('page-title', $beneficiary['name'])

@section('content')
    @php
        $tabs = [
            'overview' => 'Visão geral',
            'attendances' => 'Atendimentos',
            'pumps' => 'Bombas',
            'donations' => 'Doações',
            'history' => 'Histórico',
        ];
    @endphp

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">{{ $beneficiary['name'] }}</h2>
                <p class="mt-1 text-sm text-[#667085]">Todas as informações da beneficiária reunidas em um único perfil.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#bf5d6f] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a94f60]">
                    Novo atendimento
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    Registrar entrega
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    Novo empréstimo
                </a>
                <a href="#" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-pencil class="h-4 w-4" />
                    Editar cadastro
                </a>
            </div>
        </div>

        <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-xl font-bold text-[#8f4050]">
                        {{ $beneficiary['initials'] }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-bold text-[#111827]">{{ $beneficiary['name'] }}</h3>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#dff7e8] px-2.5 py-1 text-xs font-semibold text-[#23845a]">
                                <x-lucide-circle-check class="h-3.5 w-3.5" />
                                {{ $beneficiary['status'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">CPF</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiary['cpf'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Telefone</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiary['phone'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Data de nascimento</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiary['birth_date'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Nome do bebê</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiary['baby_name'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Data de cadastro</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiary['registered_at'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Endereço</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiary['address'] }}</dd>
                    </div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                @foreach ($tabs as $key => $label)
                    <a
                        href="{{ route('beneficiaries.show', ['cpf' => $cpf, 'tab' => $key]) }}"
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

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Informações recentes</h3>
                    <p class="mt-1 text-sm text-[#667085]">Resumo integrado dos três módulos.</p>
                </div>

                <div class="grid gap-4 p-5 lg:grid-cols-3">
                    @foreach ($recentInfo as $info)
                        @php
                            $icon = 'lucide-' . $info['icon'];
                        @endphp
                        <div class="rounded-[8px] border border-[#eadfe0] p-4">
                            <div class="flex items-start gap-3">
                                <x-dynamic-component :component="$icon" class="mt-0.5 h-4 w-4 shrink-0 text-[#bf5d6f]" />
                                <div class="min-w-0">
                                    <p class="font-semibold text-[#111827]">{{ $info['title'] }}</p>
                                    <p class="mt-2 text-sm text-[#667085]">{{ $info['description'] }}</p>
                                    <p class="mt-2 text-xs text-[#667085]">{{ $info['meta'] }}</p>
                                </div>
                            </div>
                            <a href="{{ $info['link'] }}" class="mt-4 inline-flex h-10 w-full items-center justify-center rounded-[8px] border border-[#e4d8d9] text-sm font-semibold text-[#111827] transition hover:bg-[#fbf1f3]">
                                {{ $info['button'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </article>
        @elseif ($tab === 'attendances')
            <x-tables.datatable
                :header="['Data', 'Profissional', 'Modalidade', 'Resumo', 'Retorno']"
                :data="$attendances"
            />
        @elseif ($tab === 'pumps')
            <x-tables.datatable
                :header="['Bomba', 'Data de retirada', 'Devolução prevista', 'Devolução realizada', 'Situação']"
                :data="$pumps"
                :show-actions="false"
            />
        @elseif ($tab === 'donations')
            <x-tables.datatable
                :header="['Data', 'Itens recebidos', 'Quantidade', 'Responsável']"
                :data="$donations"
                :show-actions="false"
            />
        @elseif ($tab === 'history')
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Histórico integrado</h3>
                    <p class="mt-1 text-sm text-[#667085]">Todas as interações da beneficiária com a ONG, em ordem cronológica.</p>
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
