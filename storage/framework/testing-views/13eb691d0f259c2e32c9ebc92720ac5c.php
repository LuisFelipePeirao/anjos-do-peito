<?php $__env->startSection('title', 'Usuarios internos'); ?>
<?php $__env->startSection('page-title', 'Usuarios internos'); ?>
<?php $__env->startSection('active-menu', 'users.index'); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6">
        <?php if (isset($component)) { $__componentOriginal26e5d4095a2a19e4a62e755b3aefe267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e5d4095a2a19e4a62e755b3aefe267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.page-info','data' => ['subheading' => 'Administração','title' => 'Usuários internos','description' => 'Gerencie os acessos da equipe da ONG.','firstButton' => ['label' => 'Novo usuário', 'link' => route('users.create'), 'icon' => 'add']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.page-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subheading' => 'Administração','title' => 'Usuários internos','description' => 'Gerencie os acessos da equipe da ONG.','firstButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Novo usuário', 'link' => route('users.create'), 'icon' => 'add'])]); ?>
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

        <?php if(session('status')): ?>
            <p class="rounded-[8px] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800"><?php echo e(session('status')); ?></p>
        <?php endif; ?>

        <?php $__errorArgs = ['usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="rounded-[8px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php if (isset($component)) { $__componentOriginald9649e75090bf6a96fa801b770a21768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9649e75090bf6a96fa801b770a21768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tables.datatable','data' => ['header' => [
                'Nome',
                'E-mail',
                'Perfil',
                'Situação',
            ],'data' => $users,'action' => route('users.index'),'filters' => [
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar usuários',
                    'placeholder' => 'Pesquisar por nome ou e-mail',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do usuário',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'active', 'label' => 'Ativos'],
                            ['value' => 'inactive', 'label' => 'Inativos'],
                        ],
                    ],
                    [
                        'name' => 'profile',
                        'label' => 'Perfil de acesso',
                        'value' => $profile,
                        'options' => collect([['value' => 'all', 'label' => 'Todos os perfis']])
                            ->merge(collect($profiles)->map(fn ($userProfile) => [
                                'value' => $userProfile,
                                'label' => ucfirst($userProfile),
                            ]))
                            ->all(),
                    ],
                ],
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tables.datatable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'Nome',
                'E-mail',
                'Perfil',
                'Situação',
            ]),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($users),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('users.index')),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'search' => [
                    'name' => 'q',
                    'label' => 'Pesquisar usuários',
                    'placeholder' => 'Pesquisar por nome ou e-mail',
                    'value' => $search,
                ],
                'selects' => [
                    [
                        'name' => 'status',
                        'label' => 'Situação do usuário',
                        'value' => $status,
                        'options' => [
                            ['value' => 'all', 'label' => 'Todas as situações'],
                            ['value' => 'active', 'label' => 'Ativos'],
                            ['value' => 'inactive', 'label' => 'Inativos'],
                        ],
                    ],
                    [
                        'name' => 'profile',
                        'label' => 'Perfil de acesso',
                        'value' => $profile,
                        'options' => collect([['value' => 'all', 'label' => 'Todos os perfis']])
                            ->merge(collect($profiles)->map(fn ($userProfile) => [
                                'value' => $userProfile,
                                'label' => ucfirst($userProfile),
                            ]))
                            ->all(),
                    ],
                ],
            ])]); ?>
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

<?php echo $__env->make('layouts.main-pages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/users/index.blade.php ENDPATH**/ ?>