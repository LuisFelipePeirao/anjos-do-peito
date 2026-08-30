@props([
    'title',
    'description',
    'data',
])

<article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
    <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>

    <div class="mt-6 space-y-5">
        @foreach ($data as $activity)
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#f0dadd] bg-white text-[#bf5d6f]">
                        <x-gmdi-timeline-o class="h-4 w-4" />
                    </span>
                    @if (!$loop->last)
                        <span class="mt-2 h-full min-h-8 w-px bg-[#eadfe0]"></span>
                    @endif
                </div>
                <div class="pb-1">
                    <p class="text-xs font-semibold text-[#667085]">{{ $activity['date'] ?? 'Hoje' }} às {{ $activity['time'] }}</p>
                    <p class="mt-1 text-sm font-bold text-[#111827]">{{ $activity['title'] }}</p>
                    <p class="mt-1 text-sm text-[#667085]">{{ $activity['meta'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</article>
