<?php $__env->startSection('title', 'Relatórios'); ?>
<?php $__env->startSection('active-menu', 'reports.index'); ?>
<?php $__env->startSection('breadcrumb', 'Relatórios'); ?>
<?php $__env->startSection('page-title', 'Relatórios'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Painel analítico','title' => 'Relatórios operacionais','description' => 'Análises por área para investigar prazos, desempenho, cobertura de estoque e sustentabilidade dos contratos.','firstButton' => [
            'label' => 'Gerar Relatório de Atividades',
            'link' => route('reports.export', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'section' => $section,
                'location' => $location,
            ]),
            'icon' => 'download',
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Painel analítico','title' => 'Relatórios operacionais','description' => 'Análises por área para investigar prazos, desempenho, cobertura de estoque e sustentabilidade dos contratos.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            'label' => 'Gerar Relatório de Atividades',
            'link' => route('reports.export', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'section' => $section,
                'location' => $location,
            ]),
            'icon' => 'download',
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

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <form action="<?php echo e(route('reports.index')); ?>" method="GET"
                class="grid gap-3 md:grid-cols-2 xl:grid-cols-[minmax(180px,0.8fr)_minmax(180px,0.8fr)_minmax(220px,1fr)_minmax(220px,1fr)_auto]">
                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">Período inicial</span>
                    <span class="relative block">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-calendar-month-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]']); ?>
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
                        <input type="date" name="start_date" value="<?php echo e($startDate); ?>"
                            class="h-11 w-full rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </span>
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">Período final</span>
                    <span class="relative block">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-calendar-month-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]']); ?>
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
                        <input type="date" name="end_date" value="<?php echo e($endDate); ?>"
                            class="h-11 w-full rounded-lg border border-[#e4d8d9] bg-white pl-10 pr-3 text-sm font-medium text-[#111827] outline-none transition hover:cursor-pointer focus:border-[#ef5b97] focus:ring-3 focus:ring-[#fdecef]" />
                    </span>
                </label>

                <?php if (isset($component)) { $__componentOriginal050cb78dd2a0629fc98da9303d02daec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal050cb78dd2a0629fc98da9303d02daec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.outlined-select','data' => ['name' => 'section','label' => 'Seções','icon' => 'gmdi-filter-alt-o','selected' => $section,'options' => [
                        'all' => 'Todas as seções',
                        'pumps' => 'Bombas de leite',
                        'attendances' => 'Atendimentos',
                        'stock' => 'Itens de estoque',
                    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.outlined-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'section','label' => 'Seções','icon' => 'gmdi-filter-alt-o','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'all' => 'Todas as seções',
                        'pumps' => 'Bombas de leite',
                        'attendances' => 'Atendimentos',
                        'stock' => 'Itens de estoque',
                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal050cb78dd2a0629fc98da9303d02daec)): ?>
