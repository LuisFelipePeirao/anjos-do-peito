@extends('layouts.main-pages')

@section('title', 'Usuarios internos')
@section('page-title', 'Usuarios internos')
@section('active-menu', 'users.index')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Administração"
            title="Usuários internos"
            description="Gerencie os acessos da equipe da ONG."
            :firstButton="['label' => 'Novo usuário', 'link' => route('users.create'), 'icon' => 'add']"
        />

        @if (session('status'))
            <p class="rounded-[8px] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">{{ session('status') }}</p>
        @endif

        @error('usuario')
            <p class="rounded-[8px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ $message }}</p>
        @enderror

        <x-tables.datatable
            :header="[
                'Nome',
                'E-mail',
                'Perfil',
                'Situação',
            ]"
            :data="$users"
            :action="route('users.index')"
            :filters="[
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar usuários',
                    'placeholder' => 'Pesquisar por nome ou e-mail',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do usuário',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'active', 'label' => 'Ativos'],
                            ['value' => 'inactive', 'label' => 'Inativos'],
                        ],
                    ],
                    [
                        'name' => 'profile',
                        'label' => 'Perfil de acesso',
                        'value' => $profile,
                        'options' => collect([['value' => 'all', 'label' => 'Todos os perfis']])
                            ->merge(collect($profiles)->map(fn ($userProfile) => [
                                'value' => $userProfile,
                                'label' => ucfirst($userProfile),
                            ]))
                            ->all(),
                    ],
                ],
            ]"
        />
    </section>
@endsection
