@props(['title', 'description', 'icon' => 'gmdi-inventory-2-o'])

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                <x-dynamic-component :component="$icon" class="h-5 w-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#111827]">{{ $title }}</h3>
                <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 p-5 md:grid-cols-2">
        {{ $slot }}
    </div>
</article>
