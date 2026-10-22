<?php $__env->startSection('title', 'Novo item de estoque'); ?>
<?php $__env->startSection('active-menu', 'donations.index'); ?>
<?php $__env->startSection('breadcrumb', 'Itens de estoque'); ?>
<?php $__env->startSection('page-title', 'Novo item de estoque'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
    ?>

    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Estoque','title' => 'Novo item de estoque','description' => 'Cadastre material, categoria, unidade de medida e mínimo operacional.','firstButton' => ['label' => 'Voltar para lista', 'link' => route('donations.index'), 'icon' => 'arrow-left']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Estoque','title' => 'Novo item de estoque','description' => 'Cadastre material, categoria, unidade de medida e mínimo operacional.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Voltar para lista', 'link' => route('donations.index'), 'icon' => 'arrow-left'])]); ?>
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

        <form method="POST" action="<?php echo e(route('donations.materials.store')); ?>" class="space-y-6" data-unsaved-form>
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginal1872727e6b5db523b0ea16b4d2a07013 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donations.partials.form-shell','data' => ['title' => 'Dados do item','description' => 'Informações usadas no saldo e nos alertas de reposição.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donations.partials.form-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dados do item','description' => 'Informações usadas no saldo e nos alertas de reposição.']); ?>
                <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'nome','label' => 'Nome','value' => old('nome'),'placeholder' => 'Ex.: Fralda tamanho P','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'nome','label' => 'Nome','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('nome')),'placeholder' => 'Ex.: Fralda tamanho P','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $attributes = $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $component = $__componentOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>

                <div>
                    <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'id_categoria','label' => 'Categoria','options' => $categories,'selected' => old('id_categoria'),'placeholder' => 'Selecione','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id_categoria','label' => 'Categoria','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('id_categoria')),'placeholder' => 'Selecione','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                    <?php $__errorArgs = ['id_categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'unidade_medida','label' => 'Unidade de medida','value' => old('unidade_medida'),'placeholder' => 'Ex.: pacote','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'unidade_medida','label' => 'Unidade de medida','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('unidade_medida')),'placeholder' => 'Ex.: pacote','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $attributes = $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $component = $__componentOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'number','name' => 'estoque_minimo','label' => 'Estoque mínimo','value' => old('estoque_minimo', 0),'min' => '0','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'estoque_minimo','label' => 'Estoque mínimo','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('estoque_minimo', 0)),'min' => '0','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $attributes = $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $component = $__componentOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $attributes = $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $component = $__componentOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal532afa5495249d654038bc1a3e1688a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal532afa5495249d654038bc1a3e1688a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donations.partials.actions','data' => ['cancelRoute' => route('donations.index'),'submitLabel' => 'Salvar item']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donations.partials.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cancel-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('donations.index')),'submit-label' => 'Salvar item']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal532afa5495249d654038bc1a3e1688a1)): ?>
<?php $attributes = $__attributesOriginal532afa5495249d654038bc1a3e1688a1; ?>
<?php unset($__attributesOriginal532afa5495249d654038bc1a3e1688a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal532afa5495249d654038bc1a3e1688a1)): ?>
<?php $component = $__componentOriginal532afa5495249d654038bc1a3e1688a1; ?>
<?php unset($__componentOriginal532afa5495249d654038bc1a3e1688a1); ?>
<?php endif; ?>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/donations/materials/create.blade.php ENDPATH**/ ?>