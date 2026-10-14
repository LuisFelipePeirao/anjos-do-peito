<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description',
    'data',
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
    'title',
    'description',
    'data',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $values = $data['values'] ?? [];
    $maxTotal = $values ? max(array_column($values, 'total')) : 0;
    $maxValue = max($maxTotal, 1);
    $columnCount = max(count($values), 1);
    $periodTotal = array_sum(array_column($values, 'total'));

    $heightFor = fn ($value) => round(($value / $maxValue) * 100, 2);
?>

<article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)] self-start">
    <div class="border-b border-[#f0e7e8] pb-5">
        <h3 class="text-lg font-bold text-[#111827]"><?php echo e($title); ?></h3>
        <p class="mt-1 text-sm text-[#667085]"><?php echo e($description); ?></p>
    </div>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-xs text-[#667085]">
        <span class="inline-flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-sm bg-[#a62d5b]"></span>
            Atendimentos realizados
        </span>
        <span><strong class="font-semibold text-[#111827]"><?php echo e($periodTotal); ?></strong> nos últimos <?php echo e(count($values)); ?> meses</span>
    </div>

    <div class="mt-5 grid items-end gap-3" style="grid-template-columns: repeat(<?php echo e($columnCount); ?>, minmax(0, 1fr));">
        <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $totalHeight = $heightFor($month['total']);
            ?>
            <div class="flex h-64 flex-col justify-end gap-3">
                <div class="flex flex-1 items-end justify-center">
                    <div
                        class="w-full max-w-12 rounded-t-md bg-[#a62d5b]"
                        style="height: <?php echo e($totalHeight); ?>%; min-height: <?php echo e($month['total'] > 0 ? '2px' : '0'); ?>;"
                        title="Realizado: <?php echo e($month['total']); ?>">
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-[#111827]"><?php echo e($month['month']); ?></p>
                    <p class="text-[11px] text-[#667085]"><?php echo e($month['total']); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</article>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/chart/column-chart.blade.php ENDPATH**/ ?>