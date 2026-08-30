@extends('layouts.main-pages')

@section('title', 'Movimentações')
@section('active-menu', 'movements.index')
@section('breadcrumb', 'Movimentações')
@section('page-title', 'Movimentações')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Estoque"
            title="Movimentações"
            description="Acompanhe entradas, saídas e ajustes registrados no estoque."
            :firstButton="[
                'label' => 'Registrar movimentação',
                'link' => route('movements.create'),
                'icon' => 'add',
            ]" />

        <x-tables.datatable
            :header="['Data e hora', 'Tipo', 'Origem ou destino', 'Material', 'Responsável', 'Situação']"
            :data="$movements"
            :action="route('movements.index')"
            :filters="[
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar movimentações',
                    'placeholder' => 'Pesquisar por material, origem ou responsável',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'type',
                        'label' => 'Tipo',
                        'value' => $type,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todos os tipos'],
                            ['value' => 'entrada', 'label' => 'Entradas'],
                            ['value' => 'saida', 'label' => 'Saídas'],
                            ['value' => 'ajuste', 'label' => 'Ajustes'],
                        ],
                    ],
                ],
            ]" />
    </section>
@endsection
