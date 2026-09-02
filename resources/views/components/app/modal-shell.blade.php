@props([
    'dialogId',
    'title',
    'description',
    'maxWidth' => 'max-w-3xl',
    'entityLabel' => null,
])

<dialog id="{{ $dialogId }}" data-dialog-modal @if ($entityLabel) data-entity-label="{{ $entityLabel }}" @endif class="m-auto w-[calc(100%-2rem)] {{ $maxWidth }} rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45">
    <div class="p-5 sm:p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-[#111827]">{{ $title }}</h2>
                <p class="mt-1 text-sm text-[#667085]">{{ $description }}</p>
            </div>
            <button type="button" data-dialog-close class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#667085] hover:bg-[#f7edef]" aria-label="Fechar">
                <x-gmdi-close-o class="h-5 w-5" />
            </button>
        </div>

        {{ $slot }}
    </div>
</dialog>
