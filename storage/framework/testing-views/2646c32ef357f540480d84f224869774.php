<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'q',
    'label' => 'Pesquisar',
    'value' => '',
    'placeholder' => 'Pesquisar',
    'wrapperClass' => '',
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
    'name' => 'q',
    'label' => 'Pesquisar',
    'value' => '',
    'placeholder' => 'Pesquisar',
    'wrapperClass' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<label class="<?php echo \Illuminate\Support\Arr::toCssClasses(['min-w-0', $wrapperClass]); ?>">
    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]"><?php echo e($label); ?></span>

    <md-outlined-text-field
        type="search"
        name="<?php echo e($name); ?>"
        value="<?php echo e($value); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        aria-label="<?php echo e($attributes->get('aria-label', $label)); ?>"
        <?php echo e($attributes->class([
            'block w-full rounded-lg transition',
            'focus-within:ring-3 focus-within:ring-[#fdecef]',
        ])->except(['aria-label', 'style'])); ?>

        style="
            height: 44px;
            background-color: #ffffff;
            --md-outlined-text-field-container-shape: 8px;
            --md-outlined-text-field-outline-color: #e4d8d9;
            --md-outlined-text-field-outline-width: 1px;
            --md-outlined-text-field-hover-outline-color: #e4d8d9;
            --md-outlined-text-field-hover-outline-width: 1px;
            --md-outlined-text-field-focus-outline-color: #ef5b97;
            --md-outlined-text-field-focus-outline-width: 1px;
            --md-outlined-text-field-input-text-color: #111827;
            --md-outlined-text-field-hover-input-text-color: #111827;
            --md-outlined-text-field-focus-input-text-color: #111827;
            --md-outlined-text-field-caret-color: #ef5b97;
            --md-outlined-text-field-focus-caret-color: #ef5b97;
            --md-outlined-text-field-input-text-placeholder-color: #98a2b3;
            --md-outlined-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-text-field-input-text-size: 14px;
            --md-outlined-text-field-input-text-line-height: 20px;
            --md-outlined-text-field-input-text-weight: 400;
            --md-outlined-text-field-leading-icon-color: #98a2b3;
            --md-outlined-text-field-hover-leading-icon-color: #98a2b3;
            --md-outlined-text-field-focus-leading-icon-color: #98a2b3;
            --md-outlined-text-field-leading-icon-size: 16px;
            --md-outlined-text-field-with-leading-icon-leading-space: 12px;
            --md-outlined-text-field-icon-input-space: 12px;
            --md-outlined-text-field-trailing-space: 12px;
            --md-outlined-text-field-top-space: 12px;
            --md-outlined-text-field-bottom-space: 12px;
        "
    >
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-search-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['slot' => 'leading-icon','class' => 'h-4 w-4']); ?>
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
    </md-outlined-text-field>
</label>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/material/search-input.blade.php ENDPATH**/ ?>