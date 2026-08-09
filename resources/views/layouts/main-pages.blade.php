<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title')</title>
</head>

<body>
    <div id="app-shell" class="app-shell min-h-screen bg-[#fbfaf9]" data-sidebar-collapsed="false" data-mobile-sidebar-open="false">
        <x-app.sidebar :active="trim($__env->yieldContent('active-menu')) ?: null" />

        <div class="fixed inset-0 z-30 hidden bg-[#111827]/35 md:hidden" data-sidebar-overlay></div>

        <main class="app-main min-h-screen transition-[margin] duration-300 ease-out">
            <x-app.navbar
                :breadcrumb="trim($__env->yieldContent('breadcrumb')) ?: 'Início'"
                :title="trim($__env->yieldContent('page-title')) ?: 'Visão geral'" />

            <div class="mx-auto w-full max-w-6xl px-4 py-8 md:px-8 lg:py-10">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>
