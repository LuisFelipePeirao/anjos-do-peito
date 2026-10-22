<?php $__env->startSection('title', $pumpData['code']); ?>
<?php $__env->startSection('active-menu', 'pumps.index'); ?>
<?php $__env->startSection('breadcrumb', 'Bombas de leite'); ?>
<?php $__env->startSection('page-title', $pumpData['code']); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $tabs = [
            'overview' => 'Visão geral',
            'loans' => 'Empréstimos',
            'payments' => 'Pagamentos',
            'maintenance' => 'Manutenções',
            'history' => 'Histórico',
        ];

        $statusClass = match ($pumpData['status']) {
            'Disponível' => 'bg-[#e8f8ee] text-[#197a4b]',
            'Emprestada' => 'bg-[#eef4ff] text-[#1769aa]',
            'Em atraso' => 'bg-[#fff7e6] text-[#8a4b00]',
            'Manutenção' => 'bg-[#f2f4f7] text-[#667085]',
            default => 'bg-[#fff1f1] text-[#b42336]',
        };
    ?>

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">
                    <?php echo e($pumpData['code']); ?> - <?php echo e($pumpData['model']); ?>

                </h2>
                <p class="mt-1 text-sm text-[#667085]">
                    Detalhes do equipamento, contrato atual, renovações, pagamentos e manutenções.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="<?php echo e(route('pumps.index')); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-arrow-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                    Voltar
                </a>
                <?php if($maintenanceAction['enabled']): ?>
                    <button type="button" data-dialog-open="pump-maintenance-modal" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-wrench'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                        Registrar manutenção
                    </button>
                <?php else: ?>
                    <span title="<?php echo e($maintenanceAction['reason']); ?>">
                        <button type="button" disabled aria-disabled="true" class="inline-flex h-11 cursor-not-allowed items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-[#f9fafb] px-4 text-sm font-semibold text-[#98a2b3]">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-wrench'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                            Registrar manutenção
                        </button>
                    </span>
                <?php endif; ?>
                <a href="<?php echo e(route('pumps.edit', $pump)); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-pencil'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                    Editar
                </a>
                <button type="button" data-confirm-dialog-open="pump-delete-confirmation" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#f2c7cb] bg-white px-4 text-sm font-semibold text-[#b42336] shadow-sm transition hover:bg-[#fff1f1]">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-trash-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                    Excluir
                </button>
            </div>
        </div>

        <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-[#8f4050]">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-milk'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-7 w-7']); ?>
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
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-bold text-[#111827]"><?php echo e($pumpData['code']); ?></h3>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-circle-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-3.5 w-3.5']); ?>
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
                                <?php echo e($pumpData['status']); ?>

                            </span>
                        </div>
                        <p class="mt-2 text-sm text-[#667085]" style="white-space: pre-line">
                            <?php echo e($currentContract ? $currentContract['notes'] : 'Bomba sem contrato ativo no momento, disponível para nova saída.'); ?>

                        </p>
                    </div>
                </div>

                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Modelo</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['model']); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Série</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['serial_number']); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Comodatário</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['beneficiary'] ?? '-'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Tipo atual</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['type'] ?? '-'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Expiração</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['expires_at'] ?? '-'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Última renovação</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['last_renewal'] ?? '-'); ?></dd>
                    </div>
                    <?php if(($currentContract['is_renewable'] ?? false) && in_array($pumpData['status'], ['Emprestada', 'Em atraso'], true)): ?>
                        <div class="sm:col-span-2 xl:col-span-4">
                            <div data-pump-loan-actions class="flex flex-col items-end gap-3">
                                <button type="button" data-dialog-open="pump-renewal-modal" class="inline-flex h-10 items-center justify-center gap-2 rounded-[8px] bg-[#c73570] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-refresh-cw'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                                    Renovar empréstimo
                                </button>
                                <button type="button" data-dialog-open="pump-return-modal" class="inline-flex h-10 items-center justify-center gap-2 rounded-[8px] border border-[#23845a] bg-white px-4 text-sm font-semibold text-[#197a4b] shadow-sm transition hover:bg-[#e8f8ee]">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-undo-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                                    Registrar devolução
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a
                        href="<?php echo e(route('pumps.show', ['pump' => $pump, 'tab' => $key])); ?>"
                        class="shrink-0 border-b-2 px-1 py-4 text-sm font-medium transition <?php echo e($tab === $key ? 'border-[#a62d5b] text-[#a62d5b]' : 'border-transparent text-[#4b5563] hover:text-[#a62d5b]'); ?>">
                        <?php echo e($label); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </nav>

        <?php if($tab === 'overview'): ?>
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

            <div class="grid gap-4 lg:grid-cols-2">
                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="flex items-start gap-3">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-handshake'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-0.5 h-5 w-5 shrink-0 text-[#a62d5b]']); ?>
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
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Contrato atual</h3>
                            <?php if($currentContract): ?>
                                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Tipo</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['type']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Mensalidade</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['monthly_fee']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Vencimento</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['billing_due_day']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase text-[#667085]">Termo</dt>
                                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($currentContract['term_status']); ?></dd>
                                    </div>
                                </dl>
                            <?php else: ?>
                                <p class="mt-2 text-sm leading-6 text-[#667085]">Não há empréstimo ou aluguel ativo para esta bomba.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="flex items-start gap-3">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-wrench'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-0.5 h-5 w-5 shrink-0 text-[#a62d5b]']); ?>
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
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Controle do equipamento</h3>
                            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Origem</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['origin']); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Cadastro</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['registered_at']); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Última higienização</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['last_sanitized_at']); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Próxima revisão</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['next_maintenance_at']); ?></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-xs font-semibold uppercase text-[#667085]">Acessórios</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($pumpData['accessories']); ?></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </article>
            </div>
        <?php elseif($tab === 'loans'): ?>
            <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => ['Período', 'Tipo', 'Beneficiária', 'Responsável', 'Situação'],'data' => $loanHistory,'showActions' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Período', 'Tipo', 'Beneficiária', 'Responsável', 'Situação']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loanHistory),'show-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
        <?php elseif($tab === 'payments'): ?>
            <?php if(count($payments)): ?>
                <div class="overflow-x-auto rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]"><table class="w-full min-w-225 text-left text-sm"><thead class="border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase text-[#667085]"><tr><th class="px-5 py-4">Beneficiária</th><th class="px-5 py-4">Data</th><th class="px-5 py-4">Referência</th><th class="px-5 py-4">Forma</th><th class="px-5 py-4">Valor</th><th class="px-5 py-4">Situação</th><th class="px-5 py-4 text-right">Ações</th></tr></thead><tbody class="divide-y divide-[#f0e7e8]"><?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><th class="px-5 py-4 font-semibold text-[#111827]"><?php echo e($payment['beneficiary']); ?></th><td class="px-5 py-4"><?php echo e($payment['date']); ?></td><td class="px-5 py-4"><?php echo e($payment['reference']); ?></td><td class="px-5 py-4"><?php echo e($payment['method']); ?></td><td class="px-5 py-4"><?php echo e($payment['value']); ?></td><td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e(match ($payment['status']) { 'Pago' => 'bg-[#e8f8ee] text-[#197a4b]', 'Pendente', 'Em atraso' => 'bg-[#fff7e6] text-[#8a4b00]', 'Cancelado' => 'bg-[#fff1f1] text-[#b42336]', default => 'bg-[#f2f4f7] text-[#667085]' }); ?>"><?php echo e($payment['status']); ?></span></td><td class="px-5 py-4 text-right"><?php if($payment['can_register']): ?><button type="button" data-dialog-open="payment-<?php echo e($payment['id']); ?>" title="Registrar pagamento" aria-label="Registrar pagamento" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#d1eadb] text-[#197a4b] transition hover:bg-[#e8f8ee]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-payments-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?></button><?php endif; ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody></table></div>
                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($payment['can_register']): ?><dialog id="payment-<?php echo e($payment['id']); ?>" data-dialog-modal class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-5"><form method="POST" action="<?php echo e(route('pumps.payments.pay', [$pump, $payment['id']])); ?>" class="space-y-5" data-unsaved-form><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><h2 class="text-lg font-bold">Registrar pagamento</h2><?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'date','name' => 'paid_at','label' => 'Data do pagamento','value' => old('paid_at', now()->toDateString()),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'paid_at','label' => 'Data do pagamento','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('paid_at', now()->toDateString())),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $attributes = $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $component = $__componentOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?><?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'notes','label' => 'Observações','value' => old('notes')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notes','label' => 'Observações','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('notes'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?><div class="flex justify-end gap-3"><button type="button" data-dialog-close class="rounded-lg border px-4 py-2">Cancelar</button><button class="rounded-lg bg-[#23845a] px-4 py-2 font-semibold text-white">Confirmar pagamento</button></div></form></dialog><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <article class="rounded-[8px] border border-[#eadfe0] bg-white p-8 text-center shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#fdecef] text-[#ef5b97]">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-receipt'); ?>
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
                    </div>
                    <p class="mt-3 font-semibold text-[#111827]">Nenhum pagamento registrado</p>
                    <p class="mt-1 text-sm text-[#667085]">Esta bomba não possui aluguel ativo ou cobranças registradas.</p>
                </article>
            <?php endif; ?>
        <?php elseif($tab === 'maintenance'): ?>
            <div class="overflow-x-auto rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <table class="w-full min-w-225 text-left text-sm">
                    <thead class="border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase text-[#667085]">
                        <tr>
                            <th class="px-5 py-4">Data</th>
                            <th class="px-5 py-4">Tipo</th>
                            <th class="px-5 py-4">Descrição</th>
                            <th class="px-5 py-4">Responsável</th>
                            <th class="px-5 py-4">Situação</th>
                            <th class="px-5 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e7e8]">
                        <?php $__empty_1 = true; $__currentLoopData = $maintenanceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maintenance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $maintenanceStatusClass = match ($maintenance['status']) {
                                    'Em andamento' => 'bg-[#e8f8ee] text-[#197a4b]',
                                    'Agendado' => 'bg-[#eef4ff] text-[#1769aa]',
                                    'Cancelado' => 'bg-[#fff1f1] text-[#b42336]',
                                    default => 'bg-[#f2f4f7] text-[#667085]',
                                };
                            ?>
                            <tr>
                                <td class="px-5 py-4"><?php echo e($maintenance['date']); ?></td>
                                <td class="px-5 py-4"><?php echo e($maintenance['type']); ?></td>
                                <td class="px-5 py-4"><?php echo e($maintenance['description']); ?></td>
                                <td class="px-5 py-4"><?php echo e($maintenance['responsible']); ?></td>
                                <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($maintenanceStatusClass); ?>"><?php echo e($maintenance['status']); ?></span></td>
                                <td class="px-5 py-4 text-right">
                                    <?php if($maintenance['is_open']): ?>
                                        <div class="inline-flex gap-2">
                                            <button type="button" data-dialog-open="maintenance-finish-<?php echo e($maintenance['id']); ?>" title="Concluir manutenção" aria-label="Concluir manutenção" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#d1eadb] text-[#197a4b] transition hover:bg-[#e8f8ee]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-check-circle-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?></button>
                                            <button type="button" data-dialog-open="maintenance-cancel-<?php echo e($maintenance['id']); ?>" title="Cancelar manutenção" aria-label="Cancelar manutenção" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#f2c7cb] text-[#b42336] transition hover:bg-[#fff1f1]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-cancel-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?></button>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-[#667085]">Nenhuma manutenção registrada para esta bomba.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif($tab === 'history'): ?>
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Histórico operacional</h3>
                    <p class="mt-1 text-sm text-[#667085]">Movimentações relevantes da bomba em ordem cronológica.</p>
                </div>

                <div class="space-y-5 p-5">
                    <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $icon = 'lucide-' . $item['icon'];
                        ?>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#f0dadd] bg-white text-[#a62d5b]">
                                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                                </span>
                                <?php if(!$loop->last): ?>
                                    <span class="mt-2 h-full min-h-8 w-px bg-[#eadfe0]"></span>
                                <?php endif; ?>
                            </div>
                            <div class="pb-1">
                                <p class="text-xs font-semibold text-[#667085]"><?php echo e($item['date']); ?></p>
                                <p class="mt-1 text-sm font-bold text-[#111827]"><?php echo e($item['type']); ?></p>
                                <p class="mt-1 text-sm text-[#667085]"><?php echo e($item['description']); ?></p>
                                <p class="mt-1 text-xs text-[#667085]">Responsável: <?php echo e($item['responsible']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </article>
        <?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => 'pump-delete-confirmation','title' => 'Excluir bomba de leite?','message' => 'Bombas com empréstimos ou manutenções vinculadas serão inativadas para preservar o histórico.','confirmLabel' => 'Excluir bomba','cancelLabel' => 'Cancelar','variant' => 'danger','action' => route('pumps.destroy', $pump),'method' => 'DELETE']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'pump-delete-confirmation','title' => 'Excluir bomba de leite?','message' => 'Bombas com empréstimos ou manutenções vinculadas serão inativadas para preservar o histórico.','confirm-label' => 'Excluir bomba','cancel-label' => 'Cancelar','variant' => 'danger','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('pumps.destroy', $pump)),'method' => 'DELETE']); ?>
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

        <dialog
            id="pump-maintenance-modal"
            aria-labelledby="pump-maintenance-modal-title"
            data-dialog-modal
            <?php if($errors->hasAny(['type', 'started_at', 'status', 'description'])): ?> data-dialog-auto-open <?php endif; ?>
            class="m-auto w-[calc(100%-2rem)] max-w-2xl rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45 backdrop:backdrop-blur-[2px]"
        >
            <form method="POST" action="<?php echo e(route('pumps.maintenance.store', $pump)); ?>" class="p-5 sm:p-6" data-unsaved-form>
                <?php echo csrf_field(); ?>

                <div class="flex items-start gap-4">
                    <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#fff1f1] text-[#a62d5b]">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-wrench'); ?>
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
                    </span>
                    <div class="min-w-0 flex-1 pt-0.5">
                        <h2 id="pump-maintenance-modal-title" class="text-base font-semibold text-[#111827]">Registrar manutenção</h2>
                        <p class="mt-1.5 text-sm leading-6 text-[#667085]">A bomba ficará indisponível até a conclusão ou o cancelamento da manutenção.</p>
                    </div>
                    <button type="button" data-dialog-close class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#98a2b3] transition hover:bg-[#f7edef] hover:text-[#667085]" aria-label="Fechar"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?></button>
                </div>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div><?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'type','label' => 'Tipo','options' => ['preventiva' => 'Preventiva', 'corretiva' => 'Corretiva', 'higienizacao' => 'Higienização'],'selected' => old('type', 'preventiva'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'type','label' => 'Tipo','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['preventiva' => 'Preventiva', 'corretiva' => 'Corretiva', 'higienizacao' => 'Higienização']),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('type', 'preventiva')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    <div><?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'status','label' => 'Situação inicial','options' => ['aberta' => 'Aberta', 'em_andamento' => 'Em andamento'],'selected' => old('status', 'aberta'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'status','label' => 'Situação inicial','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['aberta' => 'Aberta', 'em_andamento' => 'Em andamento']),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('status', 'aberta')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    <div class="sm:col-span-2"><?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'datetime-local','name' => 'started_at','label' => 'Data e hora de início','value' => old('started_at', now()->format('Y-m-d\TH:i')),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','name' => 'started_at','label' => 'Data e hora de início','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('started_at', now()->format('Y-m-d\TH:i'))),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $attributes = $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $component = $__componentOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?></div>
                    <div class="sm:col-span-2"><?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'description','label' => 'Descrição','value' => old('description'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'description','label' => 'Descrição','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('description')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?></div>
                    <div class="sm:col-span-2"><?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'notes','label' => 'Observações','value' => old('notes')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notes','label' => 'Observações','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('notes'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?></div>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button type="button" data-dialog-close class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:bg-[#fbfaf9]">Cancelar</button>
                    <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#c73570] px-4 text-sm font-semibold text-white transition hover:bg-[#a62d5b]">Registrar manutenção</button>
                </div>
            </form>
        </dialog>

        <?php $__currentLoopData = $maintenanceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maintenance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($maintenance['is_open']): ?>
                <dialog id="maintenance-finish-<?php echo e($maintenance['id']); ?>" data-dialog-modal <?php $__errorArgs = ['finished_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> data-dialog-auto-open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-5 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45">
                    <form method="POST" action="<?php echo e(route('pumps.maintenance.finish', [$pump, $maintenance['id']])); ?>" class="space-y-5" data-unsaved-form>
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <h2 class="text-lg font-bold">Concluir manutenção</h2>
                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['id' => 'finished_at-'.$maintenance['id'],'type' => 'datetime-local','name' => 'finished_at','label' => 'Data e hora da conclusão','min' => $maintenance['started_at_input'],'value' => old('finished_at', now()->format('Y-m-d\TH:i')),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('finished_at-'.$maintenance['id']),'type' => 'datetime-local','name' => 'finished_at','label' => 'Data e hora da conclusão','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($maintenance['started_at_input']),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('finished_at', now()->format('Y-m-d\TH:i'))),'required' => true]); ?>
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
                        <?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['id' => 'finish_notes-'.$maintenance['id'],'name' => 'notes','label' => 'Observações finais','value' => old('notes')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('finish_notes-'.$maintenance['id']),'name' => 'notes','label' => 'Observações finais','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('notes'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
                        <div class="flex justify-end gap-3"><button type="button" data-dialog-close class="rounded-lg border px-4 py-2">Cancelar</button><button class="rounded-lg bg-[#23845a] px-4 py-2 font-semibold text-white">Concluir</button></div>
                    </form>
                </dialog>

                <dialog id="maintenance-cancel-<?php echo e($maintenance['id']); ?>" data-dialog-modal class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-5 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45">
                    <form method="POST" action="<?php echo e(route('pumps.maintenance.cancel', [$pump, $maintenance['id']])); ?>" class="space-y-5" data-unsaved-form>
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <h2 class="text-lg font-bold">Cancelar manutenção</h2>
                        <?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['id' => 'cancel_notes-'.$maintenance['id'],'name' => 'notes','label' => 'Observações','value' => old('notes')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cancel_notes-'.$maintenance['id']),'name' => 'notes','label' => 'Observações','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('notes'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
                        <div class="flex justify-end gap-3"><button type="button" data-dialog-close class="rounded-lg border px-4 py-2">Voltar</button><button class="rounded-lg bg-[#c2414b] px-4 py-2 font-semibold text-white">Cancelar manutenção</button></div>
                    </form>
                </dialog>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(($currentContract['is_renewable'] ?? false) && in_array($pumpData['status'], ['Emprestada', 'Em atraso'], true)): ?>
            <dialog
                id="pump-return-modal"
                aria-labelledby="pump-return-modal-title"
                data-dialog-modal
                <?php $__errorArgs = ['returned_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> data-dialog-auto-open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45 backdrop:backdrop-blur-[2px]"
            >
                <form method="POST" action="<?php echo e(route('pumps.loans.return', $pump)); ?>" class="p-5 sm:p-6" data-unsaved-form>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="flex items-start gap-4">
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e8f8ee] text-[#197a4b]">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-undo-2'); ?>
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
                        </span>
                        <div class="min-w-0 flex-1 pt-0.5">
                            <h2 id="pump-return-modal-title" class="text-base font-semibold text-[#111827]">Registrar devolução</h2>
                            <p class="mt-1.5 text-sm leading-6 text-[#667085]">Confirme recebimento da bomba para finalizar empréstimo atual.</p>
                        </div>
                        <button type="button" data-dialog-close class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#98a2b3] transition hover:cursor-pointer hover:bg-[#f7edef] hover:text-[#667085] focus:outline-none focus:ring-3 focus:ring-[#fdecef]" aria-label="Fechar">
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

                    <div class="mt-6 space-y-5">
                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'datetime-local','name' => 'returned_at','label' => 'Data e hora da devolução','value' => old('returned_at', now()->format('Y-m-d\\TH:i')),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','name' => 'returned_at','label' => 'Data e hora da devolução','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('returned_at', now()->format('Y-m-d\\TH:i'))),'required' => true]); ?>
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
                        <?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'return_notes','label' => 'Observações da devolução','value' => old('return_notes')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'return_notes','label' => 'Observações da devolução','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('return_notes'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" data-dialog-close class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:cursor-pointer hover:bg-[#fbfaf9] focus:outline-none focus:ring-3 focus:ring-[#fdecef]">Cancelar</button>
                        <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#23845a] px-4 text-sm font-semibold text-white transition hover:cursor-pointer hover:bg-[#1d6b49] focus:outline-none focus:ring-3 focus:ring-[#d1f3dc]">Registrar devolução</button>
                    </div>
                </form>
            </dialog>

            <dialog
                id="pump-renewal-modal"
                aria-labelledby="pump-renewal-modal-title"
                data-dialog-modal
                <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> data-dialog-auto-open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                class="m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45 backdrop:backdrop-blur-[2px]"
            >
                <form method="POST" action="<?php echo e(route('pumps.loans.renew', $pump)); ?>" class="p-5 sm:p-6" data-unsaved-form>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="flex items-start gap-4">
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full <?php echo e(($currentContract['is_overdue'] ?? false) ? 'bg-[#fff7e6] text-[#8a4b00]' : 'bg-[#eef4ff] text-[#1769aa]'); ?>">
                            <?php if($currentContract['is_overdue'] ?? false): ?>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-warning-amber-o'); ?>
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
                            <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-refresh-cw'); ?>
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
                            <?php endif; ?>
                        </span>

                        <div class="min-w-0 flex-1 pt-0.5">
                            <h2 id="pump-renewal-modal-title" class="text-base font-semibold text-[#111827]">Renovar empréstimo</h2>
                            <p class="mt-1.5 text-sm leading-6 text-[#667085]">
                                <?php if($currentContract['is_overdue'] ?? false): ?>
                                    Este empréstimo está atrasado desde <?php echo e($currentContract['expires_at']); ?>. Confirme se deseja renovar mesmo assim.
                                <?php else: ?>
                                    Informe a nova data de expiração do empréstimo atual.
                                <?php endif; ?>
                            </p>
                        </div>

                        <button type="button" data-dialog-close class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#98a2b3] transition hover:cursor-pointer hover:bg-[#f7edef] hover:text-[#667085] focus:outline-none focus:ring-3 focus:ring-[#fdecef]" aria-label="Fechar">
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

                    <div class="mt-6">
                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'date','name' => 'expires_at','label' => 'Nova expiração','value' => old('expires_at', $currentContract['renewal_min_date']),'min' => $currentContract['renewal_min_date'],'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'expires_at','label' => 'Nova expiração','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('expires_at', $currentContract['renewal_min_date'])),'min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentContract['renewal_min_date']),'required' => true]); ?>
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
                        <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" data-dialog-close class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:cursor-pointer hover:bg-[#fbfaf9] focus:outline-none focus:ring-3 focus:ring-[#fdecef]">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#c73570] px-4 text-sm font-semibold text-white transition hover:cursor-pointer hover:bg-[#a62d5b] focus:outline-none focus:ring-3 focus:ring-[#fdecef]">
                            Renovar empréstimo
                        </button>
                    </div>
                </form>
            </dialog>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/pumps/show.blade.php ENDPATH**/ ?>