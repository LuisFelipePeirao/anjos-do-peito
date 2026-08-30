@props(['cancelRoute', 'submitLabel'])

<div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ $cancelRoute }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-5 text-sm font-semibold text-[#344054] transition hover:bg-[#fbf1f3]">
        Cancelar
    </a>
    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
        <x-gmdi-save-o class="h-4 w-4" />
        {{ $submitLabel }}
    </button>
</div>
