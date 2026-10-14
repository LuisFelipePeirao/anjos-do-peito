<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'icon' => null,
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
    'icon' => null,
    'wrapperClass' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<label class="<?php echo \Illuminate\Support\Arr::toCssClasses(['block', $wrapperClass]); ?>">
    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]"><?php echo e($label); ?></span>

    <md-outlined-select
        name="<?php echo e($name); ?>"
        aria-label="<?php echo e($attributes->get('aria-label', $label)); ?>"
        <?php echo e($attributes->class(['w-full'])->except(['aria-label', 'style'])); ?>

        style="
            height: 44px;
            --md-outlined-select-text-field-container-shape: 8px;
            --md-outlined-select-text-field-outline-color: #e4d8d9;
            --md-outlined-select-text-field-hover-outline-color: #e4d8d9;
            --md-outlined-select-text-field-focus-outline-color: #ef5b97;
            --md-outlined-select-text-field-focus-outline-width: 1px;
            --md-outlined-select-text-field-input-text-color: #111827;
            --md-outlined-select-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-select-text-field-input-text-size: 14px;
            --md-outlined-select-text-field-input-text-line-height: 20px;
            --md-outlined-select-text-field-input-text-weight: 500;
            --md-outlined-select-text-field-leading-icon-size: 16px;
            --md-outlined-select-text-field-trailing-icon-size: 16px;
            --md-outlined-select-text-field-leading-icon-color: #98a2b3;
            --md-outlined-select-text-field-hover-leading-icon-color: #98a2b3;
            --md-outlined-select-text-field-focus-leading-icon-color: #98a2b3;
            --md-outlined-select-text-field-trailing-icon-color: #667085;
            --md-outlined-select-text-field-hover-trailing-icon-color: #667085;
            --md-outlined-select-text-field-focus-trailing-icon-color: #667085;
            --md-outlined-field-top-space: 12px;
            --md-outlined-field-bottom-space: 12px;
            --md-outlined-field-with-leading-content-leading-space: 12px;
            --md-outlined-field-content-space: 12px;
        "
    >
        <?php if($icon): ?>
            <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['slot' => 'leading-icon','class' => 'h-4 w-4 text-[#98a2b3]']); ?>
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
        <?php endif; ?>

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
                    class="text-sm font-medium leading-5 text-[#111827]"
                    style="font-family: Instrument Sans, ui-sans-serif, system-ui, sans-serif;"
                >
                    <?php echo e($optionLabel); ?>

                </div>
            </md-select-option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </md-outlined-select>
</label>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/material/outlined-select.blade.php ENDPATH**/ ?>