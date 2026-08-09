@props([
    'title',
    'description',
    'data',
])

@php
    $toneClasses = [
        'red' => 'bg-[#fdecec] text-[#c2414b]',
        'amber' => 'bg-[#fff3d6] text-[#b77910]',
        'blue' => 'bg-[#e8f4ff] text-[#2677b8]',
    ];
@endphp

<article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
    <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>

    <div class="mt-5 space-y-3">
        @foreach ($data as $risk)
            <div class="rounded-[8px] border border-[#f0e7e8] p-4">
                <div class="flex gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[8px] {{ $toneClasses[$risk['tone']] ?? $toneClasses['blue'] }}">
                        <x-lucide-triangle-alert class="h-4 w-4" />
                    </span>
                    <div>
                        <p class="text-sm font-bold text-[#111827]">{{ $risk['title'] }}</p>
                        <p class="mt-1 text-sm text-[#667085]">{{ $risk['description'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</article>
