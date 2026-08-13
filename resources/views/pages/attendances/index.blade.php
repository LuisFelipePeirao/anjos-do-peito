@extends('layouts.main-pages')

@section('title', 'Atendimentos')
@section('active-menu', 'attendances.index')
@section('breadcrumb', 'Atendimentos')
@section('page-title', 'Gestão de atendimentos')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Gestão de atendimentos"
            title="Atendimentos registrados"
            description="Consulte, filtre e acompanhe os atendimentos realizados ou agendados pela equipe."
            :firstButton="[
                'label' => 'Novo atendimento',
                'link' => route('attendances.create'),
                'icon' => 'add',
            ]" />

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($kpis as $kpi)
                <x-cards.dashboard-card
                    :label="$kpi['label']"
                    :value="$kpi['value']"
                    :tone="$kpi['tone']"
                    :icon="$kpi['icon']"
                    :context="$kpi['context']"
                    :arrow="$kpi['trendType']"
                    :percent="$kpi['trend']"
                />
            @endforeach
        </div>

        <x-tables.datatable
            :header="[
                'Data',
                'Horário',
                'Beneficiária',
                'Profissional',
                'Modalidade',
                'Situação',
            ]"
            :data="$attendances"
            :action="route('attendances.index')"
            :filters="[
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar atendimentos',
                    'placeholder' => 'Pesquisar por beneficiária, profissional ou resumo',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do atendimento',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'Agendado', 'label' => 'Agendados'],
                            ['value' => 'Realizado', 'label' => 'Realizados'],
                            ['value' => 'Retorno pendente', 'label' => 'Retorno pendente'],
                            ['value' => 'Cancelado', 'label' => 'Cancelados'],
                        ],
                    ],
                    [
                        'name' => 'modality',
                        'label' => 'Modalidade do atendimento',
                        'value' => $modality,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as modalidades'],
                            ['value' => 'Presencial', 'label' => 'Presencial'],
                            ['value' => 'Remota', 'label' => 'Remota'],
                        ],
                    ],
                ],
            ]" />
    </section>
@endsection
