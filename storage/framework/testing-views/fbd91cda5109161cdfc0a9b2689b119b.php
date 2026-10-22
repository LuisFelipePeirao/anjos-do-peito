<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/favicon_VITA.png')); ?>">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <script type="module" src="https://cdn.jsdelivr.net/gh/datvm/material-web@v2.3.0/dist/bundle.esm.min.js"></script>


    <script type="importmap">
    {
        "imports": {
        "@material/web/": "https://esm.run"
        }
    }
    </script>
    <script type="module">
    import '@material/web/all.js';
    </script>


    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body>
    <div id="app-shell" class="app-shell min-h-screen bg-[#fbfaf9]" data-sidebar-collapsed="false" data-mobile-sidebar-open="false">
        <?php if (isset($component)) { $__componentOriginal790df3a3003b05a46d3e5fdd59aeab47 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal790df3a3003b05a46d3e5fdd59aeab47 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.sidebar','data' => ['active' => trim($__env->yieldContent('active-menu')) ?: null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trim($__env->yieldContent('active-menu')) ?: null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal790df3a3003b05a46d3e5fdd59aeab47)): ?>
<?php $attributes = $__attributesOriginal790df3a3003b05a46d3e5fdd59aeab47; ?>
<?php unset($__attributesOriginal790df3a3003b05a46d3e5fdd59aeab47); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal790df3a3003b05a46d3e5fdd59aeab47)): ?>
<?php $component = $__componentOriginal790df3a3003b05a46d3e5fdd59aeab47; ?>
<?php unset($__componentOriginal790df3a3003b05a46d3e5fdd59aeab47); ?>
<?php endif; ?>

        <div class="fixed inset-0 z-30 hidden bg-[#111827]/35 md:hidden" data-sidebar-overlay></div>

        <main class="app-main min-h-screen transition-[margin] duration-300 ease-out">
            <?php if (isset($component)) { $__componentOriginal0f1e1c18620a01537b7924e43a775a2a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f1e1c18620a01537b7924e43a775a2a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.navbar','data' => ['breadcrumb' => trim($__env->yieldContent('breadcrumb')) ?: 'Início','title' => trim($__env->yieldContent('page-title')) ?: 'Visão geral']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['breadcrumb' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trim($__env->yieldContent('breadcrumb')) ?: 'Início'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trim($__env->yieldContent('page-title')) ?: 'Visão geral')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f1e1c18620a01537b7924e43a775a2a)): ?>
<?php $attributes = $__attributesOriginal0f1e1c18620a01537b7924e43a775a2a; ?>
<?php unset($__attributesOriginal0f1e1c18620a01537b7924e43a775a2a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f1e1c18620a01537b7924e43a775a2a)): ?>
<?php $component = $__componentOriginal0f1e1c18620a01537b7924e43a775a2a; ?>
<?php unset($__componentOriginal0f1e1c18620a01537b7924e43a775a2a); ?>
<?php endif; ?>

            <div class="mx-auto w-full max-w-6xl px-4 py-8 md:px-8 lg:py-10">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => 'logout-confirmation','title' => 'Sair do sistema?','message' => 'Você será direcionada para a tela de login.','confirmLabel' => 'Sair','variant' => 'warning','icon' => 'gmdi-logout-o','action' => route('logout'),'method' => 'POST']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'logout-confirmation','title' => 'Sair do sistema?','message' => 'Você será direcionada para a tela de login.','confirm-label' => 'Sair','variant' => 'warning','icon' => 'gmdi-logout-o','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'method' => 'POST']); ?>
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

    <?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => 'unsaved-form-confirmation','title' => 'Sair sem salvar?','message' => 'Os dados não salvos serão perdidos. Deseja abandonar esta tela?','confirmLabel' => 'Sair sem salvar','cancelLabel' => 'Continuar editando','variant' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'unsaved-form-confirmation','title' => 'Sair sem salvar?','message' => 'Os dados não salvos serão perdidos. Deseja abandonar esta tela?','confirm-label' => 'Sair sem salvar','cancel-label' => 'Continuar editando','variant' => 'warning']); ?>
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

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/layouts/main-pages.blade.php ENDPATH**/ ?>