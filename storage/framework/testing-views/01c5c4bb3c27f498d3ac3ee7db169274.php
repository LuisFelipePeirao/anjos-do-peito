<?php $__env->startSection('title', 'Entrar'); ?>
<?php $__env->startSection('content'); ?>

    <form action="<?php echo e(route('login.store')); ?>" method="POST" class="w-72.5 md:w-80">
        <?php echo csrf_field(); ?>

        <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Seja Bem-vindo!</h1>

        <?php if (isset($component)) { $__componentOriginal9d8b80e1865eaff3036a73d7b57a8273 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.input','data' => ['label' => 'E-mail','name' => 'email','type' => 'email','value' => ''.e(old('email')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'E-mail','name' => 'email','type' => 'email','value' => ''.e(old('email')).'']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-account-circle-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273)): ?>
<?php $attributes = $__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273; ?>
<?php unset($__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d8b80e1865eaff3036a73d7b57a8273)): ?>
<?php $component = $__componentOriginal9d8b80e1865eaff3036a73d7b57a8273; ?>
<?php unset($__componentOriginal9d8b80e1865eaff3036a73d7b57a8273); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal9d8b80e1865eaff3036a73d7b57a8273 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.input','data' => ['label' => 'Senha','name' => 'senha','type' => 'password','passwordToggle' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Senha','name' => 'senha','type' => 'password','password-toggle' => true]); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gmdi-lock-o'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273)): ?>
<?php $attributes = $__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273; ?>
<?php unset($__attributesOriginal9d8b80e1865eaff3036a73d7b57a8273); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d8b80e1865eaff3036a73d7b57a8273)): ?>
<?php $component = $__componentOriginal9d8b80e1865eaff3036a73d7b57a8273; ?>
<?php unset($__componentOriginal9d8b80e1865eaff3036a73d7b57a8273); ?>
<?php endif; ?>

        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mb-4 text-sm font-medium text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php $__errorArgs = ['senha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mb-4 text-sm font-medium text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php if(session('status')): ?>
            <p class="mb-4 text-sm font-medium text-green-700"><?php echo e(session('status')); ?></p>
        <?php endif; ?>

        <a href="<?php echo e(route('password.request')); ?>"
            class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Esqueceu
            a Senha?</a>

        <?php if (isset($component)) { $__componentOriginalf701d7821eeb9bb3ab7ca9465c8ee50e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf701d7821eeb9bb3ab7ca9465c8ee50e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.login.login-button','data' => ['value' => 'Entrar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('login.login-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Entrar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf701d7821eeb9bb3ab7ca9465c8ee50e)): ?>
<?php $attributes = $__attributesOriginalf701d7821eeb9bb3ab7ca9465c8ee50e; ?>
<?php unset($__attributesOriginalf701d7821eeb9bb3ab7ca9465c8ee50e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf701d7821eeb9bb3ab7ca9465c8ee50e)): ?>
<?php $component = $__componentOriginalf701d7821eeb9bb3ab7ca9465c8ee50e; ?>
<?php unset($__componentOriginalf701d7821eeb9bb3ab7ca9465c8ee50e); ?>
<?php endif; ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main-login', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/auth/login.blade.php ENDPATH**/ ?>