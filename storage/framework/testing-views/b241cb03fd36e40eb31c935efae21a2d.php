<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id',
    'title' => 'Confirmar ação',
    'message' => 'Deseja realmente continuar?',
    'confirmLabel' => 'Confirmar',
    'cancelLabel' => 'Cancelar',
    'variant' => 'danger',
    'icon' => null,
    'action' => null,
    'method' => 'POST',
    'href' => null,
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
    'id',
    'title' => 'Confirmar ação',
    'message' => 'Deseja realmente continuar?',
    'confirmLabel' => 'Confirmar',
    'cancelLabel' => 'Cancelar',
    'variant' => 'danger',
    'icon' => null,
    'action' => null,
    'method' => 'POST',
    'href' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $variantConfig = match ($variant) {
        'warning' => [
            'icon' => 'gmdi-warning-amber-o',
            'iconClass' => 'bg-[#fff7e6] text-[#8a4b00]',
            'buttonClass' => 'bg-[#b76b00] hover:bg-[#965800] focus:ring-[#fff0cc]',
        ],
        'default' => [
            'icon' => 'gmdi-help-outline-o',
            'iconClass' => 'bg-[#eef4ff] text-[#1769aa]',
            'buttonClass' => 'bg-[#111827] hover:bg-[#252f3f] focus:ring-[#e5e7eb]',
        ],
        default => [
            'icon' => 'gmdi-warning-o',
            'iconClass' => 'bg-[#fff1f1] text-[#b42336]',
            'buttonClass' => 'bg-[#c2414b] hover:bg-[#a93640] focus:ring-[#ffe0e0]',
        ],
    };

    $modalIcon = $icon ?: $variantConfig['icon'];
    $normalizedMethod = strtoupper($method);
?>

<dialog
    id="<?php echo e($id); ?>"
    aria-labelledby="<?php echo e($id); ?>-title"
    aria-describedby="<?php echo e($id); ?>-message"
    data-confirm-dialog-modal
    class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45 backdrop:backdrop-blur-[2px]"
>
    <div class="p-5 sm:p-6">
        <div class="flex items-start gap-4">
            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full <?php echo e($variantConfig['iconClass']); ?>">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $modalIcon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
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
            </span>

            <div class="min-w-0 flex-1 pt-0.5">
                <h2 id="<?php echo e($id); ?>-title" class="text-base font-semibold text-[#111827]">
                    <?php echo e($title); ?>

                </h2>
                <p id="<?php echo e($id); ?>-message" class="mt-1.5 text-sm leading-6 text-[#667085]">
                    <?php echo e($message); ?>

                </p>
            </div>

            <button
                type="button"
                data-confirm-dialog-close
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#98a2b3] transition hover:cursor-pointer hover:bg-[#f7edef] hover:text-[#667085] focus:outline-none focus:ring-3 focus:ring-[#fdecef]"
                aria-label="Fechar"
            >
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-close-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
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
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button
                type="button"
                data-confirm-dialog-close
                class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:cursor-pointer hover:bg-[#fbfaf9] focus:outline-none focus:ring-3 focus:ring-[#fdecef]"
            >
                <?php echo e($cancelLabel); ?>

            </button>

            <?php if($action): ?>
                <form action="<?php echo e($action); ?>" method="<?php echo e($normalizedMethod === 'GET' ? 'GET' : 'POST'); ?>">
                    <?php if($normalizedMethod !== 'GET'): ?>
                        <?php echo csrf_field(); ?>
                    <?php endif; ?>
                    <?php if(!in_array($normalizedMethod, ['GET', 'POST'])): ?>
                        <?php echo method_field($normalizedMethod); ?>
                    <?php endif; ?>

                    <button
                        type="submit"
                        class="inline-flex h-10 w-full items-center justify-center rounded-lg px-4 text-sm font-semibold text-white transition hover:cursor-pointer focus:outline-none focus:ring-3 <?php echo e($variantConfig['buttonClass']); ?>"
                    >
                        <?php echo e($confirmLabel); ?>

                    </button>
                </form>
            <?php elseif($href): ?>
                <a
                    href="<?php echo e($href); ?>"
                    class="inline-flex h-10 items-center justify-center rounded-lg px-4 text-sm font-semibold text-white transition hover:cursor-pointer focus:outline-none focus:ring-3 <?php echo e($variantConfig['buttonClass']); ?>"
                >
                    <?php echo e($confirmLabel); ?>

                </a>
            <?php else: ?>
                <button
                    type="button"
                    data-confirm-dialog-confirm
                    class="inline-flex h-10 items-center justify-center rounded-lg px-4 text-sm font-semibold text-white transition hover:cursor-pointer focus:outline-none focus:ring-3 <?php echo e($variantConfig['buttonClass']); ?>"
                >
                    <?php echo e($confirmLabel); ?>

                </button>
            <?php endif; ?>
        </div>
    </div>
</dialog>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/app/confirm-modal.blade.php ENDPATH**/ ?>