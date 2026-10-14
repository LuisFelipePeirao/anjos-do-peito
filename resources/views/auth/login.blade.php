@extends('layouts.main-login')

@section('title', 'Entrar')
@section('content')

    <form action="{{ route('login.store') }}" method="POST" class="w-72.5 md:w-80" aria-labelledby="login-title">
        @csrf

        <h1 id="login-title" class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Seja Bem-vindo!</h1>

        <x-material.input label="E-mail" name="email" type="email" value="{{ old('email') }}" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}">
            <x-slot:icon>
                <x-gmdi-account-circle-o />
            </x-slot:icon>
        </x-material.input>

        <x-material.input label="Senha" name="senha" type="password" :password-toggle="true" aria-invalid="{{ $errors->has('senha') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('senha') ? 'senha-error' : '' }}">
            <x-slot:icon>
                <x-gmdi-lock-o />
            </x-slot:icon>
        </x-material.input>

        @error('email')
            <p id="email-error" class="mb-4 text-sm font-medium text-red-700" role="alert">{{ $message }}</p>
        @enderror

        @error('senha')
            <p id="senha-error" class="mb-4 text-sm font-medium text-red-700" role="alert">{{ $message }}</p>
        @enderror

        @if (session('status'))
            <p class="mb-4 text-sm font-medium text-green-700" role="status" aria-live="polite">{{ session('status') }}</p>
        @endif

        <a href="{{ route('password.request') }}"
            class="mb-8 block text-right text-base font-medium text-[#526078] underline transition duration-500 hover:text-[#9d174d] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#9d174d]">Esqueceu
            a Senha?</a>

        <x-login.login-button value="Entrar"/>
    </form>
@endsection