<?php $attributes = $__attributesOriginal050cb78dd2a0629fc98da9303d02daec; ?>
<?php unset($__attributesOriginal050cb78dd2a0629fc98da9303d02daec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal050cb78dd2a0629fc98da9303d02daec)): ?>
<?php $component = $__componentOriginal050cb78dd2a0629fc98da9303d02daec; ?>
<?php unset($__componentOriginal050cb78dd2a0629fc98da9303d02daec); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal050cb78dd2a0629fc98da9303d02daec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal050cb78dd2a0629fc98da9303d02daec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.outlined-select','data' => ['name' => 'location','label' => 'Unidades','icon' => 'gmdi-filter-alt-o','selected' => $location,'options' => $locationOptions]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.outlined-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'location','label' => 'Unidades','icon' => 'gmdi-filter-alt-o','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($location),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($locationOptions)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal050cb78dd2a0629fc98da9303d02daec)): ?>
<?php $attributes = $__attributesOriginal050cb78dd2a0629fc98da9303d02daec; ?>
<?php unset($__attributesOriginal050cb78dd2a0629fc98da9303d02daec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal050cb78dd2a0629fc98da9303d02daec)): ?>
<?php $component = $__componentOriginal050cb78dd2a0629fc98da9303d02daec; ?>
<?php unset($__componentOriginal050cb78dd2a0629fc98da9303d02daec); ?>
<?php endif; ?>

                <button type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#111827] px-4 text-sm font-semibold text-white transition hover:bg-[#252f3f] xl:mt-5">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-filter-alt-o'); ?>
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
                    Aplicar filtros
                </button>
            </form>
        </article>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <?php $__currentLoopData = $reportKpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

        <?php if($section === 'all' || $section === 'pumps'): ?>
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Bombas de leite</h3>
                    <p class="mt-1 text-sm text-[#667085]">Acompanhamento de contratos, renovações, atrasos e impacto dos
                        aluguéis.</p>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <?php $__currentLoopData = $pumpOverview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                            <span
                                class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($item['tone']); ?>"><?php echo e($item['label']); ?></span>
                            <p class="mt-4 text-3xl font-bold text-[#111827]"><?php echo e($item['value']); ?></p>
                            <p class="mt-2 text-sm leading-6 text-[#667085]"><?php echo e($item['description']); ?></p>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
                    <?php if (isset($component)) { $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.metric-bars','data' => ['title' => 'Contratos por tipo','description' => 'Comparativo entre empréstimos gratuitos e aluguéis com cobrança.','data' => $pumpContractChart]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.metric-bars'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Contratos por tipo','description' => 'Comparativo entre empréstimos gratuitos e aluguéis com cobrança.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pumpContractChart)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $attributes = $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $component = $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>

                    <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                        <div class="border-b border-[#f0e7e8] pb-5">
                            <h3 class="text-lg font-bold text-[#111827]">Prazos de renovação</h3>
                            <p class="mt-1 text-sm text-[#667085]">Bombas com datas de expiração e próxima renovação.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            <?php $__currentLoopData = $pumpDueDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $statusClass = match ($loan['status']) {
                                        'Normal' => 'bg-[#e8f8ee] text-[#197a4b]',
                                        'Pendente' => 'bg-[#fff7e6] text-[#8a4b00]',
                                        'Em atraso' => 'bg-[#fff1f1] text-[#b42336]',
                                        default => 'bg-[#f2f4f7] text-[#667085]',
                                    };
                                ?>

                                <div class="rounded-lg border border-[#f0e7e8] p-4">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-base font-bold text-[#111827]"><?php echo e($loan['pump']); ?> · <?php echo e($loan['type']); ?>

                                            </p>
                                            <p class="mt-1 text-sm text-[#667085]"><?php echo e($loan['beneficiary']); ?></p>
                                        </div>
                                        <span
                                            class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                            <?php echo e($loan['status']); ?>

                                        </span>
                                    </div>
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Expiração</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($loan['expires_at']); ?></p>
                                        </div>
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Renovação</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($loan['renewal_at']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </article>
                </div>
            </section>
        <?php endif; ?>

        <?php if($section === 'all' || $section === 'attendances'): ?>
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Atendimentos</h3>
                    <p class="mt-1 text-sm text-[#667085]">Indicadores de qualidade, retorno e distribuição entre atendimentos
                        presenciais e remotos.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <?php if (isset($component)) { $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.metric-bars','data' => ['title' => 'Modalidades no período','description' => 'Participação de atendimentos presenciais e remotos no total.','data' => $attendanceModalityChart]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.metric-bars'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Modalidades no período','description' => 'Participação de atendimentos presenciais e remotos no total.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attendanceModalityChart)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $attributes = $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $component = $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.metric-bars','data' => ['title' => 'Capacidade por profissional','description' => 'Volume de atendimentos com retornos e distribuições vinculadas.','data' => $professionalChart]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.metric-bars'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Capacidade por profissional','description' => 'Volume de atendimentos com retornos e distribuições vinculadas.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($professionalChart)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $attributes = $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $component = $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if($section === 'all' || $section === 'stock'): ?>
            <section class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-[#111827]">Itens de estoque</h3>
                    <p class="mt-1 text-sm text-[#667085]">Leitura de cobertura, necessidade futura e origem das doações.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
                    <?php if (isset($component)) { $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chart.metric-bars','data' => ['title' => 'Cobertura por item','description' => 'Estimativa de duração do estoque pelos itens de maior saída.','data' => $stockCoverageChart]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.metric-bars'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Cobertura por item','description' => 'Estimativa de duração do estoque pelos itens de maior saída.','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stockCoverageChart)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $attributes = $__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__attributesOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76)): ?>
<?php $component = $__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76; ?>
<?php unset($__componentOriginal41ed5aebe1733f657c2cd6d0c2a91b76); ?>
<?php endif; ?>

                    <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                        <div class="border-b border-[#f0e7e8] pb-5">
                            <h3 class="text-lg font-bold text-[#111827]">Origem das doações</h3>
                            <p class="mt-1 text-sm text-[#667085]">Entradas recentes agrupadas por campanha ou recorrência.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            <?php $__currentLoopData = $donationSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $statusClass = $source['status'] === 'Normal'
                                        ? 'bg-[#e8f8ee] text-[#197a4b]'
                                        : 'bg-[#fff7e6] text-[#8a4b00]';
                                ?>

                                <div class="rounded-lg border border-[#f0e7e8] p-4">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-base font-bold text-[#111827]"><?php echo e($source['source']); ?></p>
                                            <p class="mt-1 text-sm text-[#667085]"><?php echo e($source['main_category']); ?> ·
                                                <?php echo e($source['recurrence']); ?></p>
                                        </div>
                                        <span
                                            class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                            <?php echo e($source['status']); ?>

                                        </span>
                                    </div>
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Entradas</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($source['entries']); ?></p>
                                        </div>
                                        <div class="rounded-lg bg-[#fbfaf9] px-3 py-2">
                                            <p class="text-[11px] font-semibold uppercase text-[#667085]">Itens</p>
                                            <p class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($source['items']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </article>
                </div>
            </section>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/reports/index.blade.php ENDPATH**/ ?>