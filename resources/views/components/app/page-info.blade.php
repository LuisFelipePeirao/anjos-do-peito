@props([
    'title',
    'description',
    'subheading' => 'Painel executivo',
    'firstButton',
    'secondButton' => null,
    'confirmation' => null,
    'confirmationId' => null,
])

@php
    if (isset($firstButton['icon'])) {
        $firstButton['icon'] = 'gmdi-' . $firstButton['icon'];
    }

    if (isset($secondButton['icon'])) {
        $secondButton['icon'] = 'gmdi-' . $secondButton['icon'];
    }

    $confirmationMethod = strtoupper($confirmation['method'] ?? 'GET');
    $confirmationAction = $confirmation['action']
        ?? ($confirmationMethod !== 'GET' ? ($confirmation['href'] ?? $firstButton['link']) : null);
    $confirmationHref = $confirmation['href']
        ?? ($confirmationAction ? null : $firstButton['link']);
@endphp

<div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
    <div>
        <p class="text-sm font-medium text-[#ef5b97]">{{ $subheading }}</p>
        <h2 class="mt-1 text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">{{ $title }}</h2>
        <p class="mt-2 max-w-2xl text-sm text-[#667085]">
            {{ $description }}
        </p>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row">
        <a href="{{ $firstButton['link'] }}"
            @if ($confirmation && $confirmationId) data-confirm-dialog-open="{{ $confirmationId }}" @endif
            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
            <x-dynamic-component :component="$firstButton['icon']" class="h-4 w-4" />
            {{ $firstButton['label'] }}
        </a>

        @if ($secondButton)
            <a href="{{ $secondButton['link'] }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                <x-dynamic-component :component="$secondButton['icon']" class="h-5 w-5" />
                {{ $secondButton['label'] }}
            </a>

        @endif

        @if ($confirmation && $confirmationId)
            <x-app.confirm-modal
                :id="$confirmationId"
                :title="$confirmation['title'] ?? 'Sair sem salvar?'"
                :message="$confirmation['message'] ?? 'As informações não salvas serão perdidas.'"
                :confirm-label="$confirmation['confirmLabel'] ?? 'Sair sem salvar'"
                :cancel-label="$confirmation['cancelLabel'] ?? 'Continuar editando'"
                :variant="$confirmation['variant'] ?? 'warning'"
                :icon="$confirmation['icon'] ?? null"
                :action="$confirmationAction"
                :method="$confirmationMethod"
                :href="$confirmationHref"
            />
        @endif
    </div>
</div>
