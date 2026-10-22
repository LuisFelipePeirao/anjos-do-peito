<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
    'requiredIndicator' => false,
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
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
    'requiredIndicator' => false,
    'wrapperClass' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $showRequiredMarker = $required || $requiredIndicator;
?>

<div
    class="<?php echo \Illuminate\Support\Arr::toCssClasses(['relative block', $wrapperClass]); ?>"
    <?php if($showRequiredMarker): ?> data-select-required <?php endif; ?>
>

    <md-outlined-select
        name="<?php echo e($name); ?>"
        label="<?php echo e($label); ?>"
        aria-label="<?php echo e($attributes->get('aria-label', $label)); ?>"
        <?php if($required): ?> required no-asterisk <?php endif; ?>
        <?php echo e($attributes->class(['w-full'])->except(['aria-label', 'required', 'style'])); ?>

        style="
            height: 44px;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --md-outlined-select-text-field-container-shape: 8px;
            --md-outlined-select-text-field-container-color: #ffffff;
            --md-outlined-select-text-field-outline-color: #e4d8d9;
            --md-outlined-select-text-field-hover-outline-color: #e4d8d9;
            --md-outlined-select-text-field-focus-outline-color: #ef5b97;
            --md-outlined-select-text-field-focus-outline-width: 1px;
            --md-outlined-select-text-field-input-text-color: #111827;
            --md-outlined-select-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-select-text-field-input-text-size: 14px;
            --md-outlined-select-text-field-input-text-line-height: 20px;
            --md-outlined-select-text-field-input-text-weight: 400;
            --md-outlined-select-text-field-label-text-color: #344054;
            --md-outlined-select-text-field-hover-label-text-color: #344054;
            --md-outlined-select-text-field-focus-label-text-color: #ef5b97;
            --md-outlined-select-text-field-label-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-select-text-field-label-text-size: 14px;
            --md-outlined-select-text-field-label-text-line-height: 20px;
            --md-outlined-select-text-field-label-text-populated-size: 12px;
            --md-outlined-select-text-field-label-text-populated-line-height: 16px;
            --md-outlined-select-text-field-label-text-weight: 600;
            --md-outlined-select-text-field-trailing-icon-size: 16px;
            --md-outlined-select-text-field-trailing-icon-color: #111827;
            --md-outlined-select-text-field-hover-trailing-icon-color: #111827;
            --md-outlined-select-text-field-focus-trailing-icon-color: #111827;
            --md-outlined-field-top-space: 12px;
            --md-outlined-field-bottom-space: 12px;
            --md-outlined-field-leading-space: 12px;
            --md-outlined-field-trailing-space: 12px;
        "
    >
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionValue => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $structuredOption = is_array($option);
                $value = $structuredOption
                    ? ($option['value'] ?? $optionValue)
                    : (is_int($optionValue) ? $option : $optionValue);
                $optionLabel = $structuredOption ? ($option['label'] ?? $value) : $option;
                $disabled = $structuredOption && ($option['disabled'] ?? false);
            ?>

            <md-select-option
                value="<?php echo e($value); ?>"
                <?php if((string) $selected === (string) $value): echo 'selected'; endif; ?>
                <?php if($disabled): echo 'disabled'; endif; ?>
            >
                <div
                    slot="headline"
                    class="text-sm font-normal leading-5 text-[#111827]"
                    style="font-family: Instrument Sans, ui-sans-serif, system-ui, sans-serif;"
                >
                    <?php echo e($optionLabel); ?>

                </div>
            </md-select-option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </md-outlined-select>

    <?php if($showRequiredMarker): ?>
        <span
            aria-hidden="true"
            data-select-required-asterisk
            data-required-indicator="<?php echo e($name); ?>"
            class="pointer-events-none absolute z-10 text-sm font-semibold leading-5 text-[#b42336]"
            style="visibility: hidden;"
        >*</span>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/material/select.blade.php ENDPATH**/ ?>