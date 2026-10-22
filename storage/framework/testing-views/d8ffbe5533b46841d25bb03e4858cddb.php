<?php $__env->startSection('title', 'Registrar empréstimo'); ?>
<?php $__env->startSection('active-menu', 'pumps.index'); ?>
<?php $__env->startSection('breadcrumb', 'Bombas de leite'); ?>
<?php $__env->startSection('page-title', 'Registrar empréstimo'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $inputClass = 'mt-2 h-11 w-full rounded-lg border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-lg border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
        $hintClass = 'mt-1 text-xs text-[#667085]';
    ?>

    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Movimentação de bombas','title' => 'Registrar saída de bomba','description' => 'Escolha se a bomba será emprestada sem custo ou alugada com cobrança mensal.','firstButton' => ['label' => 'Voltar para lista', 'link' => route('pumps.index'), 'icon' => 'arrow-left']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Movimentação de bombas','title' => 'Registrar saída de bomba','description' => 'Escolha se a bomba será emprestada sem custo ou alugada com cobrança mensal.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Voltar para lista', 'link' => route('pumps.index'), 'icon' => 'arrow-left'])]); ?>
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

        <form method="POST" action="<?php echo e(route('pumps.loans.store')); ?>" class="space-y-6" data-unsaved-form>
            <?php echo csrf_field(); ?>

            <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#fdecef] text-[#ef5b97]">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-handshake'); ?>
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
                            <h3 class="text-lg font-bold text-[#111827]">Tipo de contrato</h3>
                            <p class="mt-1 text-sm text-[#667085]">Defina se haverá cobrança mensal ou se a saída será gratuita.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 p-5 md:grid-cols-2">
                    <label class="flex h-full cursor-pointer flex-col rounded-lg border border-[#eadfe0] bg-white p-4 transition has-[:checked]:border-[#ef5b97] has-[:checked]:bg-[#fff7f9]">
                        <span class="flex items-start gap-3">
                            <input type="radio" name="contract_type" value="emprestimo" class="mt-1 h-4 w-4 border-[#d0d5dd] text-[#ef5b97] focus:ring-[#ef5b97]" data-pump-contract-type <?php if(old('contract_type', 'emprestimo') === 'emprestimo'): echo 'checked'; endif; ?>>
                            <span>
                                <span class="block text-base font-bold text-[#111827]">Empréstimo</span>
                                <span class="mt-1 block text-sm leading-6 text-[#667085]">Saída sem cobrança mensal, usada quando a ONG apenas empresta a bomba para a beneficiária.</span>
                            </span>
                        </span>
                        <span class="mt-4 inline-flex w-fit rounded-full bg-[#e8f8ee] px-2.5 py-1 text-xs font-semibold text-[#197a4b]">Sem custo</span>
                    </label>

                    <label class="flex h-full cursor-pointer flex-col rounded-lg border border-[#eadfe0] bg-white p-4 transition has-[:checked]:border-[#ef5b97] has-[:checked]:bg-[#fff7f9]">
                        <span class="flex items-start gap-3">
                            <input type="radio" name="contract_type" value="aluguel" class="mt-1 h-4 w-4 border-[#d0d5dd] text-[#ef5b97] focus:ring-[#ef5b97]" data-pump-contract-type <?php if(old('contract_type') === 'aluguel'): echo 'checked'; endif; ?>>
                            <span>
                                <span class="block text-base font-bold text-[#111827]">Aluguel</span>
                                <span class="mt-1 block text-sm leading-6 text-[#667085]">Saída com mensalidade definida, vencimento recorrente e controle de pagamento.</span>
                            </span>
                        </span>
                        <span class="mt-4 inline-flex w-fit rounded-full bg-[#eef4ff] px-2.5 py-1 text-xs font-semibold text-[#1769aa]">Com mensalidade</span>
                    </label>
                </div>
                <?php $__errorArgs = ['contract_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="px-5 pb-5 text-xs text-[#b42336]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </article>

            <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#eef4ff] text-[#1769aa]">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-milk'); ?>
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
                            <h3 class="text-lg font-bold text-[#111827]">Bomba e beneficiária</h3>
                            <p class="mt-1 text-sm text-[#667085]">Selecione o equipamento disponível e a pessoa responsável pelo empréstimo.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
                    <div>
                        <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'pump','label' => 'Bomba disponível','options' => collect($availablePumps)->map(fn ($pump) => ['value' => $pump['id'], 'label' => $pump['code'].' - '.$pump['model']])->all(),'selected' => old('pump'),'placeholder' => 'Selecione','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pump','label' => 'Bomba disponível','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(collect($availablePumps)->map(fn ($pump) => ['value' => $pump['id'], 'label' => $pump['code'].' - '.$pump['model']])->all()),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('pump')),'placeholder' => 'Selecione','required' => true]); ?>
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
                        <?php $__errorArgs = ['pump'];
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'beneficiary','label' => 'Beneficiária','options' => $beneficiaries,'selected' => old('beneficiary'),'placeholder' => 'Selecione','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'beneficiary','label' => 'Beneficiária','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($beneficiaries),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('beneficiary')),'placeholder' => 'Selecione','required' => true]); ?>
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
                        <?php $__errorArgs = ['beneficiary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </article>

            <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#ecfdf3] text-[#197a4b]">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-calendar-days'); ?>
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
                            <h3 class="text-lg font-bold text-[#111827]">Prazo e retirada</h3>
                            <p class="mt-1 text-sm text-[#667085]">Datas de retirada e previsão de devolução.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'date','name' => 'withdrawn_at','label' => 'Data de retirada','value' => old('withdrawn_at', now()->toDateString()),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'withdrawn_at','label' => 'Data de retirada','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('withdrawn_at', now()->toDateString())),'required' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'date','name' => 'expected_return','label' => 'Devolução prevista','value' => old('expected_return', now()->addDays(30)->toDateString()),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'expected_return','label' => 'Devolução prevista','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('expected_return', now()->addDays(30)->toDateString())),'required' => true]); ?>
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
            </article>

            <article class="hidden overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]" data-pump-billing-section>
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#fff7e6] text-[#8a4b00]">
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
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Dados do aluguel</h3>
                            <p class="mt-1 text-sm text-[#667085]">A primeira parcela será registrada agora; as próximas serão geradas automaticamente para controle interno.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'monthly_fee','label' => 'Mensalidade','value' => old('monthly_fee'),'placeholder' => 'R$ 0,00','inputmode' => 'numeric','dataMask' => 'currency-brl','dataPumpBillingField' => true,'disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'monthly_fee','label' => 'Mensalidade','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('monthly_fee')),'placeholder' => 'R$ 0,00','inputmode' => 'numeric','data-mask' => 'currency-brl','data-pump-billing-field' => true,'disabled' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'number','name' => 'due_day','label' => 'Dia de vencimento','value' => old('due_day'),'placeholder' => 'Ex.: 10','min' => '1','max' => '31','dataPumpBillingField' => true,'disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'due_day','label' => 'Dia de vencimento','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('due_day')),'placeholder' => 'Ex.: 10','min' => '1','max' => '31','data-pump-billing-field' => true,'disabled' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'billing_method','label' => 'Forma de cobrança','options' => $billingMethods,'selected' => old('billing_method'),'placeholder' => 'Selecione','dataPumpBillingField' => true,'disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'billing_method','label' => 'Forma de cobrança','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($billingMethods),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('billing_method')),'placeholder' => 'Selecione','data-pump-billing-field' => true,'disabled' => true]); ?>
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
                        <?php $__errorArgs = ['billing_method'];
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'date','name' => 'first_billing_at','label' => 'Primeira cobrança','value' => old('first_billing_at'),'dataPumpBillingField' => true,'disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'first_billing_at','label' => 'Primeira cobrança','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('first_billing_at')),'data-pump-billing-field' => true,'disabled' => true]); ?>
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

                    <div class="md:col-span-2 xl:col-span-4">
                        <?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'billing_notes','label' => 'Observações financeiras','value' => old('billing_notes'),'placeholder' => 'Registre combinações de pagamento, isenção parcial, atraso negociado ou orientação administrativa.','dataPumpBillingField' => true,'disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'billing_notes','label' => 'Observações financeiras','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('billing_notes')),'placeholder' => 'Registre combinações de pagamento, isenção parcial, atraso negociado ou orientação administrativa.','data-pump-billing-field' => true,'disabled' => true]); ?>
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
                        <span class="<?php echo e($hintClass); ?>">A equipe registrará baixas e cancelamentos internamente. Para remover o custo, selecione "Empréstimo".</span>
                    </div>
                </div>
            </article>

            <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#fdecef] text-[#ef5b97]">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-check-2'); ?>
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
                            <h3 class="text-lg font-bold text-[#111827]">Termos e entrega</h3>
                            <p class="mt-1 text-sm text-[#667085]">Confirmações importantes para segurança da beneficiária e controle da ONG.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <div>
                        <?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'term_signed','label' => 'Gerar termo para assinatura?','options' => [1 => 'Sim', 0 => 'Não'],'selected' => old('term_signed', 1)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'term_signed','label' => 'Gerar termo para assinatura?','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([1 => 'Sim', 0 => 'Não']),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('term_signed', 1))]); ?>
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
                        <?php $__errorArgs = ['term_signed'];
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'notes','label' => 'Observações do contrato','value' => old('notes'),'placeholder' => 'Registre cuidados combinados, restrições, contatos alternativos ou orientações para acompanhamento.','wrapperClass' => 'md:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notes','label' => 'Observações do contrato','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('notes')),'placeholder' => 'Registre cuidados combinados, restrições, contatos alternativos ou orientações para acompanhamento.','wrapper-class' => 'md:col-span-2']); ?>
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
            </article>

            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8">
                <div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="<?php echo e(route('pumps.index')); ?>" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c73570] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a62d5b]">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?>
                        Registrar saída
                    </button>
                </div>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/pumps/loans/create.blade.php ENDPATH**/ ?>