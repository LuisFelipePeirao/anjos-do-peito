<?php $__env->startSection('title', 'Itens de estoque'); ?>
<?php $__env->startSection('active-menu', 'donations.index'); ?>
<?php $__env->startSection('breadcrumb', 'Itens de estoque'); ?>
<?php $__env->startSection('page-title', 'Itens de estoque'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Estoque','title' => 'Itens de estoque','description' => 'Acompanhe saldo por material, categoria, situação e última movimentação.','firstButton' => [
                'label' => 'Registrar movimentação',
                'link' => route('movements.create'),
                'icon' => 'add',
            ],'secondButton' => [
                'label' => 'Novo item',
                'link' => route('donations.materials.create'),
                'icon' => 'inventory-2-o',
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Estoque','title' => 'Itens de estoque','description' => 'Acompanhe saldo por material, categoria, situação e última movimentação.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'label' => 'Registrar movimentação',
                'link' => route('movements.create'),
                'icon' => 'add',
            ]),'secondButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'label' => 'Novo item',
                'link' => route('donations.materials.create'),
                'icon' => 'inventory-2-o',
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

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal1226e0d0db2f5d5b9f05a8d25259a5ea = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1226e0d0db2f5d5b9f05a8d25259a5ea = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.dashboard-card','data' => ['label' => $kpi['label'],'value' => $kpi['value'],'context' => $kpi['context'],'tone' => $kpi['tone'],'icon' => $kpi['icon'],'arrow' => $kpi['trendType'],'percent' => $kpi['trend']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.dashboard-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['label']),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['value']),'context' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['context']),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['tone']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['icon']),'arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['trendType']),'percent' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['trend'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1226e0d0db2f5d5b9f05a8d25259a5ea)): ?>
<?php $attributes = $__attributesOriginal1226e0d0db2f5d5b9f05a8d25259a5ea; ?>
<?php unset($__attributesOriginal1226e0d0db2f5d5b9f05a8d25259a5ea); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1226e0d0db2f5d5b9f05a8d25259a5ea)): ?>
<?php $component = $__componentOriginal1226e0d0db2f5d5b9f05a8d25259a5ea; ?>
<?php unset($__componentOriginal1226e0d0db2f5d5b9f05a8d25259a5ea); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => [
                'Descrição',
                'Categoria',
                'Quantidade',
                'Situação',
                'Última movimentação',
            ],'data' => $materials,'action' => route('donations.index'),'deleteConfirmation' => [
                'title' => 'Excluir item do estoque?',
                'message' => 'O item será removido da listagem, mas suas movimentações permanecerão no histórico. Deseja continuar?',
                'confirmLabel' => 'Excluir item',
                'variant' => 'danger',
            ],'filters' => [
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar materiais',
                    'placeholder' => 'Pesquisar por descrição ou categoria',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do estoque',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'Crítico', 'label' => 'Críticos'],
                            ['value' => 'Baixo', 'label' => 'Baixos'],
                            ['value' => 'Normal', 'label' => 'Normais'],
                        ],
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Categoria',
                        'value' => $category,
                        'options' => collect([['value' => 'all', 'label' => 'Todas as categorias']])
                            ->merge($categories->map(fn ($stockCategory) => ['value' => $stockCategory->id, 'label' => $stockCategory->nome]))
                            ->all(),
                    ],
                ],
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'Descrição',
                'Categoria',
                'Quantidade',
                'Situação',
                'Última movimentação',
            ]),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($materials),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('donations.index')),'delete-confirmation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'title' => 'Excluir item do estoque?',
                'message' => 'O item será removido da listagem, mas suas movimentações permanecerão no histórico. Deseja continuar?',
                'confirmLabel' => 'Excluir item',
                'variant' => 'danger',
            ]),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar materiais',
                    'placeholder' => 'Pesquisar por descrição ou categoria',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do estoque',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'Crítico', 'label' => 'Críticos'],
                            ['value' => 'Baixo', 'label' => 'Baixos'],
                            ['value' => 'Normal', 'label' => 'Normais'],
                        ],
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Categoria',
                        'value' => $category,
                        'options' => collect([['value' => 'all', 'label' => 'Todas as categorias']])
                            ->merge($categories->map(fn ($stockCategory) => ['value' => $stockCategory->id, 'label' => $stockCategory->nome]))
                            ->all(),
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

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/donations/index.blade.php ENDPATH**/ ?>