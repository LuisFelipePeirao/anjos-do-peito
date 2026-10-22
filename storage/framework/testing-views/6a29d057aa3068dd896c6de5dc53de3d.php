<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('active-menu', 'home'); ?>
<?php $__env->startSection('breadcrumb', 'Início'); ?>
<?php $__env->startSection('page-title', 'Visão geral'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $canManageAttendances = auth()->user()?->canManageAttendances();
        $primaryAction = $canManageAttendances
            ? ['label' => 'Novo atendimento', 'link' => route('attendances.create'), 'icon' => 'content-paste-o']
            : ['label' => 'Nova beneficiária', 'link' => route('beneficiaries.create'), 'icon' => 'person-add-o'];
        $secondaryAction = $canManageAttendances
            ? ['label' => 'Nova beneficiária', 'link' => route('beneficiaries.create'), 'icon' => 'person-add-o']
            : null;
    ?>

    <section class="space-y-6">

        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['title' => 'Visão geral da operação','description' => 'Indicadores de atendimento, estoque e pontos de atenção para hoje, '.e(date('d/m/Y')).'.','firstButton' => $primaryAction,'secondButton' => $secondaryAction]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Visão geral da operação','description' => 'Indicadores de atendimento, estoque e pontos de atenção para hoje, '.e(date('d/m/Y')).'.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primaryAction),'secondButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($secondaryAction)]); ?>
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

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1.45fr)_minmax(360px,0.85fr)]">
            <?php if (isset($component)) { $__componentOriginal1c4736277ad94cf9e4bb75fe21df96f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c4736277ad94cf9e4bb75fe21df96f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.column-chart','data' => ['title' => 'Atendimentos realizados por mês','description' => 'Quantidade de atendimentos realizados nos últimos seis meses.','data' => $monthlyAttendances]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.column-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Atendimentos realizados por mês','description' => 'Quantidade de atendimentos realizados nos últimos seis meses.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($monthlyAttendances)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c4736277ad94cf9e4bb75fe21df96f9)): ?>
<?php $attributes = $__attributesOriginal1c4736277ad94cf9e4bb75fe21df96f9; ?>
<?php unset($__attributesOriginal1c4736277ad94cf9e4bb75fe21df96f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c4736277ad94cf9e4bb75fe21df96f9)): ?>
<?php $component = $__componentOriginal1c4736277ad94cf9e4bb75fe21df96f9; ?>
<?php unset($__componentOriginal1c4736277ad94cf9e4bb75fe21df96f9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal1c972d50f499a23e91b0e0f847161f44 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c972d50f499a23e91b0e0f847161f44 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.stock-distribution','data' => ['title' => 'Distribuição do estoque','description' => 'Itens disponíveis versus itens em uso.','data' => $stock,'totalStock' => $totalStock]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.stock-distribution'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Distribuição do estoque','description' => 'Itens disponíveis versus itens em uso.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stock),'total-stock' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalStock)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c972d50f499a23e91b0e0f847161f44)): ?>
<?php $attributes = $__attributesOriginal1c972d50f499a23e91b0e0f847161f44; ?>
<?php unset($__attributesOriginal1c972d50f499a23e91b0e0f847161f44); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c972d50f499a23e91b0e0f847161f44)): ?>
<?php $component = $__componentOriginal1c972d50f499a23e91b0e0f847161f44; ?>
<?php unset($__componentOriginal1c972d50f499a23e91b0e0f847161f44); ?>
<?php endif; ?>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <?php if (isset($component)) { $__componentOriginald39dc2f409f8d3d7424c9e42dd9d0e5e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald39dc2f409f8d3d7424c9e42dd9d0e5e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.pipeline-chart','data' => ['title' => 'Fluxo de atendimento','description' => 'Volume por etapa ativa da jornada.','data' => $pipeline]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.pipeline-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Fluxo de atendimento','description' => 'Volume por etapa ativa da jornada.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pipeline)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald39dc2f409f8d3d7424c9e42dd9d0e5e)): ?>
<?php $attributes = $__attributesOriginald39dc2f409f8d3d7424c9e42dd9d0e5e; ?>
<?php unset($__attributesOriginald39dc2f409f8d3d7424c9e42dd9d0e5e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald39dc2f409f8d3d7424c9e42dd9d0e5e)): ?>
<?php $component = $__componentOriginald39dc2f409f8d3d7424c9e42dd9d0e5e; ?>
<?php unset($__componentOriginald39dc2f409f8d3d7424c9e42dd9d0e5e); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal4cfeff92f14f346f7bc9aafe945fefff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4cfeff92f14f346f7bc9aafe945fefff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.priority-alerts','data' => ['title' => 'Atenções prioritárias','description' => 'Pendências que exigem ação da equipe.','data' => $risks]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.priority-alerts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Atenções prioritárias','description' => 'Pendências que exigem ação da equipe.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($risks)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4cfeff92f14f346f7bc9aafe945fefff)): ?>
<?php $attributes = $__attributesOriginal4cfeff92f14f346f7bc9aafe945fefff; ?>
<?php unset($__attributesOriginal4cfeff92f14f346f7bc9aafe945fefff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4cfeff92f14f346f7bc9aafe945fefff)): ?>
<?php $component = $__componentOriginal4cfeff92f14f346f7bc9aafe945fefff; ?>
<?php unset($__componentOriginal4cfeff92f14f346f7bc9aafe945fefff); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal34244e5434d435946564a9f5ba7c7eb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal34244e5434d435946564a9f5ba7c7eb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.recent-activities','data' => ['title' => 'Atividades recentes','description' => 'Últimos registros operacionais lançados.','data' => $recent]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.recent-activities'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Atividades recentes','description' => 'Últimos registros operacionais lançados.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recent)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal34244e5434d435946564a9f5ba7c7eb4)): ?>
<?php $attributes = $__attributesOriginal34244e5434d435946564a9f5ba7c7eb4; ?>
<?php unset($__attributesOriginal34244e5434d435946564a9f5ba7c7eb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal34244e5434d435946564a9f5ba7c7eb4)): ?>
<?php $component = $__componentOriginal34244e5434d435946564a9f5ba7c7eb4; ?>
<?php unset($__componentOriginal34244e5434d435946564a9f5ba7c7eb4); ?>
<?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/home.blade.php ENDPATH**/ ?>