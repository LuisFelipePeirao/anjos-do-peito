@props([
    'title',
    'description',
    'data',
    'subtitleOne',
    'subtitleTwo',
])

@php
    $values = $data['values'] ?? [];
    $maxTotal = $values ? max(array_column($values, 'total')) : 0;
    $maxTarget = $values ? max(array_column($values, 'target')) : 0;
    $maxValue = max($maxTotal, $maxTarget, 1);
    $columnCount = max(count($values), 1);

    $heightFor = fn ($value) => round(($value / $maxValue) * 100, 2);
@endphp

<article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="flex flex-col gap-3 border-b border-[#f0e7e8] pb-5 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
            <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>
        </div>
        <span
            class="inline-flex w-fit items-center gap-2 rounded-full bg-[#f7edef] px-3 py-1 text-xs font-semibold text-[#9f4053]">
            <x-lucide-trending-up class="h-3.5 w-3.5" />
            {{ $data['percent'] ?? '0%' }} da meta de agosto
        </span>
    </div>

    <div class="mt-6 grid min-h-70 items-end gap-3" style="grid-template-columns: repeat({{ $columnCount }}, minmax(0, 1fr));">
        @foreach ($values as $month)
            @php
                $totalHeight = $heightFor($month['total']);
                $targetHeight = $heightFor($month['target']);
            @endphp
            <div class="flex h-64 flex-col justify-end gap-3">
                <div class="flex flex-1 items-end justify-center gap-1.5">
                    <div
                        class="w-full max-w-7 rounded-t-[6px] bg-[#bf5d6f]"
                        style="height: {{ $totalHeight }}%; min-height: {{ $month['total'] > 0 ? '2px' : '0' }};"
                        title="Realizado: {{ $month['total'] }}">
                    </div>
                    <div
                        class="w-full max-w-7 rounded-t-[6px] bg-[#f2d6dc]"
                        style="height: {{ $targetHeight }}%; min-height: {{ $month['target'] > 0 ? '2px' : '0' }};"
                        title="Meta: {{ $month['target'] }}">
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-[#111827]">{{ $month['month'] }}</p>
                    <p class="text-[11px] text-[#667085]">{{ $month['total'] }}/{{ $month['target'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-5 flex flex-wrap gap-4 border-t border-[#f0e7e8] pt-4 text-xs text-[#667085]">
        <span class="inline-flex items-center gap-2"><span
                class="h-2.5 w-2.5 rounded-full bg-[#bf5d6f]"></span>{{ $subtitleOne }}</span>
        <span class="inline-flex items-center gap-2"><span
                class="h-2.5 w-2.5 rounded-full bg-[#f2d6dc]"></span>{{ $subtitleTwo }}</span>
    </div>
</article>
