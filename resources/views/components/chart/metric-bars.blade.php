@props([
    'title',
    'description',
    'data' => [],
])

@php
    $colors = [
        'rose' => 'bg-[#bf5d6f]',
        'blue' => 'bg-[#2677b8]',
        'green' => 'bg-[#23845a]',
        'amber' => 'bg-[#d97706]',
    ];
@endphp

<article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] pb-5">
        <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
        <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>
    </div>

    <div class="mt-5 space-y-5">
        @foreach ($data as $item)
            @php
                $percent = min(max((int) ($item['percent'] ?? 0), 0), 100);
                $barColor = $colors[$item['tone'] ?? 'rose'] ?? $colors['rose'];
            @endphp

            <div>
                <div class="mb-2 flex items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-[#111827]">{{ $item['label'] }}</p>
                        @if (!empty($item['description']))
                            <p class="mt-1 text-xs leading-5 text-[#667085]">{{ $item['description'] }}</p>
                        @endif
                    </div>
                    <span class="shrink-0 text-sm font-bold text-[#111827]">{{ $item['value'] }}</span>
                </div>

                <div class="h-3 overflow-hidden rounded-full bg-[#f2e9ea]">
                    <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $percent }}%"></div>
                </div>

                @if (!empty($item['details']))
                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                        @foreach ($item['details'] as $label => $value)
                            <div class="rounded-[8px] bg-[#fbfaf9] px-3 py-2">
                                <p class="text-[11px] font-semibold uppercase text-[#667085]">{{ $label }}</p>
                                <p class="mt-1 text-sm font-semibold text-[#111827]">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</article>
