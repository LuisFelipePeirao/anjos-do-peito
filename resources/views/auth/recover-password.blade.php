@extends('layouts.main-login')

@section('title', 'Recuperar Senha')
@section('content')

    <form action="{{ route('password.email') }}" method="POST" class="w-72.5 md:w-80">
        @csrf

        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Recuperar Senha</h1>

        <x-material.input label="E-mail" name="email" type="email" value="{{ old('email') }}">
            <x-slot:icon>
                <x-gmdi-mail-o />
            </x-slot:icon>
        </x-material.input>

        @if (session('status'))
            <p class="mb-4 text-sm font-medium text-green-700">{{ session('status') }}</p>
        @endif

        @error('email')
            <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror

        <x-login.login-span>
            Insira o seu e-mail no campo acima para recuperar sua senha.
            Se o e-mail informado estiver cadastrado, voce recebera um link para criar uma nova senha.
        </x-login.login-span>

        <a href="{{ route('login') }}"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Acessar
            o sistema</a>

        <x-login.login-button value="Enviar E-mail" />
    </form>
@endsection
