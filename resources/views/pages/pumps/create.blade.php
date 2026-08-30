@extends('layouts.main-pages')

@section('title', 'Nova bomba de leite')
@section('active-menu', 'pumps.index')
@section('breadcrumb', 'Bombas de leite')
@section('page-title', 'Nova bomba de leite')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Cadastro de bombas"
            title="Nova bomba de leite"
            description="Registre identificação, origem e acessórios do equipamento."
            :firstButton="['label' => 'Voltar para lista', 'link' => route('pumps.index'), 'icon' => 'arrow-left']" />

        <form method="POST" action="{{ route('pumps.store') }}" class="space-y-6">
            @csrf
            @include('pages.pumps.partials.form')
            @include('pages.pumps.partials.actions', ['cancelRoute' => route('pumps.index'), 'submitLabel' => 'Salvar bomba'])
        </form>
    </section>
@endsection
