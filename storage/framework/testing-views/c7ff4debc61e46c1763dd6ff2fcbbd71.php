<?php $__env->startSection('title', 'Atendimentos'); ?>
<?php $__env->startSection('active-menu', 'attendances.index'); ?>
<?php $__env->startSection('breadcrumb', 'Atendimentos'); ?>
<?php $__env->startSection('page-title', 'Gestão de atendimentos'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Gestão de atendimentos','title' => 'Atendimentos registrados','description' => 'Consulte, filtre e acompanhe os atendimentos realizados ou agendados pela equipe.','firstButton' => [
                'label' => 'Novo atendimento',
                'link' => route('attendances.create'),
                'icon' => 'add',
            ],'secondButton' => [
                'label' => 'Novo local de atendimento',
                'link' => '#',
                'icon' => 'add',
                'dialog' => 'attendance-location-create-dialog',
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Gestão de atendimentos','title' => 'Atendimentos registrados','description' => 'Consulte, filtre e acompanhe os atendimentos realizados ou agendados pela equipe.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'label' => 'Novo atendimento',
                'link' => route('attendances.create'),
                'icon' => 'add',
            ]),'secondButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'label' => 'Novo local de atendimento',
                'link' => '#',
                'icon' => 'add',
                'dialog' => 'attendance-location-create-dialog',
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.dashboard-card','data' => ['label' => $kpi['label'],'value' => $kpi['value'],'tone' => $kpi['tone'],'icon' => $kpi['icon'],'context' => $kpi['context'],'arrow' => $kpi['trendType'],'percent' => $kpi['trend']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.dashboard-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['label']),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['value']),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['tone']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['icon']),'context' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['context']),'arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['trendType']),'percent' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpi['trend'])]); ?>
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
                'Data',
                'Horário',
                'Beneficiária',
                'Profissional',
                'Modalidade',
                'Situação',
            ],'data' => $attendances,'action' => route('attendances.index'),'deleteConfirmation' => [
                'title' => 'Excluir atendimento?',
                'message' => 'As informações deste atendimento deixarão de aparecer no histórico. Deseja continuar?',
                'confirmLabel' => 'Excluir atendimento',
            ],'filters' => [
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar atendimentos',
                    'placeholder' => 'Pesquisar por beneficiária, profissional ou resumo',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do atendimento',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'agendado', 'label' => 'Agendados'],
                            ['value' => 'em_atendimento', 'label' => 'Em andamento'],
                            ['value' => 'realizado', 'label' => 'Realizados'],
                            ['value' => 'cancelado', 'label' => 'Cancelados'],
                        ],
                    ],
                    [
                        'name' => 'modality',
                        'label' => 'Modalidade do atendimento',
                        'value' => $modality,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as modalidades'],
                            ['value' => 'presencial', 'label' => 'Presencial'],
                            ['value' => 'remota', 'label' => 'Remota'],
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
                'Data',
                'Horário',
                'Beneficiária',
                'Profissional',
                'Modalidade',
                'Situação',
            ]),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attendances),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('attendances.index')),'delete-confirmation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'title' => 'Excluir atendimento?',
                'message' => 'As informações deste atendimento deixarão de aparecer no histórico. Deseja continuar?',
                'confirmLabel' => 'Excluir atendimento',
            ]),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar atendimentos',
                    'placeholder' => 'Pesquisar por beneficiária, profissional ou resumo',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do atendimento',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'agendado', 'label' => 'Agendados'],
                            ['value' => 'em_atendimento', 'label' => 'Em andamento'],
                            ['value' => 'realizado', 'label' => 'Realizados'],
                            ['value' => 'cancelado', 'label' => 'Cancelados'],
                        ],
                    ],
                    [
                        'name' => 'modality',
                        'label' => 'Modalidade do atendimento',
                        'value' => $modality,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as modalidades'],
                            ['value' => 'presencial', 'label' => 'Presencial'],
                            ['value' => 'remota', 'label' => 'Remota'],
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

        <?php echo $__env->make('pages.attendances.partials.location-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if($errors->location->any()): ?>
            <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('attendance-location-create-dialog')?.showModal());</script>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/attendances/index.blade.php ENDPATH**/ ?>