<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description',
    'subheading' => 'Painel executivo',
    'firstButton',
    'secondButton' => null,
    'confirmation' => null,
    'confirmationId' => null,
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
    'subheading' => 'Painel executivo',
    'firstButton',
    'secondButton' => null,
    'confirmation' => null,
    'confirmationId' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    if (isset($firstButton['icon'])) {
        $firstButton['icon'] = 'gmdi-' . $firstButton['icon'];
    }

    if (isset($secondButton['icon'])) {
        $secondButton['icon'] = 'gmdi-' . $secondButton['icon'];
    }

    $confirmationMethod = strtoupper($confirmation['method'] ?? 'GET');
    $confirmationAction = $confirmation['action']
        ?? ($confirmationMethod !== 'GET' ? ($confirmation['href'] ?? $firstButton['link']) : null);
    $confirmationHref = $confirmation['href']
        ?? ($confirmationAction ? null : $firstButton['link']);
?>

<div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
    <div>
        <p class="text-sm font-medium text-[#a62d5b]"><?php echo e($subheading); ?></p>
        <h2 class="mt-1 text-2xl font-bold tracking-normal text-[#111827] md:text-3xl"><?php echo e($title); ?></h2>
        <p class="mt-2 max-w-2xl text-sm text-[#667085]">
            <?php echo e($description); ?>

        </p>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row">
        <?php if(isset($firstButton['dialog'])): ?>
            <button
                type="button"
                data-dialog-open="<?php echo e($firstButton['dialog']); ?>"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c73570] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $firstButton['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                <?php echo e($firstButton['label']); ?>

            </button>
        <?php else: ?>
            <a href="<?php echo e($firstButton['link']); ?>"
                <?php if($confirmation && $confirmationId): ?> data-confirm-dialog-open="<?php echo e($confirmationId); ?>" <?php endif; ?>
                class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c73570] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $firstButton['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                <?php echo e($firstButton['label']); ?>

            </a>
        <?php endif; ?>

        <?php if($secondButton): ?>
            <?php if(isset($secondButton['dialog'])): ?>
                <button
                    type="button"
                    data-dialog-open="<?php echo e($secondButton['dialog']); ?>"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $secondButton['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                    <?php echo e($secondButton['label']); ?>

                </button>
            <?php else: ?>
                <a href="<?php echo e($secondButton['link']); ?>"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $secondButton['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                    <?php echo e($secondButton['label']); ?>

                </a>
            <?php endif; ?>

        <?php endif; ?>

        <?php if($confirmation && $confirmationId): ?>
            <?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => $confirmationId,'title' => $confirmation['title'] ?? 'Sair sem salvar?','message' => $confirmation['message'] ?? 'As informações não salvas serão perdidas.','confirmLabel' => $confirmation['confirmLabel'] ?? 'Sair sem salvar','cancelLabel' => $confirmation['cancelLabel'] ?? 'Continuar editando','variant' => $confirmation['variant'] ?? 'warning','icon' => $confirmation['icon'] ?? null,'action' => $confirmationAction,'method' => $confirmationMethod,'href' => $confirmationHref]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationId),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['title'] ?? 'Sair sem salvar?'),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['message'] ?? 'As informações não salvas serão perdidas.'),'confirm-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['confirmLabel'] ?? 'Sair sem salvar'),'cancel-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['cancelLabel'] ?? 'Continuar editando'),'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['variant'] ?? 'warning'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['icon'] ?? null),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationAction),'method' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationMethod),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationHref)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56125bb6dacfcebb197de13a56b0d464)): ?>
<?php $attributes = $__attributesOriginal56125bb6dacfcebb197de13a56b0d464; ?>
<?php unset($__attributesOriginal56125bb6dacfcebb197de13a56b0d464); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56125bb6dacfcebb197de13a56b0d464)): ?>
<?php $component = $__componentOriginal56125bb6dacfcebb197de13a56b0d464; ?>
<?php unset($__componentOriginal56125bb6dacfcebb197de13a56b0d464); ?>
<?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/app/page-info.blade.php ENDPATH**/ ?>