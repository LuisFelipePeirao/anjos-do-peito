<?php $__env->startSection('title', 'Movimentações'); ?>
<?php $__env->startSection('active-menu', 'movements.index'); ?>
<?php $__env->startSection('breadcrumb', 'Movimentações'); ?>
<?php $__env->startSection('page-title', 'Movimentações'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Estoque','title' => 'Movimentações','description' => 'Acompanhe entradas, saídas e ajustes registrados no estoque.','firstButton' => [
                'label' => 'Registrar movimentação',
                'link' => route('movements.create'),
                'icon' => 'add',
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Estoque','title' => 'Movimentações','description' => 'Acompanhe entradas, saídas e ajustes registrados no estoque.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'label' => 'Registrar movimentação',
                'link' => route('movements.create'),
                'icon' => 'add',
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267)): ?>
<?php $attributes = $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267; ?>
<?php unset($__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal26e5d4095a2a19e4a62e755b3aefe267)): ?>
<?php $component = $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267; ?>
<?php unset($__componentOriginal26e5d4095a2a19e4a62e755b3aefe267); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => ['Data e hora', 'Tipo', 'Origem ou destino', 'Material', 'Responsável', 'Situação'],'data' => $movements,'action' => route('movements.index'),'filters' => [
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar movimentações',
                    'placeholder' => 'Pesquisar por material, origem ou responsável',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'type',
                        'label' => 'Tipo',
                        'value' => $type,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todos os tipos'],
                            ['value' => 'entrada', 'label' => 'Entradas'],
                            ['value' => 'saida', 'label' => 'Saídas'],
                            ['value' => 'ajuste', 'label' => 'Ajustes'],
                        ],
                    ],
                ],
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Data e hora', 'Tipo', 'Origem ou destino', 'Material', 'Responsável', 'Situação']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($movements),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('movements.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar movimentações',
                    'placeholder' => 'Pesquisar por material, origem ou responsável',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'type',
                        'label' => 'Tipo',
                        'value' => $type,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todos os tipos'],
                            ['value' => 'entrada', 'label' => 'Entradas'],
                            ['value' => 'saida', 'label' => 'Saídas'],
                            ['value' => 'ajuste', 'label' => 'Ajustes'],
                        ],
                    ],
                ],
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9649e75090bf6a96fa801b770a21768)): ?>
<?php $attributes = $__attributesOriginald9649e75090bf6a96fa801b770a21768; ?>
<?php unset($__attributesOriginald9649e75090bf6a96fa801b770a21768); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9649e75090bf6a96fa801b770a21768)): ?>
<?php $component = $__componentOriginald9649e75090bf6a96fa801b770a21768; ?>
<?php unset($__componentOriginald9649e75090bf6a96fa801b770a21768); ?>
<?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/movements/index.blade.php ENDPATH**/ ?>