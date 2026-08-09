@extends('layouts.main-pages')

@section('title', 'Home')
@section('active-menu', 'home')
@section('breadcrumb', 'Início')
@section('page-title', 'Visão geral')

@section('content')
    <section class="space-y-6">

        <x-app.page-info
            title="Visão geral da operação"
            description="Indicadores de atendimento, estoque e pontos de atenção para hoje, {{ date('d/m/Y') }}."
            :firstButton="[
                'label' => 'Novo atendimento',
                'link' => '#',
                'icon' => 'clipboard-list',
            ]"
            :secondButton="[
                'label' => 'Nova beneficiária',
                'link' => '#',
                'icon' => 'users',
            ]"
        />


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

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1.45fr)_minmax(360px,0.85fr)]">
            <x-chart.column-chart
                title="Atendimentos mensais"
                description="Comparativo entre realizados e meta operacional."
                :data="$monthlyAttendances"
                subtitle-one="Realizado"
                subtitle-two="Meta"
            />

            <x-chart.stock-distribution
                title="Distribuição do estoque"
                description="Itens disponíveis versus itens em uso."
                :data="$stock"
                :total-stock="$totalStock"
            />
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <x-chart.pipeline-chart
                title="Fluxo de atendimento"
                description="Volume por etapa ativa da jornada."
                :data="$pipeline"
            />

            <x-dashboard.priority-alerts
                title="Atenções prioritárias"
                description="Pendências que exigem ação da equipe."
                :data="$risks"
            />

            <x-dashboard.recent-activities
                title="Atividades recentes"
                description="Últimos registros operacionais lançados."
                :data="$recent"
            />
        </div>
    </section>
@endsection
