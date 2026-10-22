<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'header' => [],
    'data',
    'filters' => [],
    'action' => url()->current(),
    'showActions' => true,
    'deleteConfirmation' => [],
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'header' => [],
    'data',
    'filters' => [],
    'action' => url()->current(),
    'showActions' => true,
    'deleteConfirmation' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $searchFilter = $filters['search'] ?? null;
    $selectFilters = $filters['selects'] ?? [];
?>

<div class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <?php if($searchFilter || count($selectFilters) > 0): ?>
        <div class="border-b border-[#f0e7e8] p-5">
            <form action="<?php echo e($action); ?>" method="GET" class="flex flex-col gap-3 xl:flex-row xl:flex-wrap xl:items-end">
                <?php if($searchFilter): ?>
                    <?php if (isset($component)) { $__componentOriginala1efc2ad15faf8999a68629b97403977 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala1efc2ad15faf8999a68629b97403977 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.search-input','data' => ['name' => $searchFilter['name'] ?? 'q','label' => $searchFilter['label'] ?? 'Pesquisar','value' => $searchFilter['value'] ?? '','placeholder' => $searchFilter['placeholder'] ?? 'Pesquisar','wrapperClass' => 'flex-1 xl:min-w-105']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.search-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFilter['name'] ?? 'q'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFilter['label'] ?? 'Pesquisar'),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFilter['value'] ?? ''),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFilter['placeholder'] ?? 'Pesquisar'),'wrapper-class' => 'flex-1 xl:min-w-105']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala1efc2ad15faf8999a68629b97403977)): ?>
<?php $attributes = $__attributesOriginala1efc2ad15faf8999a68629b97403977; ?>
<?php unset($__attributesOriginala1efc2ad15faf8999a68629b97403977); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala1efc2ad15faf8999a68629b97403977)): ?>
<?php $component = $__componentOriginala1efc2ad15faf8999a68629b97403977; ?>
<?php unset($__componentOriginala1efc2ad15faf8999a68629b97403977); ?>
<?php endif; ?>
                <?php endif; ?>

                <div class="grid items-end gap-3 sm:grid-cols-2 xl:flex xl:shrink-0">
                    <?php $__currentLoopData = $selectFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal050cb78dd2a0629fc98da9303d02daec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal050cb78dd2a0629fc98da9303d02daec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.outlined-select','data' => ['name' => $filter['name'],'label' => $filter['label'] ?? 'Filtro','icon' => 'gmdi-filter-alt-o','selected' => $filter['value'] ?? null,'options' => $filter['options'] ?? [],'wrapperClass' => 'xl:w-56']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.outlined-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filter['name']),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filter['label'] ?? 'Filtro'),'icon' => 'gmdi-filter-alt-o','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filter['value'] ?? null),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filter['options'] ?? []),'wrapper-class' => 'xl:w-56']); ?>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="w-full min-w-195 text-left text-sm">
            <thead class="border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase tracking-wide text-[#667085]">
                <tr>
                    <?php $__currentLoopData = $header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th scope="col" class="px-5 py-4 font-semibold">
                            <?php echo e($column); ?>

                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($showActions): ?>
                        <th scope="col" class="px-5 py-4 text-right font-semibold">
                            Ações
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0e7e8]">
                <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $actions = $row['_actions'] ?? [];
                        $displayRow = collect((array) $row)
                            ->reject(fn ($value, $key) => str_starts_with((string) $key, '_'))
                            ->all();
                    ?>
                    <tr class="transition hover:bg-[#fff7f9]">
                         <?php $__currentLoopData = $displayRow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($loop->first): ?>
                                <th scope="row" class="px-5 py-4 font-semibold whitespace-nowrap text-[#111827]">
                                    <?php if(isset($actions['view'])): ?>
                                        <a href="<?php echo e($actions['view']); ?>" class="transition hover:text-[#ef5b97]">
                                            <?php echo e($value); ?>

                                        </a>
                                    <?php else: ?>
                                        <?php echo e($value); ?>

                                    <?php endif; ?>
                                </th>
                            <?php elseif($key === 'status'): ?>
                                <?php
                                    $statusClass = match ($value) {
                                        'Ativa', 'Em andamento', 'Disponível', 'Pago', 'Entrada', 'Normal', 'Entregue' => 'bg-[#e8f8ee] text-[#197a4b]',
                                        'Agendado', 'Emprestada', 'Distribuído', 'Realizado', 'Recebida' => 'bg-[#eef4ff] text-[#1769aa]',
                                        'Manutenção', 'Ajuste' => 'bg-[#f2f4f7] text-[#667085]',
                                        'Em atraso', 'Pendente', 'Baixo', 'Saída' => 'bg-[#fff7e6] text-[#8a4b00]',
                                        'Cancelado', 'Inativa', 'Crítico' => 'bg-[#fff1f1] text-[#b42336]',
                                        default => 'bg-[#f2f4f7] text-[#667085]',
                                    };
                                ?>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                        <?php echo e($value); ?>

                                    </span>
                                </td>
                            <?php else: ?>
                                <td class="px-5 py-4 text-[#344054]">
                                    <?php echo e($value); ?>

                                </td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($showActions): ?>
                            <?php
                                $defaultActions = [
                                    [
                                        'icon' => 'visibility-o',
                                        'route' => $actions['view'] ?? '#',
                                        'title' => 'Visualizar',
                                        'variant' => 'default',
                                    ],
                                    [
                                        'icon' => 'delete-o',
                                        'route' => $actions['delete'] ?? '#',
                                        'title' => 'Excluir',
                                        'variant' => 'danger',
                                    ],
                                ];

                                $tableActions = $actions['items'] ?? $defaultActions;
                            ?>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <?php $__currentLoopData = $tableActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $actionIcon = 'gmdi-' . ($action['icon'] ?? 'visibility-o');
                                            $actionRoute = $action['route'] ?? '#';
                                            $actionTitle = $action['title'] ?? 'Ação';
                                            $actionVariant = $action['variant']
                                                ?? (($action['icon'] ?? null) === 'delete-o' ? 'danger' : 'default');
                                            $actionClass = $actionVariant === 'danger'
                                                ? 'inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#b42336] transition hover:bg-[#fff1f1] hover:text-[#b42336]'
                                                : 'inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]';

                                            $confirmation = $action['confirmation'] ?? null;
                                            if ($actionVariant === 'danger') {
                                                $confirmation = array_merge($deleteConfirmation, is_array($confirmation) ? $confirmation : []);
                                            }
                                            $confirmation = is_array($confirmation)
                                                ? array_merge([
                                                    'title' => 'Confirmar exclusão',
                                                    'message' => 'Deseja realmente excluir este registro?',
                                                    'confirmLabel' => 'Excluir',
                                                    'cancelLabel' => 'Cancelar',
                                                    'variant' => 'danger',
                                                    'method' => 'GET',
                                                ], $confirmation)
                                                : null;
                                            $confirmationId = $confirmation
                                                ? 'datatable-confirm-' . md5($actionRoute . '|' . $actionTitle . '|' . json_encode($displayRow))
                                                : null;
                                            $confirmationMethod = strtoupper($confirmation['method'] ?? 'GET');
                                            $confirmationAction = $confirmation['action']
                                                ?? ($confirmationMethod !== 'GET' ? $actionRoute : null);
                                            $confirmationHref = $confirmation['href']
                                                ?? ($confirmationAction ? null : $actionRoute);
                                        ?>

                                        <a
                                            href="<?php echo e($actionRoute); ?>"
                                            class="<?php echo e($actionClass); ?>"
                                            title="<?php echo e($actionTitle); ?>"
                                            <?php if($confirmationId): ?> data-confirm-dialog-open="<?php echo e($confirmationId); ?>" <?php endif; ?>
                                        >
                                            <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $actionIcon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
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
                                        </a>

                                        <?php if($confirmationId): ?>
                                            <?php if (isset($component)) { $__componentOriginal56125bb6dacfcebb197de13a56b0d464 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56125bb6dacfcebb197de13a56b0d464 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.confirm-modal','data' => ['id' => $confirmationId,'title' => $confirmation['title'],'message' => $confirmation['message'],'confirmLabel' => $confirmation['confirmLabel'],'cancelLabel' => $confirmation['cancelLabel'],'variant' => $confirmation['variant'],'icon' => $confirmation['icon'] ?? null,'action' => $confirmationAction,'method' => $confirmationMethod,'href' => $confirmationHref]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationId),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['title']),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['message']),'confirm-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['confirmLabel']),'cancel-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['cancelLabel']),'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['variant']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmation['icon'] ?? null),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationAction),'method' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationMethod),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($confirmationHref)]); ?>
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
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e(count($header) + ($showActions ? 1 : 0)); ?>" class="px-5 py-12 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#fdecef] text-[#ef5b97]">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-search'); ?>
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
                                </div>
                                <p class="mt-3 font-semibold text-[#111827]">Nenhum registro encontrado</p>
                                <p class="mt-1 text-sm text-[#667085]">Ajuste a busca ou altere os filtros selecionados.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/components/tables/datatable.blade.php ENDPATH**/ ?>