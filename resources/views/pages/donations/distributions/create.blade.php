@extends('layouts.main-pages')

@php
    $labels = [
        'entrada' => ['title' => 'Registrar entrada', 'subheading' => 'Entrada', 'description' => 'Registre materiais recebidos e atualize o estoque automaticamente.'],
        'saida' => ['title' => 'Registrar saída', 'subheading' => 'Saída', 'description' => 'Relacione materiais entregues à beneficiária e baixe estoque automaticamente.'],
        'ajuste' => ['title' => 'Registrar ajuste', 'subheading' => 'Ajuste', 'description' => 'Corrija o saldo de um material com observação obrigatória.'],
    ];
    $page = $labels[$movementType] ?? ['title' => 'Registrar movimentação', 'subheading' => 'Movimentações', 'description' => 'Escolha o tipo de movimentação antes de preencher os dados.'];
@endphp

@section('title', $page['title'])
@section('active-menu', 'movements.index')
@section('breadcrumb', 'Movimentações')
@section('page-title', $page['title'])

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
        $itemRows = collect(old('items', [['id_material' => $selectedMaterial, 'quantidade' => null]]))
            ->filter(fn ($item) => filled($item['id_material'] ?? null) || filled($item['quantidade'] ?? null))
            ->values();
        $itemRows = $itemRows->isEmpty() ? collect([['id_material' => $selectedMaterial, 'quantidade' => null]]) : $itemRows;
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            :subheading="$page['subheading']"
            :title="$page['title']"
            :description="$page['description']"
            :firstButton="['label' => 'Voltar para lista', 'link' => route('movements.index'), 'icon' => 'arrow-left']" />

        @if (! $movementType)
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['type' => 'entrada', 'title' => 'Entrada', 'description' => 'Registrar doações recebidas e somar materiais ao estoque.', 'icon' => 'card-giftcard-o'],
                    ['type' => 'saida', 'title' => 'Saída', 'description' => 'Registrar materiais entregues e baixar saldo disponível.', 'icon' => 'volunteer-activism-o'],
                    ['type' => 'ajuste', 'title' => 'Ajuste', 'description' => 'Adicionar ou subtrair saldo com justificativa obrigatória.', 'icon' => 'swap-horiz-o'],
                ] as $option)
                    @php $icon = 'gmdi-'.$option['icon']; @endphp
                    <a href="{{ route('movements.create', ['tipo' => $option['type']]) }}" class="group rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)] transition hover:border-[#ef5b97] hover:bg-[#fff7f9]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <x-dynamic-component :component="$icon" class="h-5 w-5" />
                        </span>
                        <h3 class="mt-4 text-lg font-bold text-[#111827]">{{ $option['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#667085]">{{ $option['description'] }}</p>
                    </a>
                @endforeach
            </div>

            <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <h3 class="text-lg font-bold text-[#111827]">Escolha o tipo de movimentação</h3>
                <p class="mt-2 text-sm text-[#667085]">Os campos serão adaptados conforme entrada, saída ou ajuste.</p>
            </article>
        @else
            <form method="POST" action="{{ route('movements.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="tipo" value="{{ $movementType }}">

                @if ($movementType === 'entrada')
                    <x-donations.partials.form-shell title="Dados da entrada" description="Origem, data e situação do recebimento." icon="gmdi-card-giftcard-o">
                        <div>
                            <div class="flex items-end gap-2">
                                <div class="min-w-0 flex-1">
                                    <x-material.select name="id_doador" label="Doador (opcional)" :options="$donors" :selected="old('id_doador')" placeholder="Selecione" />
                                </div>
                                <button type="button" data-dialog-open="donation-donor-create-dialog" class="mb-0 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Novo doador" title="Novo doador">
                                    <x-gmdi-person-add-o class="h-5 w-5" />
                                </button>
                            </div>
                            @error('id_doador') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </div>

                        <label class="block">
                            <span class="{{ $labelClass }}">Data e hora</span>
                            <input type="datetime-local" name="data_hora" value="{{ old('data_hora', now()->format('Y-m-d\TH:i')) }}" class="{{ $inputClass }}" required>
                            @error('data_hora') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>

                        <div>
                            <x-material.select name="situacao" label="Situação" :options="['recebida' => 'Recebida', 'cancelada' => 'Cancelada']" :selected="old('situacao', 'recebida')" required />
                            @error('situacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </div>

                        <label class="block md:col-span-2">
                            <span class="{{ $labelClass }}">Observação</span>
                            <textarea name="observacao" class="{{ $textareaClass }}">{{ old('observacao') }}</textarea>
                            @error('observacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>
                    </x-donations.partials.form-shell>

                    <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]" data-entry-items>
                        <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                                    <x-gmdi-inventory-2-o class="h-5 w-5" />
                                </span>
                                <div>
                                    <h3 class="text-lg font-bold text-[#111827]">Itens recebidos</h3>
                                    <p class="mt-1 text-sm text-[#667085]">Adicione os materiais e quantidades desta entrada.</p>
                                </div>
                            </div>

                            <button type="button" data-add-entry-item class="inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Adicionar item" title="Adicionar item">
                                <x-gmdi-add class="h-5 w-5" />
                            </button>
                        </div>

                        <div class="space-y-3 p-5" data-entry-items-list>
                            @foreach ($itemRows as $index => $row)
                                <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_2.5rem]" data-entry-item-row>
                                    <div>
                                        <x-material.select name="items[{{ $index }}][id_material]" label="Material" :options="$materials" :selected="$row['id_material'] ?? null" placeholder="Selecione" />
                                    </div>

                                    <label class="block">
                                        <span class="{{ $labelClass }}">Quantidade</span>
                                        <input type="number" min="1" name="items[{{ $index }}][quantidade]" value="{{ $row['quantidade'] ?? null }}" class="{{ $inputClass }}" data-entry-quantity>
                                    </label>

                                    <button type="button" data-remove-entry-item class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                                        <x-gmdi-delete-o class="h-4 w-4" />
                                    </button>

                                    <label class="block md:col-span-3">
                                        <span class="{{ $labelClass }}">Observação do item</span>
                                        <input type="text" name="items[{{ $index }}][observacao]" value="{{ $row['observacao'] ?? null }}" class="{{ $inputClass }}" data-entry-observation>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @error('items') <span class="block px-5 pb-5 text-sm font-medium text-[#c2414b]">{{ $message }}</span> @enderror
                    </article>
                @elseif ($movementType === 'saida')
                    <x-donations.partials.form-shell title="Dados da saída" description="Beneficiária, data e situação da entrega." icon="gmdi-volunteer-activism-o">
                        <div>
                            <x-material.select name="id_beneficiaria" label="Beneficiária" :options="$beneficiaries" :selected="old('id_beneficiaria')" placeholder="Selecione" required />
                            @error('id_beneficiaria') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </div>

                        <label class="block">
                            <span class="{{ $labelClass }}">Data e hora</span>
                            <input type="datetime-local" name="data_hora" value="{{ old('data_hora', now()->format('Y-m-d\TH:i')) }}" class="{{ $inputClass }}" required>
                            @error('data_hora') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>

                        <div>
                            <x-material.select name="situacao" label="Situação" :options="['entregue' => 'Entregue', 'pendente' => 'Pendente', 'cancelada' => 'Cancelada']" :selected="old('situacao', 'entregue')" required />
                            @error('situacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </div>

                        <label class="block md:col-span-2">
                            <span class="{{ $labelClass }}">Observação</span>
                            <textarea name="observacao" class="{{ $textareaClass }}">{{ old('observacao') }}</textarea>
                            @error('observacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>
                    </x-donations.partials.form-shell>

                    <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]" data-distribution-items data-materials='@json($materialBalances)'>
                        <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                                    <x-gmdi-inventory-2-o class="h-5 w-5" />
                                </span>
                                <div>
                                    <h3 class="text-lg font-bold text-[#111827]">Itens entregues</h3>
                                    <p class="mt-1 text-sm text-[#667085]">Adicione os materiais e quantidades da saída.</p>
                                </div>
                            </div>

                            <button type="button" data-add-distribution-item class="inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Adicionar item" title="Adicionar item">
                                <x-gmdi-add class="h-5 w-5" />
                            </button>
                        </div>

                        <div class="space-y-3 p-5" data-distribution-items-list>
                            @foreach ($itemRows as $index => $row)
                                <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_10rem_2.5rem]" data-distribution-item-row>
                                    <div>
                                        <x-material.select name="items[{{ $index }}][id_material]" label="Material" :options="$materials" :selected="$row['id_material'] ?? null" placeholder="Selecione" />
                                    </div>

                                    <div class="block">
                                        <span class="{{ $labelClass }}">Quantidade disponível</span>
                                        <div class="mt-2 flex h-11 items-center rounded-[8px] bg-[#fbfaf9] px-3 text-sm font-semibold text-[#344054]" data-available-display>
                                            Selecione material
                                        </div>
                                    </div>

                                    <label class="block">
                                        <span class="{{ $labelClass }}">Quantidade</span>
                                        <input type="number" min="1" name="items[{{ $index }}][quantidade]" value="{{ $row['quantidade'] ?? null }}" class="{{ $inputClass }}" data-distribution-quantity>
                                    </label>

                                    <button type="button" data-remove-distribution-item class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                                        <x-gmdi-delete-o class="h-4 w-4" />
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <p class="hidden px-5 pb-5 text-sm font-medium text-[#c2414b]" data-stock-error></p>
                        @error('items') <span class="block px-5 pb-5 text-sm font-medium text-[#c2414b]">{{ $message }}</span> @enderror
                    </article>
                @elseif ($movementType === 'ajuste')
                    <x-donations.partials.form-shell title="Dados do ajuste" description="Material, operação, quantidade e justificativa." icon="gmdi-swap-horiz-o">
                        <div>
                            <x-material.select name="id_material" label="Material" :options="$materials" :selected="old('id_material', $selectedMaterial)" placeholder="Selecione" required />
                            @error('id_material') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-material.select name="operacao" label="Operação" :options="['adicionar' => 'Adicionar ao estoque', 'subtrair' => 'Subtrair do estoque']" :selected="old('operacao', 'adicionar')" required />
                            @error('operacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </div>

                        <label class="block">
                            <span class="{{ $labelClass }}">Quantidade</span>
                            <input type="number" min="1" name="quantidade" value="{{ old('quantidade') }}" class="{{ $inputClass }}" required>
                            @error('quantidade') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="{{ $labelClass }}">Data e hora</span>
                            <input type="datetime-local" name="data_hora" value="{{ old('data_hora', now()->format('Y-m-d\TH:i')) }}" class="{{ $inputClass }}" required>
                            @error('data_hora') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>

                        <label class="block md:col-span-2">
                            <span class="{{ $labelClass }}">Observação</span>
                            <textarea name="observacao" class="{{ $textareaClass }}" required>{{ old('observacao') }}</textarea>
                            @error('observacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                        </label>
                    </x-donations.partials.form-shell>
                @endif

                <x-donations.partials.actions :cancel-route="route('movements.index')" :submit-label="$page['title']" />
            </form>

            @if ($movementType === 'entrada')
                @include('pages.donations.partials.donor-modal')
            @endif
        @endif
    </section>

    @if ($movementType === 'entrada')
        <template data-entry-item-template>
            <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_2.5rem]" data-entry-item-row>
                <div>
                    <x-material.select name="items[__INDEX__][id_material]" label="Material" :options="$materials" :selected="null" placeholder="Selecione" />
                </div>

                <label class="block">
                    <span class="{{ $labelClass }}">Quantidade</span>
                    <input type="number" min="1" class="{{ $inputClass }}" data-entry-quantity>
                </label>

                <button type="button" data-remove-entry-item class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                    <x-gmdi-delete-o class="h-4 w-4" />
                </button>

                <label class="block md:col-span-3">
                    <span class="{{ $labelClass }}">Observação do item</span>
                    <input type="text" class="{{ $inputClass }}" data-entry-observation>
                </label>
            </div>
        </template>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-entry-items]');
                if (! root) return;

                const list = root.querySelector('[data-entry-items-list]');
                const template = document.querySelector('[data-entry-item-template]');
                const addButton = root.querySelector('[data-add-entry-item]');
                const rows = () => Array.from(list.querySelectorAll('[data-entry-item-row]'));

                const syncNames = () => {
                    rows().forEach((row, index) => {
                        row.querySelector('md-outlined-select, select')?.setAttribute('name', `items[${index}][id_material]`);
                        row.querySelector('[data-entry-quantity]')?.setAttribute('name', `items[${index}][quantidade]`);
                        row.querySelector('[data-entry-observation]')?.setAttribute('name', `items[${index}][observacao]`);
                    });
                };

                const bindRow = (row) => {
                    row.querySelector('[data-remove-entry-item]')?.addEventListener('click', () => {
                        if (rows().length > 1) {
                            row.remove();
                        } else {
                            const select = row.querySelector('md-outlined-select, select');
                            select.value = '';
                            select.querySelector('md-select-option[selected]')?.removeAttribute('selected');
                            row.querySelector('[data-entry-quantity]').value = '';
                            row.querySelector('[data-entry-observation]').value = '';
                        }

                        syncNames();
                    });
                };

                rows().forEach(bindRow);

                addButton?.addEventListener('click', () => {
                    const row = template.content.firstElementChild.cloneNode(true);
                    list.appendChild(row);
                    bindRow(row);
                    syncNames();
                });

                root.closest('form')?.addEventListener('submit', syncNames);

                syncNames();
            });
        </script>
    @endif

    @if ($movementType === 'saida')
        <template data-distribution-item-template>
            <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_10rem_2.5rem]" data-distribution-item-row>
                <div>
                    <x-material.select name="items[__INDEX__][id_material]" label="Material" :options="$materials" :selected="null" placeholder="Selecione" />
                </div>

                <div class="block">
                    <span class="{{ $labelClass }}">Quantidade disponível</span>
                    <div class="mt-2 flex h-11 items-center rounded-[8px] bg-[#fbfaf9] px-3 text-sm font-semibold text-[#344054]" data-available-display>
                        Selecione material
                    </div>
                </div>

                <label class="block">
                    <span class="{{ $labelClass }}">Quantidade</span>
                    <input type="number" min="1" class="{{ $inputClass }}" data-distribution-quantity>
                </label>

                <button type="button" data-remove-distribution-item class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                    <x-gmdi-delete-o class="h-4 w-4" />
                </button>
            </div>
        </template>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-distribution-items]');
                if (! root) return;

                const list = root.querySelector('[data-distribution-items-list]');
                const template = document.querySelector('[data-distribution-item-template]');
                const addButton = root.querySelector('[data-add-distribution-item]');
                const form = root.closest('form');
                const submitButton = form?.querySelector('button[type="submit"]');
                const error = root.querySelector('[data-stock-error]');
                const materials = JSON.parse(root.dataset.materials || '{}');

                const selectValue = (select) => {
                    if (! select) return '';
                    if (select.value) return select.value;

                    return select.querySelector('md-select-option[selected]')?.getAttribute('value') || '';
                };

                const selectedLabel = (select) => select?.querySelector('md-select-option[selected] [slot="headline"]')?.textContent?.trim() || 'material selecionado';
                const formatQuantity = (amount, unit) => `${amount} ${unit}${amount === 1 || unit.endsWith('s') ? '' : 's'}`;
                const rows = () => Array.from(list.querySelectorAll('[data-distribution-item-row]'));

                const syncNames = () => {
                    rows().forEach((row, index) => {
                        row.querySelector('md-outlined-select, select')?.setAttribute('name', `items[${index}][id_material]`);
                        row.querySelector('[data-distribution-quantity]')?.setAttribute('name', `items[${index}][quantidade]`);
                    });
                };

                const validate = () => {
                    const totals = {};
                    let message = '';

                    rows().forEach((row) => {
                        const select = row.querySelector('md-outlined-select, select');
                        const quantity = row.querySelector('[data-distribution-quantity]');
                        const materialId = selectValue(select);
                        const requested = Number(quantity?.value || 0);
                        const material = materials[materialId];

                        if (quantity) quantity.max = material?.available ?? '';
                        if (! materialId || requested <= 0) return;

                        totals[materialId] = (totals[materialId] || 0) + requested;
                        if (material && requested > material.available) {
                            message = `Quantidade maior que disponível para ${selectedLabel(select)}.`;
                        }
                    });

                    rows().forEach((row) => {
                        const select = row.querySelector('md-outlined-select, select');
                        const available = row.querySelector('[data-available-display]');
                        const materialId = selectValue(select);
                        const totalRequested = totals[materialId] || 0;
                        const material = materials[materialId];
                        const isNegative = material && totalRequested > material.available;

                        if (available) {
                            available.textContent = material ? formatQuantity(material.available - totalRequested, material.unit) : 'Selecione material';
                            available.classList.toggle('bg-[#fff1f1]', Boolean(isNegative));
                            available.classList.toggle('text-[#c2414b]', Boolean(isNegative));
                        }
                    });

                    Object.entries(totals).forEach(([materialId, requested]) => {
                        const material = materials[materialId];
                        if (material && requested > material.available) {
                            message = `Total solicitado (${requested}) maior que disponível (${material.available}) para material repetido.`;
                        }
                    });

                    error.textContent = message;
                    error.classList.toggle('hidden', message === '');
                    if (submitButton) submitButton.disabled = message !== '';
                    if (submitButton) submitButton.classList.toggle('opacity-60', message !== '');

                    return message === '';
                };

                const bindRow = (row) => {
                    const select = row.querySelector('md-outlined-select, select');

                    select?.addEventListener('input', validate);
                    select?.addEventListener('change', validate);
                    row.querySelector('[data-distribution-quantity]')?.addEventListener('input', validate);
                    row.querySelector('[data-remove-distribution-item]')?.addEventListener('click', () => {
                        if (rows().length > 1) {
                            row.remove();
                        } else {
                            select.value = '';
                            select.querySelector('md-select-option[selected]')?.removeAttribute('selected');
                            row.querySelector('[data-distribution-quantity]').value = '';
                        }

                        syncNames();
                        validate();
                    });
                };

                rows().forEach(bindRow);

                addButton?.addEventListener('click', () => {
                    const row = template.content.firstElementChild.cloneNode(true);
                    list.appendChild(row);
                    bindRow(row);
                    syncNames();
                    validate();
                });

                form?.addEventListener('submit', (event) => {
                    syncNames();
                    if (! validate()) event.preventDefault();
                });

                syncNames();
                validate();
            });
        </script>
    @endif
@endsection
