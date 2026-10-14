<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'value' => 'CLique aqui'
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
    'value' => 'CLique aqui'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<input 
    type="submit"
    class="mb-12 w-full cursor-pointer rounded-lg border-none bg-[#c73570] p-4 text-base text-white outline-none transition duration-300 hover:shadow-[0_15px_36px_rgba(0,0,0,0.15)]"
    value="<?php echo e($value); ?>"><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/login/login-button.blade.php ENDPATH**/ ?>