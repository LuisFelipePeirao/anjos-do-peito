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
            ]"
            :secondButton="[
                'label' => 'Novo local',
                'link' => '#',
                'icon' => 'add',
                'dialog' => 'attendance-location-create-dialog',
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
            :delete-confirmation="[
                'title' => 'Excluir atendimento?',
                'message' => 'As informações deste atendimento deixarão de aparecer no histórico. Deseja continuar?',
                'confirmLabel' => 'Excluir atendimento',
            ]"
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
                            ['value' => 'agendado', 'label' => 'Agendados'],
                            ['value' => 'em_atendimento', 'label' => 'Em andamento'],
                            ['value' => 'realizado', 'label' => 'Realizados'],
                            ['value' => 'cancelado', 'label' => 'Cancelados'],
                        ],
                    ],
                    [
                        'name' => 'modality',
                        'label' => 'Modalidade do atendimento',
                        'value' => $modality,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as modalidades'],
                            ['value' => 'presencial', 'label' => 'Presencial'],
                            ['value' => 'remota', 'label' => 'Remota'],
                        ],
                    ],
                ],
            ]" />

        @include('pages.attendances.partials.location-modal')

        @if ($errors->location->any())
            <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('attendance-location-create-dialog')?.showModal());</script>
        @endif
    </section>
@endsection
