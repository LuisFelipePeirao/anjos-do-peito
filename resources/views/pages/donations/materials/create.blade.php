@extends('layouts.main-pages')

@section('title', 'Novo item de estoque')
@section('active-menu', 'donations.index')
@section('breadcrumb', 'Doações e estoque')
@section('page-title', 'Novo item de estoque')

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Estoque"
            title="Novo item de estoque"
            description="Cadastre material, categoria, unidade de medida e mínimo operacional."
            :firstButton="['label' => 'Voltar para lista', 'link' => route('donations.index'), 'icon' => 'arrow-left']" />

        <form method="POST" action="{{ route('donations.materials.store') }}" class="space-y-6">
            @csrf
            <x-donations.partials.form-shell title="Dados do item" description="Informações usadas no saldo e nos alertas de reposição.">
                <label class="block">
                    <span class="{{ $labelClass }}">Nome</span>
                    <input type="text" name="nome" value="{{ old('nome') }}" class="{{ $inputClass }}" placeholder="Ex.: Fralda tamanho P" required>
                    @error('nome') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </label>

                <div>
                    <x-material.select name="id_categoria" label="Categoria" :options="$categories" :selected="old('id_categoria')" placeholder="Selecione" required />
                    @error('id_categoria') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </div>

                <label class="block">
                    <span class="{{ $labelClass }}">Unidade de medida</span>
                    <input type="text" name="unidade_medida" value="{{ old('unidade_medida') }}" class="{{ $inputClass }}" placeholder="Ex.: pacote" required>
                    @error('unidade_medida') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="{{ $labelClass }}">Estoque mínimo</span>
                    <input type="number" min="0" name="estoque_minimo" value="{{ old('estoque_minimo', 0) }}" class="{{ $inputClass }}" required>
                    @error('estoque_minimo') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </label>
            </x-donations.partials.form-shell>

            <x-donations.partials.actions :cancel-route="route('donations.index')" submit-label="Salvar item" />
        </form>
    </section>
@endsection
