<?php $__env->startSection('title', 'Beneficiárias'); ?>
<?php $__env->startSection('active-menu', 'beneficiaries.index'); ?>
<?php $__env->startSection('breadcrumb', 'Beneficiárias'); ?>
<?php $__env->startSection('page-title', 'Cadastro de beneficiárias'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if(session('status')): ?>
            <div class="rounded-lg border border-[#b8e6c8] bg-[#effcf4] px-4 py-3 text-sm font-medium text-[#197a4b]">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Gestão de beneficiárias','title' => 'Beneficiárias cadastradas','description' => 'Consulte, filtre e acompanhe os cadastros das mães atendidas pela ONG.','firstButton' => [
            'label' => 'Nova beneficiária',
            'link' => route('beneficiaries.create'),
            'icon' => 'add',
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Gestão de beneficiárias','title' => 'Beneficiárias cadastradas','description' => 'Consulte, filtre e acompanhe os cadastros das mães atendidas pela ONG.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            'label' => 'Nova beneficiária',
            'link' => route('beneficiaries.create'),
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

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal1226e0d0db2f5d5b9f05a8d25259a5ea = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1226e0d0db2f5d5b9f05a8d25259a5ea = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.dashboard-card','data' => ['label' => $kpi['label'],'value' => $kpi['value'],'tone' => $kpi['tone'],'icon' => $kpi['icon'],'context' => $kpi['context']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.dashboard-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['label']),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['value']),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['tone']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['icon']),'context' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['context'])]); ?>
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
            'Nome',
            'CPF',
            'E-mail',
            'Contato',
            'Situação',
        ],'data' => $beneficiaries,'action' => route('beneficiaries.index'),'deleteConfirmation' => [
                    'title' => 'Excluir beneficiária?',
                    'message' => 'O cadastro será inativado para preservar o histórico de atendimentos da beneficiária. Deseja continuar?',
                    'confirmLabel' => 'Excluir beneficiária',
                    'variant' => 'danger',
                ],'filters' => [
            'search' => [
                'name' => 'q',
                'label' => 'Pesquisar beneficiárias',
                'placeholder' => 'Pesquisar beneficiárias por nome ou CPF',
                'value' => $search,
            ],
            'selects' => [
                [
                    'name' => 'status',
                    'label' => 'Situação da beneficiária',
                    'value' => $status,
                    'options' => [
                        ['value' => 'active', 'label' => 'Somente ativas'],
                        ['value' => 'all', 'label' => 'Todas'],
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
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            'Nome',
            'CPF',
            'E-mail',
            'Contato',
            'Situação',
        ]),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($beneficiaries),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('beneficiaries.index')),'delete-confirmation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'title' => 'Excluir beneficiária?',
                    'message' => 'O cadastro será inativado para preservar o histórico de atendimentos da beneficiária. Deseja continuar?',
                    'confirmLabel' => 'Excluir beneficiária',
                    'variant' => 'danger',
                ]),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            'search' => [
                'name' => 'q',
                'label' => 'Pesquisar beneficiárias',
                'placeholder' => 'Pesquisar beneficiárias por nome ou CPF',
                'value' => $search,
            ],
            'selects' => [
                [
                    'name' => 'status',
                    'label' => 'Situação da beneficiária',
                    'value' => $status,
                    'options' => [
                        ['value' => 'active', 'label' => 'Somente ativas'],
                        ['value' => 'all', 'label' => 'Todas'],
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

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/beneficiaries/index.blade.php ENDPATH**/ ?>