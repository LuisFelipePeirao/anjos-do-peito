@props([
    'title',
    'description',
    'data',
    'totalStock' => null,
])

@php
    $items = $data ?? [];
    $availableStock = array_sum(array_column($items, 'available'));
    $usedStock = array_sum(array_column($items, 'used'));
    $stockTotal = $totalStock ?: ($availableStock + $usedStock);
    $availableDeg = $stockTotal > 0 ? round(($availableStock / $stockTotal) * 360) : 0;
@endphp

<article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] pb-5">
        <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
        <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>
    </div>

    <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row xl:flex-col">
        <div
            class="relative flex h-44 w-44 shrink-0 items-center justify-center rounded-full"
            style="background: conic-gradient(#23845a 0deg {{ $availableDeg }}deg, #bf5d6f {{ $availableDeg }}deg 360deg);">
            <div class="flex h-28 w-28 flex-col items-center justify-center rounded-full bg-white text-center shadow-inner">
                <span class="text-2xl font-bold text-[#111827]">{{ $availableStock }}</span>
                <span class="text-xs text-[#667085]">disponíveis</span>
            </div>
        </div>

        <div class="w-full space-y-4">
            @foreach ($items as $item)
                @php
                    $total = $item['available'] + $item['used'];
                    $availablePercent = $total > 0 ? round(($item['available'] / $total) * 100) : 0;
                    $isLow = $item['available'] < $item['minimum'];
                @endphp

                <div>
                    <div class="mb-1.5 flex items-center justify-between gap-3">
                        <span class="text-sm font-semibold text-[#111827]">{{ $item['label'] }}</span>
                        <span class="text-xs {{ $isLow ? 'font-semibold text-[#c2414b]' : 'text-[#667085]' }}">
                            {{ $item['available'] }} disp. / {{ $item['used'] }} uso
                        </span>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-[#f1e7e8]">
                        <div
                            class="h-full rounded-full {{ $isLow ? 'bg-[#d97706]' : 'bg-[#23845a]' }}"
                            style="width: {{ $availablePercent }}%">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</article>
