<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon_VITA.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script type="module" src="https://cdn.jsdelivr.net/gh/datvm/material-web@v2.3.0/dist/bundle.esm.min.js"></script>

        <title>@yield('title')</title>
    </head>
    <body class="m-0 min-h-screen overflow-hidden font-sans text-[#9d174d]">
        <a href="#inicio-conteudo" accesskey="1" class="sr-only absolute left-4 top-4 z-50 rounded bg-white px-4 py-2 text-[#1f2937] shadow focus:not-sr-only">
            Pular para conteúdo
        </a>
        <a id="inicio-conteudo" name="inicio-conteudo" tabindex="-1" class="sr-only">Início do conteúdo</a>
        <div class="relative h-screen overflow-hidden">
            <div aria-hidden="true" class="absolute -left-14 -top-28 h-52 w-52 rounded-full bg-linear-to-b from-[#ef5b97] to-transparent md:-left-26 md:-top-44 md:h-100 md:w-100"></div>
            <div aria-hidden="true" class="absolute -bottom-24 -right-22 h-52 w-52 rotate-180 rounded-full bg-linear-to-b from-[#ef5b97] to-transparent md:-right-26 md:h-75 md:w-75"></div>

            <main id="conteudo" tabindex="-1" class="grid h-screen place-items-center px-4 md:grid-cols-[1.5fr_1fr] md:px-8">
                @include('components.login.login-logo')

                @yield('content')

            </main>
        </div>
    </body>
</html>
