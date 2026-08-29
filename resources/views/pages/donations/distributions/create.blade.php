@extends('layouts.main-pages')

@section('title', 'Registrar distribuição')
@section('active-menu', 'donations.index')
@section('breadcrumb', 'Doações e estoque')
@section('page-title', 'Registrar distribuição')

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
            subheading="Distribuições"
            title="Registrar distribuição"
            description="Relacione materiais entregues à beneficiária e baixe estoque automaticamente."
            :firstButton="['label' => 'Voltar para lista', 'link' => route('donations.index'), 'icon' => 'arrow-left']" />

        <form method="POST" action="{{ route('donations.distributions.store') }}" class="space-y-6">
            @csrf
            <x-donations.partials.form-shell title="Dados da distribuição" description="Beneficiária, data e situação da entrega." icon="gmdi-volunteer-activism-o">
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

            <article
                class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]"
                data-distribution-items
                data-materials='@json($materialBalances)'
            >
                <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <x-gmdi-inventory-2-o class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Itens distribuídos</h3>
                            <p class="mt-1 text-sm text-[#667085]">Adicione quantos materiais forem necessários.</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        data-add-distribution-item
                        class="inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]"
                        aria-label="Adicionar item"
                        title="Adicionar item">
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

                            <button
                                type="button"
                                data-remove-distribution-item
                                class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]"
                                aria-label="Remover item"
                                title="Remover item">
                                <x-gmdi-delete-o class="h-4 w-4" />
                            </button>
                        </div>
                    @endforeach
                </div>

                <p class="hidden px-5 pb-5 text-sm font-medium text-[#c2414b]" data-stock-error></p>
                @error('items') <span class="block px-5 pb-5 text-sm font-medium text-[#c2414b]">{{ $message }}</span> @enderror
            </article>

            <x-donations.partials.actions :cancel-route="route('donations.index')" submit-label="Registrar distribuição" />
        </form>
    </section>

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

            <button
                type="button"
                data-remove-distribution-item
                class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]"
                aria-label="Remover item"
                title="Remover item">
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

            const selectedLabel = (select) => {
                if (! select) return 'material selecionado';
                if (select.options) return select.options[select.selectedIndex]?.text || 'material selecionado';

                return select.querySelector('md-select-option[selected] [slot="headline"]')?.textContent?.trim()
                    || 'material selecionado';
            };

            const formatQuantity = (amount, unit) => `${amount} ${unit}${amount === 1 || unit.endsWith('s') ? '' : 's'}`;

            const formatAvailable = (materialId, requested = 0) => {
                const material = materials[materialId];
                if (! material) return 'Selecione material';

                return formatQuantity(material.available - requested, material.unit);
            };

            const rows = () => Array.from(list.querySelectorAll('[data-distribution-item-row]'));

            const syncNames = () => {
                rows().forEach((row, index) => {
                    const select = row.querySelector('md-outlined-select, select');
                    const quantity = row.querySelector('[data-distribution-quantity]');

                    if (select) select.setAttribute('name', `items[${index}][id_material]`);
                    if (quantity) quantity.setAttribute('name', `items[${index}][quantidade]`);
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
                        available.textContent = formatAvailable(materialId, totalRequested);
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
                        const select = row.querySelector('md-outlined-select, select');
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
@endsection
