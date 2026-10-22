<?php $__env->startSection('title', $beneficiaria->nome); ?>
<?php $__env->startSection('active-menu', 'beneficiaries.index'); ?>
<?php $__env->startSection('breadcrumb', 'Beneficiárias'); ?>
<?php $__env->startSection('page-title', $beneficiaria->nome); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $isActive = $beneficiaria->situacao === 'ativo';
        $initials = collect(explode(' ', $beneficiaria->nome))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->join('');
        $address = $beneficiaria->endereco;
        $cep = $address?->cep;
        $addressLine = $cep ? collect([$cep->logradouro, $address->numero, $cep->bairro, $cep->cidade . '/' . $cep->uf])->filter()->join(', ') : 'Não informado';
        $tabs = [
            'overview' => 'Visão geral',
            'attendances' => 'Atendimentos',
            'pumps' => 'Bombas',
            'donations' => 'Doações',
            'history' => 'Histórico',
            'babies' => 'Bebês',
        ];
    ?>

    <section class="space-y-6">
        <?php if(session('status')): ?>
            <div class="rounded-[8px] border border-[#b8e6c8] bg-[#effcf4] px-4 py-3 text-sm font-medium text-[#197a4b]"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div><h2 class="text-2xl font-bold text-[#111827] md:text-3xl"><?php echo e($beneficiaria->nome); ?></h2><p class="mt-1 text-sm text-[#667085]">Todas as informações da beneficiária reunidas em um único perfil.</p></div>
            <div class="flex flex-wrap gap-3 lg:justify-end">
                <a href="<?php echo e(route('beneficiaries.edit', $beneficiaria)); ?>" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?> Editar cadastro</a>
                <?php if($isActive): ?>
                    <button type="button" data-confirm-dialog-open="beneficiary-deactivate" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c2414b] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a93640]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-ban'); ?>
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
<?php endif; ?> Inativar beneficiária</button>
                <?php endif; ?>
            </div>
        </div>

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-xl font-bold text-[#8f4050]"><?php echo e($initials); ?></div><div><div class="flex flex-wrap items-center gap-3"><h3 class="text-xl font-bold text-[#111827]"><?php echo e($beneficiaria->nome); ?></h3><span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($isActive ? 'bg-[#dff7e8] text-[#197a4b]' : 'bg-[#fff1f1] text-[#b42336]'); ?>"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?> <?php echo e($isActive ? 'Ativa' : 'Inativa'); ?></span></div></div></div>
                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">CPF</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e(preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $beneficiaria->cpf)); ?></dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Telefone</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($beneficiaria->telefone); ?></dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">E-mail</dt><dd class="mt-1 break-all text-sm font-semibold text-[#111827]"><?php echo e($beneficiaria->email); ?></dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Telefone alternativo</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($beneficiaria->telefone_alternativo ?: '-'); ?></dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Origem do cadastro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e(str($beneficiaria->origem_cadastro)->replace('_', ' ')->title()); ?></dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Data de cadastro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($beneficiaria->created_at->format('d/m/Y')); ?></dd></div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('beneficiaries.show', ['beneficiaria' => $beneficiaria, 'tab' => $key])); ?>" class="shrink-0 border-b-2 px-1 py-4 text-sm font-medium transition <?php echo e($tab === $key ? 'border-[#a62d5b] text-[#a62d5b]' : 'border-transparent text-[#4b5563] hover:text-[#a62d5b]'); ?>"><?php echo e($label); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </nav>

        <?php if($tab === 'overview'): ?>
        <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]"><div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#197a4b]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-map-pin'); ?>
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
<?php endif; ?></span><div><h3 class="text-lg font-bold text-[#111827]">Endereço</h3><p class="mt-1 text-sm text-[#667085]"><?php echo e($addressLine); ?></p></div></div></div><?php if($cep): ?><dl class="grid gap-5 p-5 sm:grid-cols-2 xl:grid-cols-4"><div><dt class="text-xs font-semibold uppercase text-[#667085]">CEP</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e(substr(str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT), 0, 5) . '-' . substr(str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT), 5)); ?></dd></div><div><dt class="text-xs font-semibold uppercase text-[#667085]">Logradouro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($cep->logradouro ?: '-'); ?></dd></div><div><dt class="text-xs font-semibold uppercase text-[#667085]">Bairro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($cep->bairro ?: '-'); ?></dd></div><div><dt class="text-xs font-semibold uppercase text-[#667085]">Complemento</dt><dd class="mt-1 text-sm font-semibold text-[#111827]"><?php echo e($address->complemento ?: '-'); ?></dd></div></dl><?php endif; ?></article>

        <?php endif; ?>

        <?php if($tab === 'babies'): ?>
        <article id="bebes" class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-center sm:justify-between"><div><h3 class="text-lg font-bold text-[#111827]">Bebês</h3><p class="mt-1 text-sm text-[#667085]">Crianças vinculadas a esta beneficiária.</p></div><button type="button" data-dialog-open="child-create-dialog" class="inline-flex h-10 items-center justify-center gap-2 rounded-[8px] bg-[#c73570] px-4 text-sm font-semibold text-white transition hover:bg-[#a62d5b]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?> Cadastrar bebê</button></div>
            <div class="overflow-x-auto"><table class="w-full min-w-150 text-left text-sm"><thead class="border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase tracking-wide text-[#667085]"><tr><th class="px-5 py-4 font-semibold">Nome</th><th class="px-5 py-4 font-semibold">Data de nascimento</th><th class="px-5 py-4 font-semibold">Sexo</th><th class="px-5 py-4 text-right font-semibold">Ações</th></tr></thead><tbody class="divide-y divide-[#f0e7e8]"><?php $__empty_1 = true; $__currentLoopData = $beneficiaria->criancas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crianca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr class="transition hover:bg-[#fff7f9]"><th class="px-5 py-4 font-semibold text-[#111827]"><?php echo e($crianca->nome); ?></th><td class="px-5 py-4 text-[#344054]"><?php echo e($crianca->data_nascimento->format('d/m/Y')); ?></td><td class="px-5 py-4 text-[#344054]"><?php echo e($sexOptions[$crianca->sexo]); ?></td><td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="<?php echo e(route('beneficiaries.show', ['beneficiaria' => $beneficiaria, 'tab' => 'babies', 'editar_crianca' => $crianca->id])); ?>#bebes" title="Editar bebê" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-edit-o'); ?>
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
<?php endif; ?></a><button type="button" data-confirm-dialog-open="child-delete-<?php echo e($crianca->id); ?>" title="Excluir bebê" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#b42336] transition hover:bg-[#fff1f1]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-delete-o'); ?>
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
<?php endif; ?></button></div><?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => 'child-delete-' . $crianca->id,'title' => 'Excluir bebê?','message' => 'O vínculo desta criança será removido. Deseja continuar?','confirmLabel' => 'Excluir bebê','action' => route('beneficiaries.children.destroy', [$beneficiaria, $crianca]),'method' => 'DELETE']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('child-delete-' . $crianca->id),'title' => 'Excluir bebê?','message' => 'O vínculo desta criança será removido. Deseja continuar?','confirm-label' => 'Excluir bebê','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('beneficiaries.children.destroy', [$beneficiaria, $crianca])),'method' => 'DELETE']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56125bb6dacfcebb197de13a56b0d464)): ?>
<?php $attributes = $__attributesOriginal56125bb6dacfcebb197de13a56b0d464; ?>
<?php unset($__attributesOriginal56125bb6dacfcebb197de13a56b0d464); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56125bb6dacfcebb197de13a56b0d464)): ?>
<?php $component = $__componentOriginal56125bb6dacfcebb197de13a56b0d464; ?>
<?php unset($__componentOriginal56125bb6dacfcebb197de13a56b0d464); ?>
<?php endif; ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4" class="px-5 py-12 text-center text-sm text-[#667085]">Nenhum bebê vinculado a esta beneficiária.</td></tr><?php endif; ?></tbody></table></div>
        </article>
        <?php endif; ?>

        <?php if(in_array($tab, ['attendances', 'pumps', 'donations'], true)): ?>
            <?php
                $sectionNames = ['attendances' => 'Atendimentos', 'pumps' => 'Bombas', 'donations' => 'Doações'];
            ?>
            <article class="rounded-[8px] border border-[#eadfe0] bg-white p-10 text-center shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-inbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mx-auto h-8 w-8 text-[#98a2b3]']); ?>
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
                <h3 class="mt-3 text-lg font-bold text-[#111827]">Nenhum registro de <?php echo e(mb_strtolower($sectionNames[$tab])); ?></h3>
                <p class="mt-1 text-sm text-[#667085]">Os registros vinculados a esta beneficiária aparecerão nesta aba.</p>
            </article>
        <?php elseif($tab === 'history'): ?>
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5"><h3 class="text-lg font-bold text-[#111827]">Histórico da beneficiária</h3><p class="mt-1 text-sm text-[#667085]">Movimentações e registros relacionados ao cadastro.</p></div>
                <div class="p-5"><div class="flex gap-3"><div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-[#f0dadd] bg-white text-[#a62d5b]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-user-plus'); ?>
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
<?php endif; ?></div><div><p class="text-xs font-semibold text-[#667085]"><?php echo e($beneficiaria->created_at->format('d/m/Y')); ?></p><p class="mt-1 text-sm font-bold text-[#111827]">Cadastro realizado</p><p class="mt-1 text-sm text-[#667085]">Beneficiária cadastrada no sistema da ONG.</p></div></div></div>
            </article>
        <?php endif; ?>
    </section>

    <?php echo $__env->make('pages.beneficiaries.partials.child-modal', ['id' => 'child-create-dialog', 'title' => 'Cadastrar bebê', 'action' => route('beneficiaries.children.store', $beneficiaria), 'child' => null, 'method' => 'POST'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if($childToEdit): ?>
        <?php echo $__env->make('pages.beneficiaries.partials.child-modal', ['id' => 'child-edit-dialog', 'title' => 'Editar bebê', 'action' => route('beneficiaries.children.update', [$beneficiaria, $childToEdit]), 'child' => $childToEdit, 'method' => 'PUT'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
    <?php if($isActive): ?><?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => 'beneficiary-deactivate','title' => 'Inativar beneficiária?','message' => 'O cadastro e seus vínculos serão preservados, mas ela deixará de constar como ativa. Deseja continuar?','confirmLabel' => 'Inativar beneficiária','action' => route('beneficiaries.deactivate', $beneficiaria),'method' => 'PATCH']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'beneficiary-deactivate','title' => 'Inativar beneficiária?','message' => 'O cadastro e seus vínculos serão preservados, mas ela deixará de constar como ativa. Deseja continuar?','confirm-label' => 'Inativar beneficiária','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('beneficiaries.deactivate', $beneficiaria)),'method' => 'PATCH']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56125bb6dacfcebb197de13a56b0d464)): ?>
<?php $attributes = $__attributesOriginal56125bb6dacfcebb197de13a56b0d464; ?>
<?php unset($__attributesOriginal56125bb6dacfcebb197de13a56b0d464); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56125bb6dacfcebb197de13a56b0d464)): ?>
<?php $component = $__componentOriginal56125bb6dacfcebb197de13a56b0d464; ?>
<?php unset($__componentOriginal56125bb6dacfcebb197de13a56b0d464); ?>
<?php endif; ?><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php if($childToEdit || $errors->hasAny(['nome', 'data_nascimento', 'sexo'])): ?>
        <script>document.addEventListener('DOMContentLoaded', () => document.getElementById(<?php echo json_encode($childToEdit ? 'child-edit-dialog' : 'child-create-dialog', 15, 512) ?>)?.showModal());</script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/beneficiaries/show.blade.php ENDPATH**/ ?>