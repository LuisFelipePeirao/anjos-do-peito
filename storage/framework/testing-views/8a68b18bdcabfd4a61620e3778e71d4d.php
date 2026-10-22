<?php $__env->startSection('title', $stockItem['description']); ?>
<?php $__env->startSection('active-menu', 'donations.index'); ?>
<?php $__env->startSection('breadcrumb', 'Itens de estoque'); ?>
<?php $__env->startSection('page-title', $stockItem['description']); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $tabs = [
            'overview' => 'Visão geral',
            'movements' => 'Movimentações',
            'distributions' => 'Distribuições',
            'history' => 'Histórico',
        ];

        $statusClass = match ($stockItem['status']) {
            'Normal' => 'bg-[#e8f8ee] text-[#197a4b]',
            'Baixo' => 'bg-[#fff7e6] text-[#8a4b00]',
            'Crítico' => 'bg-[#fff1f1] text-[#b42336]',
            default => 'bg-[#f2f4f7] text-[#667085]',
        };
    ?>

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl"><?php echo e($stockItem['description']); ?></h2>
                <p class="mt-1 text-sm text-[#667085]">Detalhes do material, saldo atual, necessidade e histórico de movimentações.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="<?php echo e(route('donations.index')); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
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
                <a href="<?php echo e(route('movements.create', ['tipo' => 'saida', 'material' => $material->id])); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c73570] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-swap-horiz-o'); ?>
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
                    Registrar movimentação
                </a>
                <a href="<?php echo e(route('movements.create', ['tipo' => 'entrada'])); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-gift'); ?>
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
                    Registrar entrada
                </a>
            </div>
        </div>

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-[#8f4050]">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-inventory-2-o'); ?>
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
                            <h3 class="text-xl font-bold text-[#111827]"><?php echo e($stockItem['description']); ?></h3>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-check'); ?>
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
                                <?php echo e($stockItem['status']); ?>

                            </span>
                        </div>
                        <p class="mt-2 text-sm text-[#667085]">Material da categoria <?php echo e($stockItem['category']); ?> usado nas movimentações de estoque.</p>
                    </div>
                </div>

                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Categoria</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($stockItem['category']); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Quantidade</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($stockItem['quantity']); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Estoque mínimo</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($stockItem['minimum']); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Última movimentação</dt>
                        <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($stockItem['last_movement']); ?></dd>
                    </div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a
                        href="<?php echo e(route('donations.show', ['material' => $item, 'tab' => $key])); ?>"
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

            <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="flex items-start gap-3">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-report-problem-o'); ?>
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
                        <h3 class="text-lg font-bold text-[#111827]">Prioridade de movimentação</h3>
                        <p class="mt-2 text-sm leading-6 text-[#667085]">
                            Situação atual: <?php echo e($stockItem['status']); ?>. Use a quantidade, demanda mensal e estoque mínimo para priorizar novas entradas e saídas.
                        </p>
                    </div>
                </div>
            </article>
        <?php elseif($tab === 'movements'): ?>
            <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => ['Data e hora', 'Tipo', 'Quantidade', 'Origem', 'Responsável', 'Situação'],'data' => $movements,'showActions' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Data e hora', 'Tipo', 'Quantidade', 'Origem', 'Responsável', 'Situação']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($movements),'show-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
        <?php elseif($tab === 'distributions'): ?>
            <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => ['Data', 'Beneficiária', 'Quantidade', 'Responsável', 'Situação'],'data' => $distributions,'showActions' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Data', 'Beneficiária', 'Quantidade', 'Responsável', 'Situação']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($distributions),'show-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
        <?php elseif($tab === 'history'): ?>
            <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <h3 class="text-lg font-bold text-[#111827]">Histórico do material</h3>
                    <p class="mt-1 text-sm text-[#667085]">Eventos relevantes de estoque e movimentações.</p>
                </div>

                <div class="space-y-5 p-5">
                    <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $icon = 'gmdi-' . $event['icon'];
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
                                <p class="text-xs font-semibold text-[#667085]"><?php echo e($event['date']); ?></p>
                                <p class="mt-1 text-sm font-bold text-[#111827]"><?php echo e($event['type']); ?></p>
                                <p class="mt-1 text-sm text-[#667085]"><?php echo e($event['description']); ?></p>
                                <p class="mt-1 text-xs text-[#667085]">Responsável: <?php echo e($event['responsible']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </article>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/donations/show.blade.php ENDPATH**/ ?>