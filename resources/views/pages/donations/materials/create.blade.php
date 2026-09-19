@extends('layouts.main-pages')

@section('title', 'Novo item de estoque')
@section('active-menu', 'donations.index')
@section('breadcrumb', 'Itens de estoque')
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
                <x-material.floating-input name="nome" label="Nome" :value="old('nome')" placeholder="Ex.: Fralda tamanho P" required />

                <div>
                    <x-material.select name="id_categoria" label="Categoria" :options="$categories" :selected="old('id_categoria')" placeholder="Selecione" required />
                    @error('id_categoria') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </div>

                <x-material.floating-input name="unidade_medida" label="Unidade de medida" :value="old('unidade_medida')" placeholder="Ex.: pacote" required />

                <x-material.floating-input type="number" name="estoque_minimo" label="Estoque mínimo" :value="old('estoque_minimo', 0)" min="0" required />
            </x-donations.partials.form-shell>

            <x-donations.partials.actions :cancel-route="route('donations.index')" submit-label="Salvar item" />
        </form>
    </section>
@endsection
