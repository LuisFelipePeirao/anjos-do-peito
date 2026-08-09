@extends('layouts.main-login')

@section('title', 'Nova Senha')
@section('content')

    <form action="{{ route('auth.login') }}" class="w-72.5 md:w-80">
        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Nova Senha</h1>

        <x-login.login-input label="Senha" type="password">
            <x-slot:icon>
                <x-lucide-lock-keyhole />
            </x-slot:icon>
        </x-login.login-input>

        <x-login.login-input label="Confirmar senha" type="password">
            <x-slot:icon>
                <x-lucide-lock-keyhole />
            </x-slot:icon>
        </x-login.login-input>

        <a href="{{ route("recover.password") }}"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Acessar
            o sistema</a>

        <x-login.login-button value="Redefinir Senha" />
    </form>
@endsection