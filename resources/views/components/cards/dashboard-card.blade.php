@props([
    'label',
    'value',
    'tone' => 'rose',
    'context' => '',
    'icon',
    'arrow' => '',
    'percent' => null,
])

@php
    $colors = [
        'rose' => 'bg-[#fdecef] text-[#bf5d6f] hover:bg-[#fbcad1]',
        'blue' => 'bg-[#e8f4ff] text-[#2677b8] hover:bg-[#cce5ff]',
        'green' => 'bg-[#e8f8ee] text-[#23845a] hover:bg-[#d1f3dc]',
        'amber' => 'bg-[#fff3d6] text-[#b77910] hover:bg-[#ffe3a8]',
    ];
    $arrowColors = [
        'up' => 'bg-[#e8f8ee] text-[#23845a]',
        'down' => 'bg-[#fdecec] text-[#c2414b]',
    ];

    $lucideIcon = 'lucide-' . $icon;
@endphp

<article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-[#667085]"> {{ $label  }}</p>
            <p class="mt-4 text-3xl font-bold text-[#111827]">{{ $value }}</p>
        </div>
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] {{ $colors[$tone] ?? $colors['rose'] }}">
            <x-dynamic-component :component="$lucideIcon" class="h-5 w-5" />
        </span>
    </div>

    @if ( !empty($context) && !empty($percent) )
    <div class="mt-5 flex items-center justify-between gap-3">
        @if ($context)
            <p class="truncate text-xs text-[#667085]">{{ $context }}</p>
        @endif
        @if ($percent)
            <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $arrowColors[$arrow] ?? $arrowColors['down'] }}">
                @if ($arrow === 'up')
                    <x-lucide-arrow-up-right class="h-3.5 w-3.5" />
                @else
                    <x-lucide-arrow-down-right class="h-3.5 w-3.5" />
                @endif
                {{ $percent }}
            </span>
        @endif
    </div>
    @endif
</article>
