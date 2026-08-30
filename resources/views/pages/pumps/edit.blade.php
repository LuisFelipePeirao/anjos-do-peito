@extends('layouts.main-pages')

@section('title', 'Editar bomba de leite')
@section('active-menu', 'pumps.index')
@section('breadcrumb', 'Bombas de leite')
@section('page-title', 'Editar bomba de leite')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Cadastro de bombas"
            title="Editar bomba de leite"
            description="Atualize identificação, origem e acessórios do equipamento."
            :firstButton="['label' => 'Voltar para detalhes', 'link' => route('pumps.show', $pump), 'icon' => 'arrow-left']" />

        <form method="POST" action="{{ route('pumps.update', $pump) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('pages.pumps.partials.form')
            @include('pages.pumps.partials.actions', ['cancelRoute' => route('pumps.show', $pump), 'submitLabel' => 'Atualizar bomba'])
        </form>
    </section>
@endsection
