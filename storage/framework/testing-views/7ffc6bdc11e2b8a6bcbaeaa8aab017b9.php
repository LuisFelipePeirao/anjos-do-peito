<?php if (isset($component)) { $__componentOriginal1bdc6b853fd7f13daa85ed568aadc2f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bdc6b853fd7f13daa85ed568aadc2f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.entity-manager-modal','data' => ['dialogId' => 'attendance-procedure-dialog','title' => 'Gerenciar procedimentos','description' => 'Cadastre, edite ou inative procedimentos.','storeAction' => route('attendances.procedures.store'),'updateRoute' => 'attendances.procedures.update','toggleRoute' => 'attendances.procedures.toggle','items' => $allProcedures,'entityLabel' => 'procedimento','namePlaceholder' => 'Nome do procedimento','emptyMessage' => 'Nenhum procedimento cadastrado.','inputClass' => $inputClass,'errorBag' => 'procedure']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.entity-manager-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dialog-id' => 'attendance-procedure-dialog','title' => 'Gerenciar procedimentos','description' => 'Cadastre, edite ou inative procedimentos.','store-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('attendances.procedures.store')),'update-route' => 'attendances.procedures.update','toggle-route' => 'attendances.procedures.toggle','items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allProcedures),'entity-label' => 'procedimento','name-placeholder' => 'Nome do procedimento','empty-message' => 'Nenhum procedimento cadastrado.','input-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inputClass),'error-bag' => 'procedure']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bdc6b853fd7f13daa85ed568aadc2f9)): ?>
<?php $attributes = $__attributesOriginal1bdc6b853fd7f13daa85ed568aadc2f9; ?>
<?php unset($__attributesOriginal1bdc6b853fd7f13daa85ed568aadc2f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bdc6b853fd7f13daa85ed568aadc2f9)): ?>
<?php $component = $__componentOriginal1bdc6b853fd7f13daa85ed568aadc2f9; ?>
<?php unset($__componentOriginal1bdc6b853fd7f13daa85ed568aadc2f9); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/attendances/partials/procedure-modal.blade.php ENDPATH**/ ?>