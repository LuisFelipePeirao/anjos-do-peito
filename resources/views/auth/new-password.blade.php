@extends('layouts.main-login')

@section('title', 'Nova Senha')
@section('content')

    <form action="{{ route('password.update') }}" method="POST" class="w-72.5 md:w-80">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ old('email', $email) }}">

        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Nova Senha</h1>

        <x-material.input label="Senha" name="senha" type="password">
            <x-slot:icon>
                <x-gmdi-lock-o />
            </x-slot:icon>
        </x-material.input>

        <x-material.input label="Confirmar senha" name="senha_confirmation" type="password">
            <x-slot:icon>
                <x-gmdi-lock-o />
            </x-slot:icon>
        </x-material.input>

        @error('email')
            <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror

        @error('senha')
            <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror

        <a href="{{ route('login') }}"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Acessar
            o sistema</a>

        <x-login.login-button value="Redefinir Senha" />
    </form>
@endsection
