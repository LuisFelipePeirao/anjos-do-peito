<?php
    $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    $labelClass = 'text-sm font-semibold text-[#344054]';
    $address = $beneficiaria?->endereco;
    $cep = $address?->cep;
?>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-user-round'); ?>
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
<?php endif; ?></span><div><h3 class="text-lg font-bold text-[#111827]">Dados pessoais</h3><p class="mt-1 text-sm text-[#667085]">Identificação principal da mãe atendida.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'nome','label' => 'Nome completo','value' => old('nome', $beneficiaria?->nome),'placeholder' => 'Ex.: Maria da Silva','wrapperClass' => 'xl:col-span-2','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'nome','label' => 'Nome completo','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('nome', $beneficiaria?->nome)),'placeholder' => 'Ex.: Maria da Silva','wrapper-class' => 'xl:col-span-2','required' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'cpf','label' => 'CPF','value' => old('cpf', $beneficiaria?->cpf),'placeholder' => '000.000.000-00','inputmode' => 'numeric','dataMask' => 'cpf','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cpf','label' => 'CPF','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('cpf', $beneficiaria?->cpf)),'placeholder' => '000.000.000-00','inputmode' => 'numeric','data-mask' => 'cpf','required' => true]); ?>
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

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#1769aa]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-phone'); ?>
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
<?php endif; ?></span><div><h3 class="text-lg font-bold text-[#111827]">Contato e origem</h3><p class="mt-1 text-sm text-[#667085]">Canais de retorno e como a beneficiária chegou à ONG.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'tel','name' => 'telefone','label' => 'Telefone principal','value' => old('telefone', $beneficiaria?->telefone),'placeholder' => '(00) 00000-0000','inputmode' => 'numeric','dataMask' => 'phone','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'tel','name' => 'telefone','label' => 'Telefone principal','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('telefone', $beneficiaria?->telefone)),'placeholder' => '(00) 00000-0000','inputmode' => 'numeric','data-mask' => 'phone','required' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'tel','name' => 'telefone_alternativo','label' => 'Telefone alternativo','value' => old('telefone_alternativo', $beneficiaria?->telefone_alternativo),'placeholder' => '(00) 00000-0000','inputmode' => 'numeric','dataMask' => 'phone']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'tel','name' => 'telefone_alternativo','label' => 'Telefone alternativo','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('telefone_alternativo', $beneficiaria?->telefone_alternativo)),'placeholder' => '(00) 00000-0000','inputmode' => 'numeric','data-mask' => 'phone']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['type' => 'email','name' => 'email','label' => 'E-mail','value' => old('email', $beneficiaria?->email),'placeholder' => 'nome@email.com','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','name' => 'email','label' => 'E-mail','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email', $beneficiaria?->email)),'placeholder' => 'nome@email.com','required' => true]); ?>
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
        <div><?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'origem_cadastro','label' => 'Origem do cadastro','options' => $origins,'selected' => old('origem_cadastro', $beneficiaria?->origem_cadastro),'placeholder' => 'Selecione','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'origem_cadastro','label' => 'Origem do cadastro','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($origins),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('origem_cadastro', $beneficiaria?->origem_cadastro)),'placeholder' => 'Selecione','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?><?php $__errorArgs = ['origem_cadastro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#197a4b]"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?></span><div><h3 class="text-lg font-bold text-[#111827]">Endereço</h3><p class="mt-1 text-sm text-[#667085]">Opcional. Informe CEP, cidade e UF ao preencher o endereço.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-6">
        <div class="xl:col-span-2"><?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'cep','label' => 'CEP','value' => old('cep', $cep ? str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT) : ''),'placeholder' => '00000-000','inputmode' => 'numeric','dataMask' => 'cep','dataCepInput' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cep','label' => 'CEP','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('cep', $cep ? str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT) : '')),'placeholder' => '00000-000','inputmode' => 'numeric','data-mask' => 'cep','data-cep-input' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $attributes = $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__attributesOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c)): ?>
<?php $component = $__componentOriginal0828db3dbbb57d858e3168c09f26a02c; ?>
<?php unset($__componentOriginal0828db3dbbb57d858e3168c09f26a02c); ?>
<?php endif; ?><span data-cep-feedback class="mt-1 block text-xs text-[#667085]"></span></div>
        <?php if (isset($component)) { $__componentOriginal0828db3dbbb57d858e3168c09f26a02c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0828db3dbbb57d858e3168c09f26a02c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'logradouro','label' => 'Rua','value' => old('logradouro', $cep?->logradouro),'placeholder' => 'Ex.: Rua das Palmeiras','wrapperClass' => 'xl:col-span-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'logradouro','label' => 'Rua','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('logradouro', $cep?->logradouro)),'placeholder' => 'Ex.: Rua das Palmeiras','wrapper-class' => 'xl:col-span-3']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'numero','label' => 'Número','value' => old('numero', $address?->numero),'placeholder' => '245']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'numero','label' => 'Número','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('numero', $address?->numero)),'placeholder' => '245']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'complemento','label' => 'Complemento','value' => old('complemento', $address?->complemento),'placeholder' => 'Casa, bloco, ponto de referência','wrapperClass' => 'md:col-span-2 xl:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'complemento','label' => 'Complemento','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('complemento', $address?->complemento)),'placeholder' => 'Casa, bloco, ponto de referência','wrapper-class' => 'md:col-span-2 xl:col-span-2']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'bairro','label' => 'Bairro','value' => old('bairro', $cep?->bairro),'placeholder' => 'Centro','wrapperClass' => 'xl:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bairro','label' => 'Bairro','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('bairro', $cep?->bairro)),'placeholder' => 'Centro','wrapper-class' => 'xl:col-span-2']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-input','data' => ['name' => 'cidade','label' => 'Cidade','value' => old('cidade', $cep?->cidade),'placeholder' => 'Cidade','wrapperClass' => 'xl:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cidade','label' => 'Cidade','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('cidade', $cep?->cidade)),'placeholder' => 'Cidade','wrapper-class' => 'xl:col-span-2']); ?>
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
        <div><?php if (isset($component)) { $__componentOriginal4e8d29c6ff2019e1db41aee682911179 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e8d29c6ff2019e1db41aee682911179 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.select','data' => ['name' => 'uf','label' => 'UF','options' => $states,'selected' => old('uf', $cep?->uf),'placeholder' => 'Selecione']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'uf','label' => 'UF','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($states),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('uf', $cep?->uf)),'placeholder' => 'Selecione']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $attributes = $__attributesOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__attributesOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e8d29c6ff2019e1db41aee682911179)): ?>
<?php $component = $__componentOriginal4e8d29c6ff2019e1db41aee682911179; ?>
<?php unset($__componentOriginal4e8d29c6ff2019e1db41aee682911179); ?>
<?php endif; ?><?php $__errorArgs = ['uf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-[#b42336]"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
    </div>
</article>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/beneficiaries/partials/form.blade.php ENDPATH**/ ?>