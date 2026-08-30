@extends('layouts.main-login')

@section('title', 'Entrar')
@section('content')

    <form action="{{ route('login.store') }}" method="POST" class="w-72.5 md:w-80">
        @csrf

        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Seja Bem-vindo!</h1>

        <x-material.input label="E-mail" name="email" type="email" value="{{ old('email') }}">
            <x-slot:icon>
                <x-gmdi-account-circle-o />
            </x-slot:icon>
        </x-material.input>

        <x-material.input label="Senha" name="senha" type="password">
            <x-slot:icon>
                <x-gmdi-lock-o />
            </x-slot:icon>
        </x-material.input>

        @error('email')
            <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror

        @if (session('status'))
            <p class="mb-4 text-sm font-medium text-green-700">{{ session('status') }}</p>
        @endif

        <a href="{{ route('password.request') }}"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Esqueceu
            a Senha?</a>

        <x-login.login-button value="Entrar"/>
    </form>
@endsection
