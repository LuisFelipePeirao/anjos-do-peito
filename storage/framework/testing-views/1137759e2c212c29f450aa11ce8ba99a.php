<?php $__env->startSection('title', 'Nova bomba de leite'); ?>
<?php $__env->startSection('active-menu', 'pumps.index'); ?>
<?php $__env->startSection('breadcrumb', 'Bombas de leite'); ?>
<?php $__env->startSection('page-title', 'Nova bomba de leite'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Cadastro de bombas','title' => 'Nova bomba de leite','description' => 'Registre identificação, origem e acessórios do equipamento.','firstButton' => ['label' => 'Voltar para lista', 'link' => route('pumps.index'), 'icon' => 'arrow-left']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Cadastro de bombas','title' => 'Nova bomba de leite','description' => 'Registre identificação, origem e acessórios do equipamento.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Voltar para lista', 'link' => route('pumps.index'), 'icon' => 'arrow-left'])]); ?>
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

        <form method="POST" action="<?php echo e(route('pumps.store')); ?>" class="space-y-6" data-unsaved-form>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('pages.pumps.partials.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('pages.pumps.partials.actions', ['cancelRoute' => route('pumps.index'), 'submitLabel' => 'Salvar bomba de leite'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/pumps/create.blade.php ENDPATH**/ ?>