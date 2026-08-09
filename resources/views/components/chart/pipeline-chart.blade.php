@props([
    'title',
    'description',
    'data',
])

<article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
    <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>

    <div class="mt-6 space-y-5">
        @foreach ($data as $step)
            @php
                $percent = min(max($step['percent'], 0), 100);
            @endphp

            <div>
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm font-semibold text-[#111827]">{{ $step['label'] }}</span>
                    <span class="text-sm font-bold text-[#bf5d6f]">{{ $step['value'] }}</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-[#f2e9ea]">
                    <div class="h-full rounded-full bg-[#bf5d6f]" style="width: {{ $percent }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</article>
