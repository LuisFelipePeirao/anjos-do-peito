@extends('layouts.main-login')

@section('title', 'Recuperar Senha')
@section('content')

    <form action="{{ route('auth.new-password') }}" class="w-72.5 md:w-80">
        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Recuperar Senha</h1>

        <x-login.login-input label="E-mail" type="email">
            <x-slot:icon>
                <x-lucide-mail />
            </x-slot:icon>
        </x-login.login-input>

        <x-login.login-span>
            Insira o seu e-mail no campo acima para recuperar sua senha. 
            Se o e-mail informado estiver cadastrado, você receberá um link para criar uma nova senha.
        </x-login.login-span>

        <a href="{{ route("auth.login") }}"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Acessar
            o sistema</a>

        <x-login.login-button value="Enviar E-mail" />
    </form>
@endsection