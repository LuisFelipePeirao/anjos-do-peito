@extends('layouts.main-login')

@section('title', 'Entrar')
@section('content')

    <form action="{{ route('home') }}" class="w-72.5 md:w-80">
        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Seja Bem-vindo!</h1>

        <x-material.input label="Usuário">
            <x-slot:icon>
                <x-gmdi-account-circle-o />
            </x-slot:icon>
        </x-material.input>

        <x-material.input label="Senha" type="password">
            <x-slot:icon>
                <x-gmdi-lock-o />
            </x-slot:icon>
        </x-material.input>

        <a href="{{ route("recover-password") }}"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Esqueceu
            a Senha?</a>

        <x-login.login-button value="Entrar"/>
    </form>
@endsection
