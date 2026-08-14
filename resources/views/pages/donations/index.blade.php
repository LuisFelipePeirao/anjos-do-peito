@extends('layouts.main-pages')

@section('title', 'Doações e estoque')
@section('active-menu', 'donations.index')
@section('breadcrumb', 'Doações e estoque')
@section('page-title', 'Gestão de doações e estoque')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Gestão de estoque"
            title="Doações e estoque"
            description="Acompanhe entradas, distribuições, saldo por categoria e itens que precisam de reposição."
            :firstButton="[
                'label' => 'Registrar doação',
                'link' => '#registrar-doacao',
                'icon' => 'add',
            ]"
            :secondButton="[
                'label' => 'Registrar distribuição',
                'link' => '#registrar-distribuicao',
                'icon' => 'volunteer-activism-o',
            ]" />

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

        <x-tables.datatable
            :header="[
                'Descrição',
                'Categoria',
                'Quantidade',
                'Situação',
                'Última movimentação',
            ]"
            :data="$materials"
            :action="route('donations.index')"
            :delete-confirmation="[
                'title' => 'Excluir item do estoque?',
                'message' => 'O item será removido da listagem, mas suas movimentações permanecerão no histórico. Deseja continuar?',
                'confirmLabel' => 'Excluir item',
                'variant' => 'danger',
            ]"
            :filters="[
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar materiais',
                    'placeholder' => 'Pesquisar por descrição ou categoria',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do estoque',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'Crítico', 'label' => 'Críticos'],
                            ['value' => 'Baixo', 'label' => 'Baixos'],
                            ['value' => 'Normal', 'label' => 'Normais'],
                        ],
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Categoria',
                        'value' => $category,
                        'options' => collect([['value' => 'all', 'label' => 'Todas as categorias']])
                            ->merge(collect($categories)->map(fn ($stockCategory) => ['value' => $stockCategory, 'label' => $stockCategory]))
                            ->all(),
                    ],
                ],
            ]" />
    </section>
@endsection
