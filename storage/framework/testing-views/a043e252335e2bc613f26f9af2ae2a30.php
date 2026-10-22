<?php $__env->startSection('title', $summary['title']); ?>
<?php $__env->startSection('active-menu', 'movements.index'); ?>
<?php $__env->startSection('breadcrumb', 'Movimentações'); ?>
<?php $__env->startSection('page-title', $summary['title']); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">Detalhes da movimentação</h2>
                <p class="mt-1 text-sm text-[#667085]">Informações do lançamento, material e responsável.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="<?php echo e(route('movements.index')); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
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
                <a href="<?php echo e(route('movements.create')); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c73570] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-add'); ?>
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
                <?php if($canResolvePending): ?>
                    <form method="POST" action="<?php echo e(route('movements.confirm', $movement)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-[#23845a] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1b6a48] sm:w-auto">Dar baixa</button>
                    </form>
                    <form method="POST" action="<?php echo e(route('movements.cancel', $movement)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-lg border border-[#f2c7cf] bg-white px-4 text-sm font-semibold text-[#b42336] shadow-sm transition hover:bg-[#fff1f1] sm:w-auto">Cancelar</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Tipo</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($summary['type']); ?></dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Data e hora</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($summary['date']); ?></dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Origem ou destino</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($summary['origin']); ?></dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Responsável</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($summary['responsible']); ?></dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Situação</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($summary['status']); ?></dd>
                </div>
                <div class="md:col-span-2 xl:col-span-4">
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Observação</dt>
                    <dd class="mt-1 text-sm text-[#344054]"><?php echo e($summary['observation']); ?></dd>
                </div>
                <?php if(filled($distributionObservation)): ?>
                    <div class="md:col-span-2 xl:col-span-4">
                        <dt class="text-xs font-semibold uppercase text-[#667085]">Observação da distribuição</dt>
                        <dd class="mt-1 text-sm text-[#344054]"><?php echo e($distributionObservation); ?></dd>
                    </div>
                <?php endif; ?>
            </div>
        </article>

        <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => ['Material', 'Categoria', 'Quantidade', 'Tipo'],'data' => $items,'showActions' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Material', 'Categoria', 'Quantidade', 'Tipo']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($items),'show-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/movements/show.blade.php ENDPATH**/ ?>