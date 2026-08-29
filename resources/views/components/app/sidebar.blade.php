@props([
    'active' => null,
])

@php
    $currentUser = auth()->user();

    $items = [
        ['label' => 'Início', 'route' => 'home', 'icon' => 'gmdi-dashboard-o'],
        ['label' => 'Beneficiárias', 'route' => 'beneficiaries.index', 'icon' => 'gmdi-people-o'],
        ['label' => 'Bombas de leite', 'route' => 'pumps.index', 'icon' => 'lucide-milk'],
        ['label' => 'Doações e estoque', 'route' => 'donations.index', 'icon' => 'gmdi-inventory-2-o'],
        ['label' => 'Relatórios', 'route' => 'reports.index', 'icon' => 'gmdi-bar-chart-o'],
    ];

    if ($currentUser?->canManageAttendances()) {
        array_splice($items, 2, 0, [['label' => 'Atendimentos', 'route' => 'attendances.index', 'icon' => 'gmdi-content-paste-o']]);
    }

    if (auth()->user()?->isAdministrador()) {
        $items[] = ['label' => 'Usuários', 'route' => 'users.index', 'icon' => 'gmdi-account-circle-o'];
    }

    $initials = collect(explode(' ', trim((string) $currentUser?->nome)))
        ->filter()
        ->take(2)
        ->map(fn (string $part) => mb_substr($part, 0, 1))
        ->join('');
@endphp

<aside
    id="app-sidebar"
    class="app-sidebar fixed inset-y-0 left-0 z-40 flex flex-col border-r border-[#eadfe0] bg-white shadow-[0_20px_60px_rgba(28,25,23,0.08)] transition-[transform,width] duration-300 ease-out md:translate-x-0 md:shadow-none"
    aria-label="Menu principal">
    <div class="flex h-16 items-center gap-3 border-b border-[#eadfe0] px-5">
        <div class="sidebar-logo flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#fdecef] text-[#ef5b97]">
            <img src="{{ asset('assets/img/logo_ong.png') }}" alt="Logo" class="h-10 w-10" />
        </div>

        <div class="sidebar-brand min-w-0 flex-1">
            <strong class="block truncate text-sm font-semibold text-[#111827]">Anjos do Peito</strong>
        </div>

        <button
            type="button"
            class="sidebar-collapse-button hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg text-[#667085] transition hover:bg-[#f7edef] hover:text-[#ef5b97] md:inline-flex hover:cursor-pointer"
            data-sidebar-collapse
            aria-label="Recolher menu"
            aria-expanded="true">
            <x-lucide-panel-left-close class="sidebar-collapse-icon-open h-5 w-5" />
            <x-lucide-panel-left-open class="sidebar-collapse-icon-closed hidden h-5 w-5" />
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
        @foreach ($items as $item)
            @php
                $isActive = $active === $item['route'] || ($item['route'] && request()->routeIs($item['route']));
                $href = route($item['route']);
            @endphp

            <a
                href="{{ $href }}"
                class="sidebar-link {{ $isActive ? 'is-active' : '' }} flex h-10 items-center gap-3 rounded-md px-3 text-sm font-medium text-[#1f2937] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]"
                title="{{ $item['label'] }}">
                <x-dynamic-component :component="$item['icon']" class="h-5 w-5 shrink-0" />
                <span class="sidebar-text truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-[#eadfe0] p-4">
        <div class="sidebar-user mb-3 flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#ef5b97] text-sm font-semibold text-white">
                {{ $initials ?: 'U' }}
            </div>
            <div class="sidebar-text min-w-0">
                <strong class="block truncate text-sm font-semibold text-[#111827]">{{ $currentUser?->nome ?? 'Usuario' }}</strong>
                <span class="block truncate text-xs text-[#667085]">{{ ucfirst($currentUser?->perfil ?? '') }}</span>
            </div>
        </div>

        <button
            type="button"
            data-confirm-dialog-open="logout-confirmation"
            class="sidebar-link flex h-10 w-full items-center gap-3 rounded-md px-3 text-left text-sm font-medium text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]"
            title="Sair">
            <x-gmdi-logout-o class="h-5 w-5 shrink-0" />
            <span class="sidebar-text truncate">Sair</span>
        </button>
    </div>
</aside>
