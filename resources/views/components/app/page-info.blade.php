@props([
    'title',
    'description',
    'subheading' => 'Painel executivo',
    'firstButton',
    'secondButton' => null,
])

@php
    if (isset($firstButton['icon'])) {
        $firstButton['icon'] = 'lucide-' . $firstButton['icon'];
    }

    if (isset($secondButton['icon'])) {
        $secondButton['icon'] = 'lucide-' . $secondButton['icon'];
    }
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
            class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
            <x-dynamic-component :component="$firstButton['icon']" class="h-4 w-4" />
            {{ $firstButton['label'] }}
        </a>

        @if ($secondButton)
            <a href="{{ $secondButton['link'] }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                <x-dynamic-component :component="$secondButton['icon']" class="h-5 w-5" />
                {{ $secondButton['label'] }}
            </a>
        @endif
    </div>
</div>
