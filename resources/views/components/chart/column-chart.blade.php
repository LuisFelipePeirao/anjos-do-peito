@props([
    'title',
    'description',
    'data',
])

@php
    $values = $data['values'] ?? [];
    $maxTotal = $values ? max(array_column($values, 'total')) : 0;
    $maxValue = max($maxTotal, 1);
    $columnCount = max(count($values), 1);
    $periodTotal = array_sum(array_column($values, 'total'));

    $heightFor = fn ($value) => round(($value / $maxValue) * 100, 2);
@endphp

<article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)] self-start">
    <div class="border-b border-[#f0e7e8] pb-5">
        <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
        <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>
    </div>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-xs text-[#667085]">
        <span class="inline-flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-sm bg-[#bf5d6f]"></span>
            Atendimentos realizados
        </span>
        <span><strong class="font-semibold text-[#111827]">{{ $periodTotal }}</strong> nos últimos {{ count($values) }} meses</span>
    </div>

    <div class="mt-5 grid items-end gap-3" style="grid-template-columns: repeat({{ $columnCount }}, minmax(0, 1fr));">
        @foreach ($values as $month)
            @php
                $totalHeight = $heightFor($month['total']);
            @endphp
            <div class="flex h-64 flex-col justify-end gap-3">
                <div class="flex flex-1 items-end justify-center">
                    <div
                        class="w-full max-w-12 rounded-t-md bg-[#bf5d6f]"
                        style="height: {{ $totalHeight }}%; min-height: {{ $month['total'] > 0 ? '2px' : '0' }};"
                        title="Realizado: {{ $month['total'] }}">
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-[#111827]">{{ $month['month'] }}</p>
                    <p class="text-[11px] text-[#667085]">{{ $month['total'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</article>
