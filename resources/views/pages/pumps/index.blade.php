@extends('layouts.main-pages')

@section('title', 'Bombas de leite')
@section('active-menu', 'pumps.index')
@section('breadcrumb', 'Bombas de leite')
@section('page-title', 'Gestão de bombas de leite')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Gestão de bombas"
            title="Bombas de leite"
            description="Acompanhe disponibilidade, empréstimos, devoluções e manutenção dos equipamentos da ONG."
            :firstButton="[
                'label' => 'Nova bomba',
                'link' => route('pumps.create'),
                'icon' => 'add',
            ]"
            :secondButton="[
                'label' => 'Registrar empréstimo',
                'link' => route('pumps.loans.create'),
                'icon' => 'trending-up',
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
                'Código',
                'Modelo',
                'Beneficiária',
                'Data de retirada',
                'Devolução prevista',
                'Situação',
            ]"
            :data="$pumps"
            :action="route('pumps.index')"
            :filters="[
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar bombas',
                    'placeholder' => 'Pesquisar por código, modelo ou beneficiária',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação da bomba',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'Disponível', 'label' => 'Disponíveis'],
                            ['value' => 'Emprestada', 'label' => 'Emprestadas'],
                            ['value' => 'Em atraso', 'label' => 'Em atraso'],
                            ['value' => 'Manutenção', 'label' => 'Manutenção'],
                        ],
                    ],
                    [
                        'name' => 'model',
                        'label' => 'Modelo da bomba',
                        'value' => $model,
                        'options' => collect([['value' => 'all', 'label' => 'Todos os modelos']])
                            ->merge(collect($models)->map(fn ($pumpModel) => ['value' => $pumpModel, 'label' => $pumpModel]))
                            ->all(),
                    ],
                ],
            ]" />
    </section>
@endsection
