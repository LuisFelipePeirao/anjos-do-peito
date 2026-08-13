@props([
    'id',
    'title' => 'Confirmar ação',
    'message' => 'Deseja realmente continuar?',
    'confirmLabel' => 'Confirmar',
    'cancelLabel' => 'Cancelar',
    'variant' => 'danger',
    'icon' => null,
    'action' => null,
    'method' => 'POST',
    'href' => null,
])

@php
    $variantConfig = match ($variant) {
        'warning' => [
            'icon' => 'gmdi-warning-amber-o',
            'iconClass' => 'bg-[#fff7e6] text-[#b76b00]',
            'buttonClass' => 'bg-[#b76b00] hover:bg-[#965800] focus:ring-[#fff0cc]',
        ],
        'default' => [
            'icon' => 'gmdi-help-outline-o',
            'iconClass' => 'bg-[#eef4ff] text-[#2f66d0]',
            'buttonClass' => 'bg-[#111827] hover:bg-[#252f3f] focus:ring-[#e5e7eb]',
        ],
        default => [
            'icon' => 'gmdi-warning-o',
            'iconClass' => 'bg-[#fff1f1] text-[#c2414b]',
            'buttonClass' => 'bg-[#c2414b] hover:bg-[#a93640] focus:ring-[#ffe0e0]',
        ],
    };

    $modalIcon = $icon ?: $variantConfig['icon'];
    $normalizedMethod = strtoupper($method);
@endphp

<dialog
    id="{{ $id }}"
    aria-labelledby="{{ $id }}-title"
    aria-describedby="{{ $id }}-message"
    data-confirm-dialog-modal
    class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45 backdrop:backdrop-blur-[2px]"
>
    <div class="p-5 sm:p-6">
        <div class="flex items-start gap-4">
            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full {{ $variantConfig['iconClass'] }}">
                <x-dynamic-component :component="$modalIcon" class="h-5 w-5" />
            </span>

            <div class="min-w-0 flex-1 pt-0.5">
                <h2 id="{{ $id }}-title" class="text-base font-semibold text-[#111827]">
                    {{ $title }}
                </h2>
                <p id="{{ $id }}-message" class="mt-1.5 text-sm leading-6 text-[#667085]">
                    {{ $message }}
                </p>
            </div>

            <button
                type="button"
                data-confirm-dialog-close
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#98a2b3] transition hover:cursor-pointer hover:bg-[#f7edef] hover:text-[#667085] focus:outline-none focus:ring-3 focus:ring-[#fdecef]"
                aria-label="Fechar"
            >
                <x-gmdi-close-o class="h-5 w-5" />
            </button>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button
                type="button"
                data-confirm-dialog-close
                class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:cursor-pointer hover:bg-[#fbfaf9] focus:outline-none focus:ring-3 focus:ring-[#fdecef]"
            >
                {{ $cancelLabel }}
            </button>

            @if ($action)
                <form action="{{ $action }}" method="{{ $normalizedMethod === 'GET' ? 'GET' : 'POST' }}">
                    @if ($normalizedMethod !== 'GET')
                        @csrf
                    @endif
                    @if (!in_array($normalizedMethod, ['GET', 'POST']))
                        @method($normalizedMethod)
                    @endif

                    <button
                        type="submit"
                        class="inline-flex h-10 w-full items-center justify-center rounded-lg px-4 text-sm font-semibold text-white transition hover:cursor-pointer focus:outline-none focus:ring-3 {{ $variantConfig['buttonClass'] }}"
                    >
                        {{ $confirmLabel }}
                    </button>
                </form>
            @elseif ($href)
                <a
                    href="{{ $href }}"
                    class="inline-flex h-10 items-center justify-center rounded-lg px-4 text-sm font-semibold text-white transition hover:cursor-pointer focus:outline-none focus:ring-3 {{ $variantConfig['buttonClass'] }}"
                >
                    {{ $confirmLabel }}
                </a>
            @else
                <button
                    type="button"
                    data-confirm-dialog-confirm
                    class="inline-flex h-10 items-center justify-center rounded-lg px-4 text-sm font-semibold text-white transition hover:cursor-pointer focus:outline-none focus:ring-3 {{ $variantConfig['buttonClass'] }}"
                >
                    {{ $confirmLabel }}
                </button>
            @endif
        </div>
    </div>
</dialog>
