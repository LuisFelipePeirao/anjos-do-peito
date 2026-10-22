<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'breadcrumb' => 'Início',
    'title' => 'Visão geral',
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
    'breadcrumb' => 'Início',
    'title' => 'Visão geral',
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
    $initials = collect(explode(' ', trim((string) $currentUser?->nome)))
        ->filter()
        ->take(2)
        ->map(fn (string $part) => mb_substr($part, 0, 1))
        ->join('');
?>

<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-[#eadfe0] bg-white/95 px-4 backdrop-blur md:px-6">
    <div class="flex min-w-0 items-center gap-3">
        <button
            type="button"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-[#667085] transition hover:bg-[#f7edef] hover:text-[#a62d5b] md:hidden"
            data-sidebar-mobile-toggle
            aria-label="Abrir menu"
            aria-expanded="false">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
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

        <div class="min-w-0">
            <span class="block truncate text-xs text-[#4b5563]"><?php echo e($breadcrumb); ?></span>
            <h1 class="truncate text-base font-semibold text-[#1f2937]"><?php echo e($title); ?></h1>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden text-right sm:block">
            <strong class="block text-sm font-semibold text-[#1f2937]"><?php echo e($currentUser?->nome ?? 'Usuário'); ?></strong>
            <span class="block text-xs text-[#667085]"><?php echo e(ucfirst($currentUser?->perfil ?? '')); ?></span>
        </div>

        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#c73570] text-sm font-semibold text-white">
            <?php echo e($initials ?: 'U'); ?>

        </div>
    </div>
</header>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/app/navbar.blade.php ENDPATH**/ ?>