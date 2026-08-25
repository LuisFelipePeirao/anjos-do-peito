@extends('layouts.main-pages')

@section('title', 'Nova beneficiária')
@section('active-menu', 'beneficiaries.index')
@section('breadcrumb', 'Beneficiárias')
@section('page-title', 'Nova beneficiária')

@section('content')
    <section class="space-y-6">
        <x-app.page-info subheading="Cadastro de beneficiárias" title="Nova beneficiária" description="Registre os dados pessoais, contatos e endereço da mãe atendida." :firstButton="['label' => 'Voltar para lista', 'link' => route('beneficiaries.index'), 'icon' => 'arrow-left']" />
        <form action="{{ route('beneficiaries.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('pages.beneficiaries.partials.form', ['beneficiaria' => null])
            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8"><div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:justify-end"><a href="{{ route('beneficiaries.index') }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">Cancelar</a><button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]"><x-lucide-save class="h-4 w-4" /> Salvar beneficiária</button></div></div>
        </form>
    </section>
@endsection
