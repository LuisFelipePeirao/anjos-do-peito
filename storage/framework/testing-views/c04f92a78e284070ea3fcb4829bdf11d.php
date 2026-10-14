<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'text',
    'label',
    'name' => null,
    'value' => null,
    'wrapperClass' => '',
    'passwordToggle' => false,
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
    'type' => 'text',
    'label',
    'name' => null,
    'value' => null,
    'wrapperClass' => '',
    'passwordToggle' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['mb-8', $wrapperClass]); ?>">
    <md-filled-text-field
        type="<?php echo e($type); ?>"
        label="<?php echo e($label); ?>"
        aria-label="<?php echo e($attributes->get('aria-label', $label)); ?>"
        <?php if($name): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        <?php if(! is_null($value)): ?> value="<?php echo e($value); ?>" <?php endif; ?>
        <?php echo e($attributes->class(['block w-full'])->except(['aria-label', 'style'])); ?>

        style="
            height: 56px;
            --md-filled-text-field-container-color: transparent;
            --md-filled-text-field-container-shape: 0px;
            --md-filled-text-field-hover-state-layer-color: transparent;
            --md-filled-text-field-hover-state-layer-opacity: 0;
            --md-filled-text-field-active-indicator-color: #8590ad;
            --md-filled-text-field-hover-active-indicator-color: #8590ad;
            --md-filled-text-field-focus-active-indicator-color: #ef5b97;
            --md-filled-text-field-active-indicator-height: 1px;
            --md-filled-text-field-hover-active-indicator-height: 1px;
            --md-filled-text-field-focus-active-indicator-height: 1px;
            --md-filled-text-field-input-text-color: #ef5b97;
            --md-filled-text-field-hover-input-text-color: #ef5b97;
            --md-filled-text-field-focus-input-text-color: #ef5b97;
            --md-filled-text-field-caret-color: #ef5b97;
            --md-filled-text-field-focus-caret-color: #ef5b97;
            --md-filled-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-filled-text-field-input-text-size: 19.2px;
            --md-filled-text-field-input-text-line-height: 24px;
            --md-filled-text-field-input-text-weight: 400;
            --md-filled-text-field-label-text-color: #8590ad;
            --md-filled-text-field-hover-label-text-color: #8590ad;
            --md-filled-text-field-focus-label-text-color: #ef5b97;
            --md-filled-text-field-label-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-filled-text-field-label-text-size: 16px;
            --md-filled-text-field-label-text-line-height: 24px;
            --md-filled-text-field-label-text-populated-size: 14px;
            --md-filled-text-field-label-text-populated-line-height: 20px;
            --md-filled-text-field-label-text-weight: 400;
            --md-filled-text-field-leading-icon-color: #8590ad;
            --md-filled-text-field-hover-leading-icon-color: #8590ad;
            --md-filled-text-field-focus-leading-icon-color: #ef5b97;
            --md-filled-text-field-leading-icon-size: 24px;
            --md-filled-text-field-with-leading-icon-leading-space: 0px;
            --md-filled-text-field-icon-input-space: 14px;
            --md-filled-text-field-trailing-space: 0px;
        "
    >
        <?php if(isset($icon)): ?>
            <span slot="leading-icon" class="flex h-6 w-6 items-center justify-center text-2xl">
                <?php echo e($icon); ?>

            </span>
        <?php endif; ?>

        <?php if($passwordToggle): ?>
            <button
                type="button"
                slot="trailing-icon"
                data-password-toggle="<?php echo e($name); ?>"
                class="flex h-10 w-10 cursor-pointer items-center justify-center rounded-[4px] text-[#8590ad] transition hover:text-[#ef5b97] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ef5b97]/30"
                aria-label="Mostrar senha"
                aria-pressed="false"
            >
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-eye'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5','data-password-visible-icon' => true]); ?>
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
<?php $component->withName('lucide-eye-off'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'hidden h-5 w-5','data-password-hidden-icon' => true]); ?>
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
        <?php endif; ?>
    </md-filled-text-field>
</div>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/material/input.blade.php ENDPATH**/ ?>