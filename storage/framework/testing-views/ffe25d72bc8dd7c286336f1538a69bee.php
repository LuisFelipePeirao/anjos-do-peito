<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description',
    'data',
    'totalStock' => null,
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
    'totalStock' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $items = $data ?? [];
    $availableStock = array_sum(array_column($items, 'available'));
    $usedStock = array_sum(array_column($items, 'used'));
    $stockTotal = $totalStock ?: ($availableStock + $usedStock);
    $availableDeg = $stockTotal > 0 ? round(($availableStock / $stockTotal) * 360) : 0;
?>

<article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] pb-5">
        <h3 class="text-lg font-bold text-[#111827]"><?php echo e($title); ?></h3>
        <p class="mt-1 text-sm text-[#667085]"><?php echo e($description); ?></p>
    </div>

    <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row xl:flex-col">
        <div class="flex flex-col items-center gap-3">
            <div
                class="relative flex h-44 w-44 shrink-0 items-center justify-center rounded-full"
                style="background: conic-gradient(#197a4b 0deg <?php echo e($availableDeg); ?>deg, #a62d5b <?php echo e($availableDeg); ?>deg 360deg);">
                <div class="flex h-28 w-28 flex-col items-center justify-center rounded-full bg-white text-center shadow-inner">
                    <span class="text-2xl font-bold text-[#111827]"><?php echo e($availableStock); ?></span>
                <span class="text-xs text-[#667085]">disponíveis</span>
            </div>
        </div>
            <div class="flex flex-wrap justify-center gap-x-3 gap-y-1 text-xs text-[#667085]">
                <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#197a4b]"></span>Disponível</span>
                <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#a62d5b]"></span>Em uso</span>
            </div>
        </div>

        <div class="w-full space-y-4">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $total = $item['available'] + $item['used'];
                    $availablePercent = $total > 0 ? round(($item['available'] / $total) * 100) : 0;
                    $isLow = $item['available'] < $item['minimum'];
                    $isEmpty = $item['available'] === 0;
                    $status = $isEmpty
                        ? ['label' => 'Sem estoque', 'badge' => 'bg-[#fdecec] text-[#b42336]', 'bar' => 'bg-[#b42336]']
                        : ($isLow
                            ? ['label' => 'Baixo estoque', 'badge' => 'bg-[#fff3d6] text-[#8a4b00]', 'bar' => 'bg-[#d97706]']
                            : ['label' => 'Estoque adequado', 'badge' => 'bg-[#e8f8ee] text-[#197a4b]', 'bar' => 'bg-[#197a4b]']);
                ?>

                <div>
                    <div class="mb-1.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-semibold text-[#111827]"><?php echo e($item['label']); ?></span>
                                <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold <?php echo e($status['badge']); ?>"><?php echo e($status['label']); ?></span>
                            </div>
                            <p class="mt-0.5 text-[11px] text-[#667085]">Mínimo: <?php echo e($item['minimum']); ?></p>
                        </div>
                        <span class="shrink-0 text-xs <?php echo e($isEmpty ? 'font-semibold text-[#b42336]' : 'text-[#667085]'); ?>">
                            <?php echo e($item['available']); ?> disp. / <?php echo e($item['used']); ?> uso
                        </span>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-[#f1e7e8]">
                        <div
                            class="h-full rounded-full <?php echo e($status['bar']); ?>"
                            style="width: <?php echo e($availablePercent); ?>%">
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</article>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/chart/stock-distribution.blade.php ENDPATH**/ ?>