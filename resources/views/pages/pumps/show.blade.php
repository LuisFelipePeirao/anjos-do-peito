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
                <a href="{{ route('pumps.edit', $pump) }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-pencil class="h-4 w-4" />
                    Editar
                </a>
                <button type="button" data-confirm-dialog-open="pump-delete-confirmation" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#f2c7cb] bg-white px-4 text-sm font-semibold text-[#c2414b] shadow-sm transition hover:bg-[#fff1f1]">
                    <x-lucide-trash-2 class="h-4 w-4" />
                    Excluir
                </button>
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
                    @if (($currentContract['is_renewable'] ?? false) && in_array($pumpData['status'], ['Emprestada', 'Em atraso'], true))
                        <div class="sm:col-span-2">
                            <button type="button" data-dialog-open="pump-renewal-modal" class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-[8px] bg-[#bf5d6f] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a94f60]">
                                <x-lucide-refresh-cw class="h-4 w-4" />
                                Renovar empréstimo
                            </button>
                        </div>
                    @endif
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
                                <div class="sm:col-span-2">
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Acessórios</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $pumpData['accessories'] }}</dd>
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

        <x-app.confirm-modal
            id="pump-delete-confirmation"
            title="Excluir bomba de leite?"
            message="Bombas com empréstimos ou manutenções vinculadas serão inativadas para preservar o histórico."
            confirm-label="Excluir bomba"
            cancel-label="Cancelar"
            variant="danger"
            :action="route('pumps.destroy', $pump)"
            method="DELETE"
        />

        @if (($currentContract['is_renewable'] ?? false) && in_array($pumpData['status'], ['Emprestada', 'Em atraso'], true))
            <dialog
                id="pump-renewal-modal"
                aria-labelledby="pump-renewal-modal-title"
                data-dialog-modal
                @error('expires_at') data-dialog-auto-open @enderror
                class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45 backdrop:backdrop-blur-[2px]"
            >
                <form method="POST" action="{{ route('pumps.loans.renew', $pump) }}" class="p-5 sm:p-6">
                    @csrf
                    @method('PATCH')

                    <div class="flex items-start gap-4">
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full {{ ($currentContract['is_overdue'] ?? false) ? 'bg-[#fff7e6] text-[#b76b00]' : 'bg-[#eef4ff] text-[#2f66d0]' }}">
                            @if ($currentContract['is_overdue'] ?? false)
                                <x-gmdi-warning-amber-o class="h-5 w-5" />
                            @else
                                <x-lucide-refresh-cw class="h-5 w-5" />
                            @endif
                        </span>

                        <div class="min-w-0 flex-1 pt-0.5">
                            <h2 id="pump-renewal-modal-title" class="text-base font-semibold text-[#111827]">Renovar empréstimo</h2>
                            <p class="mt-1.5 text-sm leading-6 text-[#667085]">
                                @if ($currentContract['is_overdue'] ?? false)
                                    Este empréstimo está atrasado desde {{ $currentContract['expires_at'] }}. Confirme se deseja renovar mesmo assim.
                                @else
                                    Informe a nova data de expiração do empréstimo atual.
                                @endif
                            </p>
                        </div>

                        <button type="button" data-dialog-close class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#98a2b3] transition hover:cursor-pointer hover:bg-[#f7edef] hover:text-[#667085] focus:outline-none focus:ring-3 focus:ring-[#fdecef]" aria-label="Fechar">
                            <x-gmdi-close-o class="h-5 w-5" />
                        </button>
                    </div>

                    <label class="mt-6 block">
                        <span class="text-sm font-semibold text-[#344054]">Nova expiração</span>
                        <input type="date" name="expires_at" value="{{ old('expires_at', $currentContract['renewal_min_date']) }}" min="{{ $currentContract['renewal_min_date'] }}" class="mt-2 h-11 w-full rounded-lg border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15" required>
                        @error('expires_at') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                    </label>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" data-dialog-close class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:cursor-pointer hover:bg-[#fbfaf9] focus:outline-none focus:ring-3 focus:ring-[#fdecef]">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#bf5d6f] px-4 text-sm font-semibold text-white transition hover:cursor-pointer hover:bg-[#a94f60] focus:outline-none focus:ring-3 focus:ring-[#fdecef]">
                            Renovar empréstimo
                        </button>
                    </div>
                </form>
            </dialog>
        @endif
    </section>
@endsection
