@extends('layouts.main-pages')

@section('title', 'Editar usuário')
@section('active-menu', 'users.index')
@section('breadcrumb', 'Usuários')
@section('page-title', 'Editar usuário')

@section('content')
    <section class="space-y-6">
        <x-app.page-info
            subheading="Cadastro de usuários"
            title="Editar usuário"
            description="Atualize dados de identificação, perfil de acesso e credenciais da equipe."
            :firstButton="[
                'label' => 'Voltar para lista',
                'link' => route('users.index'),
                'icon' => 'arrow-left',
            ]" />

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @include('pages.users.partials.form', ['user' => $user])

            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8">
                <div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('users.index') }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
                        <x-lucide-save class="h-4 w-4" />
                        Atualizar usuário
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
