@extends('layouts.main-pages')

@section('title', 'Registrar doação')
@section('active-menu', 'donations.index')
@section('breadcrumb', 'Doações e estoque')
@section('page-title', 'Registrar doação')

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Doações"
            title="Registrar doação"
            description="Registre entrada de materiais e gere movimentação de estoque automaticamente."
            :firstButton="['label' => 'Novo doador', 'link' => '#', 'icon' => 'person-add-o', 'dialog' => 'donation-donor-create-dialog']"
            :secondButton="['label' => 'Novo item', 'link' => route('donations.materials.create'), 'icon' => 'add']" />

        <form method="POST" action="{{ route('donations.store') }}" class="space-y-6">
            @csrf
            <x-donations.partials.form-shell title="Dados da doação" description="Origem, data e situação do recebimento." icon="gmdi-card-giftcard-o">
                <div>
                    <x-material.select name="id_doador" label="Doador" :options="$donors" :selected="old('id_doador')" placeholder="Selecione" required />
                    @error('id_doador') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </div>

                <label class="block">
                    <span class="{{ $labelClass }}">Data e hora</span>
                    <input type="datetime-local" name="data_doacao" value="{{ old('data_doacao', now()->format('Y-m-d\TH:i')) }}" class="{{ $inputClass }}" required>
                    @error('data_doacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
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

            <x-donations.partials.form-shell title="Itens recebidos" description="Até três itens por lançamento rápido." icon="gmdi-inventory-2-o">
                @for ($index = 0; $index < 3; $index++)
                    <div class="rounded-[8px] border border-[#eadfe0] p-4 md:col-span-2">
                        <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_10rem]">
                            <div>
                                <x-material.select name="items[{{ $index }}][id_material]" label="Material" :options="$materials" :selected="old('items.'.$index.'.id_material')" placeholder="Selecione" />
                            </div>
                            <label class="block">
                                <span class="{{ $labelClass }}">Quantidade</span>
                                <input type="number" min="1" name="items[{{ $index }}][quantidade]" value="{{ old('items.'.$index.'.quantidade') }}" class="{{ $inputClass }}">
                            </label>
                            <label class="block md:col-span-2">
                                <span class="{{ $labelClass }}">Observação do item</span>
                                <input type="text" name="items[{{ $index }}][observacao]" value="{{ old('items.'.$index.'.observacao') }}" class="{{ $inputClass }}">
                            </label>
                        </div>
                    </div>
                @endfor
                @error('items') <span class="md:col-span-2 text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </x-donations.partials.form-shell>

            <x-donations.partials.actions :cancel-route="route('donations.index')" submit-label="Registrar doação" />
        </form>

        @include('pages.donations.partials.donor-modal')
    </section>
@endsection
