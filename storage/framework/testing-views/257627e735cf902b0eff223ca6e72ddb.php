<?php if (isset($component)) { $__componentOriginal9be843a07f27ad5dee143692fb11dd22 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9be843a07f27ad5dee143692fb11dd22 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.material.floating-textarea','data' => ['name' => 'notes','label' => 'Observações','value' => 'Texto','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('material.floating-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notes','label' => 'Observações','value' => 'Texto','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $attributes = $__attributesOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__attributesOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9be843a07f27ad5dee143692fb11dd22)): ?>
<?php $component = $__componentOriginal9be843a07f27ad5dee143692fb11dd22; ?>
<?php unset($__componentOriginal9be843a07f27ad5dee143692fb11dd22); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\anjos-do-peito\storage\framework\testing-views/9bdd118e8585c1d6ac10a071ab3de68d.blade.php ENDPATH**/ ?>