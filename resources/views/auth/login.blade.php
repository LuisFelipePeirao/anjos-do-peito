@extends('layouts.main-login')

@section('title', 'Entrar')
@section('content')
    <div class="w-72.5 md:w-80">
        <h1 id="login-title" class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Seja Bem-vindo!</h1>

        <noscript>
            <style>#login-enhanced-form { display: none; }</style>
            <form action="{{ route('login.store') }}" method="POST" aria-labelledby="login-title">
                @csrf

                <p class="mb-6 text-sm text-[#526078]">Use seus dados de acesso para entrar sem JavaScript.</p>

                <fieldset class="space-y-5">
                    <legend class="sr-only">Credenciais de acesso</legend>

                    <div>
                        <label for="email-sem-javascript" class="mb-1 block text-sm font-medium text-[#526078]">E-mail para acesso sem JavaScript</label>
                        <input id="email-sem-javascript" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @if ($errors->has('email')) aria-describedby="email-no-javascript-error" @endif class="w-full rounded border border-[#526078] px-3 py-3 text-[#1f2937]">
                        @error('email')
                            <p id="email-no-javascript-error" class="mt-1 text-sm font-medium text-red-700" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="senha-sem-javascript" class="mb-1 block text-sm font-medium text-[#526078]">Senha para acesso sem JavaScript</label>
                        <input id="senha-sem-javascript" name="senha" type="password" autocomplete="current-password" required aria-invalid="{{ $errors->has('senha') ? 'true' : 'false' }}" @if ($errors->has('senha')) aria-describedby="senha-no-javascript-error" @endif class="w-full rounded border border-[#526078] px-3 py-3 text-[#1f2937]">
                        @error('senha')
                            <p id="senha-no-javascript-error" class="mt-1 text-sm font-medium text-red-700" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </fieldset>

                @if (session('status'))
                    <p class="mt-4 text-sm font-medium text-green-700" role="status">{{ session('status') }}</p>
                @endif

                <a href="{{ route('password.request') }}" class="my-6 block text-right text-base font-medium text-[#526078] underline">Esqueceu a senha?</a>
                <button type="submit" class="w-full rounded-lg bg-[#c73570] p-4 text-base text-white">Entrar</button>
            </form>
        </noscript>

    <form id="login-enhanced-form" action="{{ route('login.store') }}" method="POST" aria-labelledby="login-title">
        @csrf

        <fieldset class="contents">
            <legend class="sr-only">Credenciais de acesso</legend>

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
        </fieldset>

        @if (session('status'))
            <p class="mb-4 text-sm font-medium text-green-700" role="status" aria-live="polite">{{ session('status') }}</p>
        @endif

        <a href="{{ route('password.request') }}"
            class="mb-8 block text-right text-base font-medium text-[#526078] underline transition duration-500 hover:text-[#9d174d] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#9d174d]">Esqueceu
            a Senha?</a>

        <x-login.login-button value="Entrar"/>
    </form>
    </div>
@endsection
