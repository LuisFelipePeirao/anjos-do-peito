<?php $__env->startSection('title', 'Continuar atendimento'); ?>
<?php $__env->startSection('active-menu', 'attendances.index'); ?>
<?php $__env->startSection('breadcrumb', 'Atendimentos'); ?>
<?php $__env->startSection('page-title', 'Continuar atendimento'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    ?>

    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Gestão de atendimentos','title' => 'Continuar atendimento','description' => 'Complete o registro clínico deste atendimento em andamento.','firstButton' => ['label' => 'Voltar aos detalhes', 'link' => route('attendances.show', $attendance), 'icon' => 'arrow-left']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Gestão de atendimentos','title' => 'Continuar atendimento','description' => 'Complete o registro clínico deste atendimento em andamento.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Voltar aos detalhes', 'link' => route('attendances.show', $attendance), 'icon' => 'arrow-left'])]); ?>
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

        <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <h3 class="text-lg font-bold text-[#111827]">Informações do atendimento</h3>
            <dl class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                <?php $__currentLoopData = [
                    'Beneficiária' => $attendanceData['beneficiary_name'], 'Criança' => $attendanceData['child_name'], 'Profissional' => $attendanceData['professional_name'],
                    'Data e horário' => $attendanceData['formatted_date'].' às '.$attendanceData['time'], 'Duração' => $attendanceData['duration_label'], 'Modalidade' => $attendanceData['modality_label'], 'Local' => $attendanceData['location_name'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]"><?php echo e($label); ?></dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($value); ?></dd></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </dl>
        </article>

        <form method="POST" action="<?php echo e(route('attendances.continue.save', $attendance)); ?>" class="space-y-6" data-attendance-continuation-form data-unsaved-form>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="confirmed_finalization" value="0" data-attendance-finalization-confirmation>
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-list-checks'); ?>
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
<?php endif; ?></span><div><h3 class="text-lg font-bold text-[#111827]">Classificação do atendimento</h3><p class="mt-1 text-sm text-[#667085]">Informe a categoria e procedimento realizado.</p></div></div></div>
                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <div><?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'attendance_category','label' => 'Categoria','options' => $attendanceCategories,'selected' => old('attendance_category', $attendanceData['attendance_category']),'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'attendance_category','label' => 'Categoria','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attendanceCategories),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('attendance_category', $attendanceData['attendance_category'])),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?><?php $__errorArgs = ['attendance_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    <div><?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'procedure','label' => 'Procedimento','options' => $procedures,'selected' => old('procedure', $attendanceData['procedure']),'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'procedure','label' => 'Procedimento','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($procedures),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('procedure', $attendanceData['procedure'])),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?><?php $__errorArgs = ['procedure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>
            </article>
            <?php echo $__env->make('pages.attendances.partials.clinical-fields', ['attendanceData' => $attendanceData, 'textareaClass' => $textareaClass, 'inputClass' => $inputClass], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8"><div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="<?php echo e(route('attendances.show', $attendance)); ?>" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">Cancelar</a>
                <button type="submit" name="save_as" value="draft" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-5 text-sm font-semibold text-[#344054] shadow-sm transition hover:bg-[#fbf1f3]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-pen-line'); ?>
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
<?php endif; ?> Salvar rascunho</button>
                <button type="submit" name="save_as" value="final" data-attendance-final-submit class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#c73570] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-save'); ?>
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
<?php endif; ?> Salvar atendimento</button>
            </div></div>
        </form>

        <?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => 'attendance-finalize-confirmation','title' => 'Finalizar atendimento?','message' => 'Após salvar, as informações deste atendimento realizado não poderão mais ser editadas.','confirmLabel' => 'Finalizar atendimento','cancelLabel' => 'Continuar editando','variant' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance-finalize-confirmation','title' => 'Finalizar atendimento?','message' => 'Após salvar, as informações deste atendimento realizado não poderão mais ser editadas.','confirm-label' => 'Finalizar atendimento','cancel-label' => 'Continuar editando','variant' => 'warning']); ?>
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
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/attendances/continue.blade.php ENDPATH**/ ?>