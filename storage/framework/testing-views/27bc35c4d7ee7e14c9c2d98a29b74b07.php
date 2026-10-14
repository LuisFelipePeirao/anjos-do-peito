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

<article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <h3 class="text-lg font-bold text-[#111827]"><?php echo e($title); ?></h3>
    <p class="mt-1 text-sm text-[#667085]"><?php echo e($description); ?></p>

    <div class="mt-6 space-y-5">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $percent = min(max($step['percent'], 0), 100);
            ?>

            <div>
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm font-semibold text-[#111827]"><?php echo e($step['label']); ?></span>
                    <span class="text-sm font-bold text-[#a62d5b]"><?php echo e($step['value']); ?></span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-[#f2e9ea]">
                    <div class="h-full rounded-full bg-[#a62d5b]" style="width: <?php echo e($percent); ?>%"></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</article>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/chart/pipeline-chart.blade.php ENDPATH**/ ?>