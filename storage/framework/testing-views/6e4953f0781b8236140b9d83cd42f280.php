<?php
    $labels = [
        'entrada' => ['title' => 'Registrar entrada', 'subheading' => 'Entrada', 'description' => 'Registre materiais recebidos e atualize o estoque automaticamente.'],
        'saida' => ['title' => 'Registrar saída', 'subheading' => 'Saída', 'description' => 'Relacione materiais entregues à beneficiária e baixe estoque automaticamente.'],
        'ajuste' => ['title' => 'Registrar ajuste', 'subheading' => 'Ajuste', 'description' => 'Corrija o saldo de um material com observação obrigatória.'],
    ];
    $page = $labels[$movementType] ?? ['title' => 'Registrar movimentação', 'subheading' => 'Movimentações', 'description' => 'Escolha o tipo de movimentação antes de preencher os dados.'];
?>

<?php $__env->startSection('title', $page['title']); ?>
<?php $__env->startSection('active-menu', 'movements.index'); ?>
<?php $__env->startSection('breadcrumb', 'Movimentações'); ?>
<?php $__env->startSection('page-title', $page['title']); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
        $itemRows = collect(old('items', [['id_material' => $selectedMaterial, 'quantidade' => null]]))
            ->filter(fn ($item) => filled($item['id_material'] ?? null) || filled($item['quantidade'] ?? null))
            ->values();
        $itemRows = $itemRows->isEmpty() ? collect([['id_material' => $selectedMaterial, 'quantidade' => null]]) : $itemRows;
    ?>

    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => $page['subheading'],'title' => $page['title'],'description' => $page['description'],'firstButton' => ['label' => 'Voltar para lista', 'link' => route('movements.index'), 'icon' => 'arrow-left']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page['subheading']),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page['title']),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page['description']),'firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Voltar para lista', 'link' => route('movements.index'), 'icon' => 'arrow-left'])]); ?>
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

        <?php if(! $movementType): ?>
            <div class="grid gap-4 md:grid-cols-3">
                <?php $__currentLoopData = [
                    ['type' => 'entrada', 'title' => 'Entrada', 'description' => 'Registrar doações recebidas e somar materiais ao estoque.', 'icon' => 'card-giftcard-o'],
                    ['type' => 'saida', 'title' => 'Saída', 'description' => 'Registrar materiais entregues e baixar saldo disponível.', 'icon' => 'volunteer-activism-o'],
                    ['type' => 'ajuste', 'title' => 'Ajuste', 'description' => 'Adicionar ou subtrair saldo com justificativa obrigatória.', 'icon' => 'swap-horiz-o'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $icon = 'gmdi-'.$option['icon']; ?>
                    <a href="<?php echo e(route('movements.create', ['tipo' => $option['type']])); ?>" class="group rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)] transition hover:border-[#ef5b97] hover:bg-[#fff7f9]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
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
                        <h3 class="mt-4 text-lg font-bold text-[#111827]"><?php echo e($option['title']); ?></h3>
                        <p class="mt-2 text-sm leading-6 text-[#667085]"><?php echo e($option['description']); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <h3 class="text-lg font-bold text-[#111827]">Escolha o tipo de movimentação</h3>
                <p class="mt-2 text-sm text-[#667085]">Os campos serão adaptados conforme entrada, saída ou ajuste.</p>
            </article>
        <?php else: ?>
            <form method="POST" action="<?php echo e(route('movements.store')); ?>" class="space-y-6" data-unsaved-form>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="tipo" value="<?php echo e($movementType); ?>">

                <?php if($movementType === 'entrada'): ?>
                    <?php if (isset($component)) { $__componentOriginal1872727e6b5db523b0ea16b4d2a07013 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donations.partials.form-shell','data' => ['title' => 'Dados da entrada','description' => 'Origem, data e situação do recebimento.','icon' => 'gmdi-card-giftcard-o']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donations.partials.form-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dados da entrada','description' => 'Origem, data e situação do recebimento.','icon' => 'gmdi-card-giftcard-o']); ?>
                        <div>
                            <div class="flex items-end gap-2">
                                <div class="min-w-0 flex-1">
                                    <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'id_doador','label' => 'Doador (opcional)','options' => $donors,'selected' => old('id_doador'),'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id_doador','label' => 'Doador (opcional)','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($donors),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('id_doador')),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                                </div>
                                <button type="button" data-dialog-open="donation-donor-create-dialog" class="mb-0 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Novo doador" title="Novo doador">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-person-add-o'); ?>
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
                            <?php $__errorArgs = ['id_doador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'datetime-local','name' => 'data_hora','label' => 'Data e hora','value' => old('data_hora', now()->format('Y-m-d\TH:i')),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','name' => 'data_hora','label' => 'Data e hora','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('data_hora', now()->format('Y-m-d\TH:i'))),'required' => true]); ?>
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

                        <div>
                            <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'situacao','label' => 'Situação','options' => ['recebida' => 'Recebida'],'selected' => old('situacao', 'recebida'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'situacao','label' => 'Situação','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['recebida' => 'Recebida']),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('situacao', 'recebida')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['situacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'observacao','label' => 'Observação','value' => old('observacao'),'wrapperClass' => 'md:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'observacao','label' => 'Observação','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('observacao')),'wrapper-class' => 'md:col-span-2']); ?>
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
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $attributes = $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $component = $__componentOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>

                    <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]" data-entry-items>
                        <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-inventory-2-o'); ?>
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
                                <div>
                                    <h3 class="text-lg font-bold text-[#111827]">Itens recebidos</h3>
                                    <p class="mt-1 text-sm text-[#667085]">Adicione os materiais e quantidades desta entrada.</p>
                                </div>
                            </div>

                            <button type="button" data-add-entry-item class="inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Adicionar item" title="Adicionar item">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-add'); ?>
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

                        <div class="space-y-3 p-5" data-entry-items-list>
                            <?php $__currentLoopData = $itemRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_2.5rem]" data-entry-item-row>
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'items['.e($index).'][id_material]','label' => 'Material','options' => $materials,'selected' => $row['id_material'] ?? null,'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'items['.e($index).'][id_material]','label' => 'Material','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($materials),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['id_material'] ?? null),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                                    </div>

                                    <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'number','name' => 'items['.e($index).'][quantidade]','label' => 'Quantidade','value' => $row['quantidade'] ?? null,'min' => '1','dataEntryQuantity' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'items['.e($index).'][quantidade]','label' => 'Quantidade','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['quantidade'] ?? null),'min' => '1','data-entry-quantity' => true]); ?>
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

                                    <button type="button" data-remove-entry-item class="self-center inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#b42336] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?>
                                    </button>

                                    <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'items['.e($index).'][observacao]','label' => 'Observação do item','value' => $row['observacao'] ?? null,'wrapperClass' => 'md:col-span-3','dataEntryObservation' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'items['.e($index).'][observacao]','label' => 'Observação do item','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['observacao'] ?? null),'wrapper-class' => 'md:col-span-3','data-entry-observation' => true]); ?>
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
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <?php $__errorArgs = ['items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="block px-5 pb-5 text-sm font-medium text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </article>
                <?php elseif($movementType === 'saida'): ?>
                    <?php if (isset($component)) { $__componentOriginal1872727e6b5db523b0ea16b4d2a07013 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donations.partials.form-shell','data' => ['title' => 'Dados da saída','description' => 'Beneficiária, data e situação da entrega.','icon' => 'gmdi-volunteer-activism-o']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donations.partials.form-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dados da saída','description' => 'Beneficiária, data e situação da entrega.','icon' => 'gmdi-volunteer-activism-o']); ?>
                        <div>
                            <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'id_beneficiaria','label' => 'Beneficiária','options' => $beneficiaries,'selected' => old('id_beneficiaria'),'placeholder' => 'Selecione','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id_beneficiaria','label' => 'Beneficiária','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($beneficiaries),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('id_beneficiaria')),'placeholder' => 'Selecione','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['id_beneficiaria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'datetime-local','name' => 'data_hora','label' => 'Data e hora','value' => old('data_hora', now()->format('Y-m-d\TH:i')),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','name' => 'data_hora','label' => 'Data e hora','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('data_hora', now()->format('Y-m-d\TH:i'))),'required' => true]); ?>
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

                        <div>
                            <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'situacao','label' => 'Situação','options' => ['entregue' => 'Entregue', 'pendente' => 'Pendente'],'selected' => old('situacao', 'entregue'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'situacao','label' => 'Situação','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['entregue' => 'Entregue', 'pendente' => 'Pendente']),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('situacao', 'entregue')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['situacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'observacao','label' => 'Observação','value' => old('observacao'),'wrapperClass' => 'md:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'observacao','label' => 'Observação','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('observacao')),'wrapper-class' => 'md:col-span-2']); ?>
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
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $attributes = $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $component = $__componentOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>

                    <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]" data-distribution-items data-materials='<?php echo json_encode($materialBalances, 15, 512) ?>'>
                        <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-inventory-2-o'); ?>
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
                                <div>
                                    <h3 class="text-lg font-bold text-[#111827]">Itens entregues</h3>
                                    <p class="mt-1 text-sm text-[#667085]">Adicione os materiais e quantidades da saída.</p>
                                </div>
                            </div>

                            <button type="button" data-add-distribution-item class="inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Adicionar item" title="Adicionar item">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-add'); ?>
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

                        <div class="space-y-3 p-5" data-distribution-items-list>
                            <?php $__currentLoopData = $itemRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_10rem_2.5rem]" data-distribution-item-row>
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'items['.e($index).'][id_material]','label' => 'Material','options' => $materials,'selected' => $row['id_material'] ?? null,'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'items['.e($index).'][id_material]','label' => 'Material','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($materials),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['id_material'] ?? null),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                                    </div>

                                    <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'text','name' => 'available_'.e($index).'','label' => 'Em estoque','value' => 'Selecione material','disabled' => true,'dataAvailableDisplay' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'available_'.e($index).'','label' => 'Em estoque','value' => 'Selecione material','disabled' => true,'data-available-display' => true]); ?>
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

                                    <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'number','name' => 'items['.e($index).'][quantidade]','label' => 'Quantidade','value' => $row['quantidade'] ?? null,'min' => '1','dataDistributionQuantity' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'items['.e($index).'][quantidade]','label' => 'Quantidade','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['quantidade'] ?? null),'min' => '1','data-distribution-quantity' => true]); ?>
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

                                    <button type="button" data-remove-distribution-item class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#b42336] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?>
                                    </button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <p class="hidden px-5 pb-5 text-sm font-medium text-[#b42336]" data-stock-error></p>
                        <?php $__errorArgs = ['items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="block px-5 pb-5 text-sm font-medium text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </article>
                <?php elseif($movementType === 'ajuste'): ?>
                    <?php if (isset($component)) { $__componentOriginal1872727e6b5db523b0ea16b4d2a07013 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donations.partials.form-shell','data' => ['title' => 'Dados do ajuste','description' => 'Material, operação, quantidade e justificativa.','icon' => 'gmdi-swap-horiz-o']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donations.partials.form-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dados do ajuste','description' => 'Material, operação, quantidade e justificativa.','icon' => 'gmdi-swap-horiz-o']); ?>
                        <div>
                            <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'id_material','label' => 'Material','options' => $materials,'selected' => old('id_material', $selectedMaterial),'placeholder' => 'Selecione','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id_material','label' => 'Material','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($materials),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('id_material', $selectedMaterial)),'placeholder' => 'Selecione','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['id_material'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'operacao','label' => 'Operação','options' => ['adicionar' => 'Adicionar ao estoque', 'subtrair' => 'Subtrair do estoque'],'selected' => old('operacao', 'adicionar'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'operacao','label' => 'Operação','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['adicionar' => 'Adicionar ao estoque', 'subtrair' => 'Subtrair do estoque']),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('operacao', 'adicionar')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['operacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'number','name' => 'quantidade','label' => 'Quantidade','value' => old('quantidade'),'min' => '1','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'quantidade','label' => 'Quantidade','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('quantidade')),'min' => '1','required' => true]); ?>
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

                        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'datetime-local','name' => 'data_hora','label' => 'Data e hora','value' => old('data_hora', now()->format('Y-m-d\TH:i')),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','name' => 'data_hora','label' => 'Data e hora','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('data_hora', now()->format('Y-m-d\TH:i'))),'required' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'observacao','label' => 'Observação','value' => old('observacao'),'wrapperClass' => 'md:col-span-2','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'observacao','label' => 'Observação','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('observacao')),'wrapper-class' => 'md:col-span-2','required' => true]); ?>
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
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $attributes = $__attributesOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__attributesOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013)): ?>
<?php $component = $__componentOriginal1872727e6b5db523b0ea16b4d2a07013; ?>
<?php unset($__componentOriginal1872727e6b5db523b0ea16b4d2a07013); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal532afa5495249d654038bc1a3e1688a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal532afa5495249d654038bc1a3e1688a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donations.partials.actions','data' => ['cancelRoute' => route('movements.index'),'submitLabel' => $page['title']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donations.partials.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cancel-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('movements.index')),'submit-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page['title'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal532afa5495249d654038bc1a3e1688a1)): ?>
<?php $attributes = $__attributesOriginal532afa5495249d654038bc1a3e1688a1; ?>
<?php unset($__attributesOriginal532afa5495249d654038bc1a3e1688a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal532afa5495249d654038bc1a3e1688a1)): ?>
<?php $component = $__componentOriginal532afa5495249d654038bc1a3e1688a1; ?>
<?php unset($__componentOriginal532afa5495249d654038bc1a3e1688a1); ?>
<?php endif; ?>
            </form>

            <?php if($movementType === 'entrada'): ?>
                <?php echo $__env->make('pages.donations.partials.donor-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <?php if($movementType === 'entrada'): ?>
        <template data-entry-item-template>
            <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_2.5rem]" data-entry-item-row>
                <div>
                    <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'items[__INDEX__][id_material]','label' => 'Material','options' => $materials,'selected' => null,'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'items[__INDEX__][id_material]','label' => 'Material','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($materials),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                </div>

                <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'number','name' => 'items[__INDEX__][quantidade]','label' => 'Quantidade','min' => '1','dataEntryQuantity' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'items[__INDEX__][quantidade]','label' => 'Quantidade','min' => '1','data-entry-quantity' => true]); ?>
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

                <button type="button" data-remove-entry-item class="self-center inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#b42336] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?>
                </button>

                <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'items[__INDEX__][observacao]','label' => 'Observação do item','wrapperClass' => 'md:col-span-3','dataEntryObservation' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'items[__INDEX__][observacao]','label' => 'Observação do item','wrapper-class' => 'md:col-span-3','data-entry-observation' => true]); ?>
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
            </div>
        </template>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-entry-items]');
                if (! root) return;

                const list = root.querySelector('[data-entry-items-list]');
                const template = document.querySelector('[data-entry-item-template]');
                const addButton = root.querySelector('[data-add-entry-item]');
                const rows = () => Array.from(list.querySelectorAll('[data-entry-item-row]'));

                const syncNames = () => {
                    rows().forEach((row, index) => {
                        row.querySelector('md-outlined-select, select')?.setAttribute('name', `items[${index}][id_material]`);
                        row.querySelector('[data-entry-quantity]')?.setAttribute('name', `items[${index}][quantidade]`);
                        row.querySelector('[data-entry-observation]')?.setAttribute('name', `items[${index}][observacao]`);
                    });
                };

                const bindRow = (row) => {
                    row.querySelector('[data-remove-entry-item]')?.addEventListener('click', () => {
                        if (rows().length > 1) {
                            row.remove();
                        } else {
                            const select = row.querySelector('md-outlined-select, select');
                            select.value = '';
                            select.querySelector('md-select-option[selected]')?.removeAttribute('selected');
                            row.querySelector('[data-entry-quantity]').value = '';
                            row.querySelector('[data-entry-observation]').value = '';
                        }

                        syncNames();
                    });
                };

                rows().forEach(bindRow);

                addButton?.addEventListener('click', () => {
                    const row = template.content.firstElementChild.cloneNode(true);
                    list.appendChild(row);
                    bindRow(row);
                    syncNames();
                });

                root.closest('form')?.addEventListener('submit', syncNames);

                syncNames();
            });
        </script>
    <?php endif; ?>

    <?php if($movementType === 'saida'): ?>
        <template data-distribution-item-template>
            <div class="grid gap-4 rounded-[8px] border border-[#eadfe0] p-4 md:grid-cols-[minmax(0,1fr)_10rem_10rem_2.5rem]" data-distribution-item-row>
                <div>
                    <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'items[__INDEX__][id_material]','label' => 'Material','options' => $materials,'selected' => null,'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'items[__INDEX__][id_material]','label' => 'Material','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($materials),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
                </div>

                <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'text','name' => 'available___INDEX__','label' => 'Quantidade disponível','value' => 'Selecione material','disabled' => true,'dataAvailableDisplay' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'available___INDEX__','label' => 'Quantidade disponível','value' => 'Selecione material','disabled' => true,'data-available-display' => true]); ?>
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

                <label class="block">
                    <span class="<?php echo e($labelClass); ?>">Quantidade</span>
                    <input type="number" min="1" class="<?php echo e($inputClass); ?>" data-distribution-quantity>
                </label>

                <button type="button" data-remove-distribution-item class="mt-7 inline-flex h-10 w-10 items-center justify-center rounded-[8px] border border-[#e4d8d9] text-[#b42336] transition hover:bg-[#fff1f1]" aria-label="Remover item" title="Remover item">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?>
                </button>
            </div>
        </template>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-distribution-items]');
                if (! root) return;

                const list = root.querySelector('[data-distribution-items-list]');
                const template = document.querySelector('[data-distribution-item-template]');
                const addButton = root.querySelector('[data-add-distribution-item]');
                const form = root.closest('form');
                const submitButton = form?.querySelector('button[type="submit"]');
                const error = root.querySelector('[data-stock-error]');
                const materials = JSON.parse(root.dataset.materials || '{}');

                const selectValue = (select) => {
                    if (! select) return '';
                    if (select.value) return select.value;

                    return select.querySelector('md-select-option[selected]')?.getAttribute('value') || '';
                };

                const selectedLabel = (select) => select?.querySelector('md-select-option[selected] [slot="headline"]')?.textContent?.trim() || 'material selecionado';
                const formatQuantity = (amount, unit) => `${amount} ${unit}${amount === 1 || unit.endsWith('s') || unit.endsWith('(s)') ? '' : 's'}`;
                const rows = () => Array.from(list.querySelectorAll('[data-distribution-item-row]'));

                const syncNames = () => {
                    rows().forEach((row, index) => {
                        row.querySelector('md-outlined-select, select')?.setAttribute('name', `items[${index}][id_material]`);
                        row.querySelector('[data-distribution-quantity]')?.setAttribute('name', `items[${index}][quantidade]`);
                    });
                };

                const validate = () => {
                    const totals = {};
                    let message = '';

                    rows().forEach((row) => {
                        const select = row.querySelector('md-outlined-select, select');
                        const quantity = row.querySelector('[data-distribution-quantity]');
                        const materialId = selectValue(select);
                        const requested = Number(quantity?.value || 0);
                        const material = materials[materialId];

                        if (quantity) quantity.max = material?.available ?? '';
                        if (! materialId || requested <= 0) return;

                        totals[materialId] = (totals[materialId] || 0) + requested;
                        if (material && requested > material.available) {
                            message = `Quantidade maior que disponível para ${selectedLabel(select)}.`;
                        }
                    });

                    rows().forEach((row) => {
                        const select = row.querySelector('md-outlined-select, select');
                        const available = row.querySelector('[data-available-display]');
                        const materialId = selectValue(select);
                        const totalRequested = totals[materialId] || 0;
                        const material = materials[materialId];
                        const isNegative = material && totalRequested > material.available;

                        if (available) {
                            available.value = material ? formatQuantity(material.available - totalRequested, material.unit) : 'Selecione material';
                            available.classList.toggle('bg-[#fff1f1]', Boolean(isNegative));
                            available.classList.toggle('text-[#b42336]', Boolean(isNegative));
                        }
                    });

                    Object.entries(totals).forEach(([materialId, requested]) => {
                        const material = materials[materialId];
                        if (material && requested > material.available) {
                            message = `Total solicitado (${requested}) maior que disponível (${material.available}) para material repetido.`;
                        }
                    });

                    error.textContent = message;
                    error.classList.toggle('hidden', message === '');
                    if (submitButton) submitButton.disabled = message !== '';
                    if (submitButton) submitButton.classList.toggle('opacity-60', message !== '');

                    return message === '';
                };

                const bindRow = (row) => {
                    const select = row.querySelector('md-outlined-select, select');

                    select?.addEventListener('input', validate);
                    select?.addEventListener('change', validate);
                    row.querySelector('[data-distribution-quantity]')?.addEventListener('input', validate);
                    row.querySelector('[data-remove-distribution-item]')?.addEventListener('click', () => {
                        if (rows().length > 1) {
                            row.remove();
                        } else {
                            select.value = '';
                            select.querySelector('md-select-option[selected]')?.removeAttribute('selected');
                            row.querySelector('[data-distribution-quantity]').value = '';
                        }

                        syncNames();
                        validate();
                    });
                };

                rows().forEach(bindRow);

                addButton?.addEventListener('click', () => {
                    const row = template.content.firstElementChild.cloneNode(true);
                    list.appendChild(row);
                    bindRow(row);
                    syncNames();
                    validate();
                });

                form?.addEventListener('submit', (event) => {
                    syncNames();
                    if (! validate()) event.preventDefault();
                });

                syncNames();
                validate();
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/donations/distributions/create.blade.php ENDPATH**/ ?>