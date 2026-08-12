@props([
    'header' => [],
    'data',
    'filters' => [],
    'action' => url()->current(),
    'showActions' => true,
])

@php
    $searchFilter = $filters['search'] ?? null;
    $selectFilters = $filters['selects'] ?? [];
@endphp

<div class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    @if ($searchFilter || count($selectFilters) > 0)
        <div class="border-b border-[#f0e7e8] p-5">
            <form action="{{ $action }}" method="GET" class="flex flex-col gap-3 xl:flex-row xl:items-center">
                @if ($searchFilter)
                    <label class="relative min-w-0 flex-1 xl:min-w-105">
                        <span class="sr-only">{{ $searchFilter['label'] ?? 'Pesquisar' }}</span>
                        <x-lucide-search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                        <input
                            type="search"
                            name="{{ $searchFilter['name'] ?? 'q' }}"
                            value="{{ $searchFilter['value'] ?? '' }}"
                            placeholder="{{ $searchFilter['placeholder'] ?? 'Pesquisar' }}"
                            class="h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm text-[#111827] outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </label>
                @endif

                <div class="grid gap-3 sm:grid-cols-2 xl:flex xl:shrink-0">
                    @foreach ($selectFilters as $filter)
                        <label class="relative block xl:w-56">
                            <span class="sr-only">{{ $filter['label'] ?? 'Filtro' }}</span>
                            <x-lucide-filter class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]" />
                            <select
                                name="{{ $filter['name'] }}"
                                class="h-11 w-full appearance-none rounded-[8px] border border-[#e4d8d9] bg-white pl-10 pr-9 text-sm font-medium text-[#111827] outline-none transition focus:border-[#ef5b97] hover:cursor-pointer focus:outline-none focus:ring-3 focus:ring-[#fdecef]">
                                @foreach (($filter['options'] ?? []) as $option)
                                    <option
                                        value="{{ $option['value'] }}"
                                        class="bg-white px-4 py-2 text-sm font-medium text-[#111827] hover:bg-[#fdecef] hover:text-[#9f4053] checked:bg-[#fdecef] checked:text-[#9f4053]"
                                        @selected(($filter['value'] ?? null) === $option['value'])>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    @endforeach

                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#111827] px-4 text-sm font-semibold text-white transition hover:bg-[#252f3f] hover:cursor-pointer focus:outline-none focus:ring-3 focus:ring-[#fdecef]">
                        Aplicar filtros
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full min-w-195 text-left text-sm">
            <thead class="border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase tracking-wide text-[#667085]">
                <tr>
                    @foreach ($header as $column)
                        <th scope="col" class="px-5 py-4 font-semibold">
                            {{ $column }}
                        </th>
                    @endforeach
                    @if ($showActions)
                        <th scope="col" class="px-5 py-4 text-right font-semibold">
                            Ações
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0e7e8]">
                @forelse ($data as $row)
                    @php
                        $actions = $row['_actions'] ?? [];
                        $displayRow = collect((array) $row)
                            ->reject(fn ($value, $key) => str_starts_with((string) $key, '_'))
                            ->all();
                    @endphp
                    <tr class="transition hover:bg-[#fff7f9]">
                         @foreach ($displayRow as $key => $value)
                            @if ($loop->first)
                                <th scope="row" class="px-5 py-4 font-semibold whitespace-nowrap text-[#111827]">
                                    @if (isset($actions['view']))
                                        <a href="{{ $actions['view'] }}" class="transition hover:text-[#ef5b97]">
                                            {{ $value }}
                                        </a>
                                    @else
                                        {{ $value }}
                                    @endif
                                </th>
                            @elseif ($key === 'status')
                                @php
                                    $statusClass = match ($value) {
                                        'Ativa', 'Realizado', 'Disponível', 'Pago', 'Entrada', 'Normal' => 'bg-[#e8f8ee] text-[#23845a]',
                                        'Agendado', 'Emprestada', 'Distribuído' => 'bg-[#eef4ff] text-[#2f66d0]',
                                        'Manutenção' => 'bg-[#f2f4f7] text-[#667085]',
                                        'Retorno pendente', 'Em atraso', 'Pendente', 'Baixo', 'Saída' => 'bg-[#fff7e6] text-[#b76b00]',
                                        'Cancelado', 'Inativa', 'Crítico' => 'bg-[#fff1f1] text-[#c2414b]',
                                        default => 'bg-[#f2f4f7] text-[#667085]',
                                    };
                                @endphp
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ $value }}
                                    </span>
                                </td>
                            @else
                                <td class="px-5 py-4 text-[#344054]">
                                    {{ $value }}
                                </td>
                            @endif
                        @endforeach
                        @if ($showActions)
                            @php
                                $defaultActions = [
                                    [
                                        'icon' => 'visibility-o',
                                        'route' => $actions['view'] ?? '#',
                                        'title' => 'Visualizar',
                                        'variant' => 'default',
                                    ],
                                    [
                                        'icon' => 'delete-o',
                                        'route' => $actions['delete'] ?? '#',
                                        'title' => 'Excluir',
                                        'variant' => 'danger',
                                    ],
                                ];

                                $tableActions = $actions['items'] ?? $defaultActions;
                            @endphp
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    @foreach ($tableActions as $action)
                                        @php
                                            $actionIcon = 'gmdi-' . ($action['icon'] ?? 'visibility-o');
                                            $actionRoute = $action['route'] ?? '#';
                                            $actionTitle = $action['title'] ?? 'Ação';
                                            $actionClass = ($action['variant'] ?? 'default') === 'danger'
                                                ? 'inline-flex h-9 w-9 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1] hover:text-[#c2414b]'
                                                : 'inline-flex h-9 w-9 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]';
                                        @endphp

                                        <a href="{{ $actionRoute }}" class="{{ $actionClass }}" title="{{ $actionTitle }}">
                                            <x-dynamic-component :component="$actionIcon" class="h-4 w-4" />
                                        </a>
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($header) + ($showActions ? 1 : 0) }}" class="px-5 py-12 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#fdecef] text-[#ef5b97]">
                                    <x-lucide-search class="h-5 w-5" />
                                </div>
                                <p class="mt-3 font-semibold text-[#111827]">Nenhum registro encontrado</p>
                                <p class="mt-1 text-sm text-[#667085]">Ajuste a busca ou altere os filtros selecionados.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
