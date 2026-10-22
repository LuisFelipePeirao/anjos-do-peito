<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'text',
    'id' => null,
    'label',
    'name',
    'value' => null,
    'placeholder' => '',
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
    'type' => 'text',
    'id' => null,
    'label',
    'name',
    'value' => null,
    'placeholder' => '',
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
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
    $showRequiredMarker = $required || $requiredIndicator;
?>

<div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['relative', $wrapperClass]); ?>">
    <input
        id="<?php echo e($inputId); ?>"
        type="<?php echo e($type); ?>"
        name="<?php echo e($name); ?>"
        value="<?php echo e($value); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        <?php if($required): ?> required <?php endif; ?>
        <?php echo e($attributes->class([
            'peer h-11 w-full rounded-[8px] border bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-transparent focus:placeholder:text-[#98a2b3] focus:ring-2 focus:ring-[#ef5b97]/15',
            'border-[#e4d8d9] focus:border-[#ef5b97]' => ! $hasError,
            'border-[#c2414b] focus:border-[#c2414b] focus:ring-[#c2414b]/15' => $hasError,
        ])); ?>

    >

    <label
        for="<?php echo e($inputId); ?>"
        class="pointer-events-none absolute left-3 top-0 flex h-11 items-center px-1 text-left text-sm font-semibold text-[#344054] transition-all peer-focus:-top-2.5 peer-focus:h-auto peer-focus:bg-white peer-focus:text-xs peer-focus:text-[#ef5b97] peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:h-auto peer-not-placeholder-shown:bg-white peer-not-placeholder-shown:text-xs"
    ><?php echo e($label); ?><?php if($showRequiredMarker): ?><span aria-hidden="true" data-required-indicator="<?php echo e($name); ?>" class="ml-0.5 text-[#b42336]">*</span><?php endif; ?></label>

    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/material/floating-input.blade.php ENDPATH**/ ?>