@extends('layouts.main-pages')

@section('title', 'Beneficiárias')
@section('active-menu', 'beneficiaries.index')
@section('breadcrumb', 'Beneficiárias')
@section('page-title', 'Cadastro de beneficiárias')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Gestão de beneficiárias"
            title="Beneficiárias cadastradas"
            description="Consulte, filtre e acompanhe os cadastros das mães atendidas pela ONG."
            :firstButton="[
                'label' => 'Nova beneficiária',
                'link' => route('beneficiaries.create'),
                'icon' => 'add',
            ]" />

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($kpis as $kpi)
                <x-cards.dashboard-card
                    :label="$kpi['label']"
                    :value="$kpi['value']"
                    :tone="$kpi['tone']"
                    :icon="$kpi['icon']"
                    :context="$kpi['context']"
                />
            @endforeach
        </div>

        <x-tables.datatable
            :header="[
                'Nome',
                'CPF',
                'E-mail',
                'Contato',
                'Situação',
            ]"
            :data="$beneficiaries"
            :action="route('beneficiaries.index')"
            :filters="[
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar beneficiárias',
                    'placeholder' => 'Pesquisar beneficiárias por nome ou CPF',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação da beneficiária',
                        'value' => $status,
                        'options' => [
                            ['value' => 'active', 'label' => 'Somente ativas'],
                            ['value' => 'all', 'label' => 'Todas'],
                        ],
                    ],
                ],
            ]" />
    </section>
@endsection
