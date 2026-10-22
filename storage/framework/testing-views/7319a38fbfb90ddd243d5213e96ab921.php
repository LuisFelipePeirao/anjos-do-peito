<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'active' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'active' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $currentUser = auth()->user();

    $items = [
        ['label' => 'Início', 'route' => 'home', 'icon' => 'gmdi-dashboard-o'],
        ['label' => 'Beneficiárias', 'route' => 'beneficiaries.index', 'icon' => 'gmdi-people-o'],
        ['label' => 'Bombas de leite', 'route' => 'pumps.index', 'icon' => 'lucide-milk'],
        ['label' => 'Itens de estoque', 'route' => 'donations.index', 'icon' => 'gmdi-inventory-2-o'],
        ['label' => 'Movimentações', 'route' => 'movements.index', 'icon' => 'gmdi-swap-horiz-o'],
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
?>

<aside
    id="app-sidebar"
    class="app-sidebar fixed inset-y-0 left-0 z-40 flex flex-col border-r border-[#eadfe0] bg-white shadow-[0_20px_60px_rgba(28,25,23,0.08)] transition-[transform,width] duration-300 ease-out md:translate-x-0 md:shadow-none"
    aria-label="Menu principal">
    <div class="flex h-16 items-center gap-3 border-b border-[#eadfe0] px-5">
        <div class="sidebar-logo flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#fdecef] text-[#a62d5b]">
            <img src="<?php echo e(asset('assets/img/logo.png')); ?>" alt="Logo" class="h-10 w-10" />
        </div>

        <div class="sidebar-brand min-w-0 flex-1">
            <strong class="block truncate text-sm font-semibold text-[#111827]">VITA</strong>
        </div>

        <button
            type="button"
            class="sidebar-collapse-button hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg text-[#667085] transition hover:bg-[#f7edef] hover:text-[#a62d5b] md:inline-flex hover:cursor-pointer"
            data-sidebar-collapse
            aria-label="Recolher menu"
            aria-expanded="true">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-panel-left-close'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sidebar-collapse-icon-open h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-panel-left-open'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sidebar-collapse-icon-closed hidden h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isActive = $active === $item['route'] || ($item['route'] && request()->routeIs($item['route']));
                $href = route($item['route']);
            ?>

            <a
                href="<?php echo e($href); ?>"
                class="sidebar-link <?php echo e($isActive ? 'is-active' : ''); ?> flex h-10 items-center gap-3 rounded-md px-3 text-sm font-medium text-[#1f2937] transition hover:bg-[#fbf1f3] hover:text-[#a62d5b]"
                title="<?php echo e($item['label']); ?>">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $item['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5 shrink-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
                <span class="sidebar-text truncate"><?php echo e($item['label']); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <div class="border-t border-[#eadfe0] p-4">
        <div class="sidebar-user mb-3 flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#c73570] text-sm font-semibold text-white">
                <?php echo e($initials ?: 'U'); ?>

            </div>
            <div class="sidebar-text min-w-0">
                <strong class="block truncate text-sm font-semibold text-[#111827]"><?php echo e($currentUser?->nome ?? 'Usuario'); ?></strong>
                <span class="block truncate text-xs text-[#667085]"><?php echo e(ucfirst($currentUser?->perfil ?? '')); ?></span>
            </div>
        </div>

        <button
            type="button"
            data-confirm-dialog-open="logout-confirmation"
            class="sidebar-link flex h-10 w-full items-center gap-3 rounded-md px-3 text-left text-sm font-medium text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#a62d5b]"
            title="Sair">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-logout-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5 shrink-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            <span class="sidebar-text truncate">Sair</span>
        </button>
    </div>
</aside>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/app/sidebar.blade.php ENDPATH**/ ?>