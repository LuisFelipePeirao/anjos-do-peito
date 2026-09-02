@props([
    'breadcrumb' => 'Início',
    'title' => 'Visão geral',
])

@php
    $currentUser = auth()->user();
    $initials = collect(explode(' ', trim((string) $currentUser?->nome)))
        ->filter()
        ->take(2)
        ->map(fn (string $part) => mb_substr($part, 0, 1))
        ->join('');
@endphp

<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-[#eadfe0] bg-white/95 px-4 backdrop-blur md:px-6">
    <div class="flex min-w-0 items-center gap-3">
        <button
            type="button"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-[#667085] transition hover:bg-[#f7edef] hover:text-[#bf5d6f] md:hidden"
            data-sidebar-mobile-toggle
            aria-label="Abrir menu"
            aria-expanded="false">
            <x-lucide-menu class="h-5 w-5" />
        </button>

        <div class="min-w-0">
            <span class="block truncate text-xs text-[#4b5563]">{{ $breadcrumb }}</span>
            <h1 class="truncate text-base font-semibold text-[#1f2937]">{{ $title }}</h1>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden text-right sm:block">
            <strong class="block text-sm font-semibold text-[#1f2937]">{{ $currentUser?->nome ?? 'Usuário' }}</strong>
            <span class="block text-xs text-[#667085]">{{ ucfirst($currentUser?->perfil ?? '') }}</span>
        </div>

        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#ef5b97] text-sm font-semibold text-white">
            {{ $initials ?: 'U' }}
        </div>
    </div>
</header>
