<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description',
    'data' => [],
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
    'data' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colors = [
        'rose' => 'bg-[#a62d5b]',
        'blue' => 'bg-[#2677b8]',
        'green' => 'bg-[#23845a]',
        'amber' => 'bg-[#d97706]',
    ];
?>

<article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] pb-5">
        <h3 class="text-lg font-bold text-[#111827]"><?php echo e($title); ?></h3>
        <p class="mt-1 text-sm text-[#667085]"><?php echo e($description); ?></p>
    </div>

    <div class="mt-5 space-y-5">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $percent = min(max((int) ($item['percent'] ?? 0), 0), 100);
                $barColor = $colors[$item['tone'] ?? 'rose'] ?? $colors['rose'];
            ?>

            <div>
                <div class="mb-2 flex items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-[#111827]"><?php echo e($item['label']); ?></p>
                        <?php if(!empty($item['description'])): ?>
                            <p class="mt-1 text-xs leading-5 text-[#667085]"><?php echo e($item['description']); ?></p>
                        <?php endif; ?>
                    </div>
                    <span class="shrink-0 text-sm font-bold text-[#111827]"><?php echo e($item['value']); ?></span>
                </div>

                <div class="h-3 overflow-hidden rounded-full bg-[#f2e9ea]">
                    <div class="h-full rounded-full <?php echo e($barColor); ?>" style="width: <?php echo e($percent); ?>%"></div>
                </div>

                <?php if(!empty($item['details'])): ?>
                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                        <?php $__currentLoopData = $item['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="rounded-[8px] bg-[#fbfaf9] px-3 py-2">
                                <p class="text-[11px] font-semibold uppercase text-[#667085]"><?php echo e($label); ?></p>
                                <p class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($value); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</article>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/chart/metric-bars.blade.php ENDPATH**/ ?>