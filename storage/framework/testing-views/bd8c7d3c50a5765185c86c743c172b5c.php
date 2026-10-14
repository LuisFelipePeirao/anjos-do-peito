<?php if (isset($component)) { $__componentOriginal1bdc6b853fd7f13daa85ed568aadc2f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bdc6b853fd7f13daa85ed568aadc2f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app.entity-manager-modal','data' => ['dialogId' => 'attendance-category-dialog','title' => 'Gerenciar população atendida','description' => 'Cadastre, edite ou inative categorias de atendimento.','storeAction' => route('attendances.categories.store'),'updateRoute' => 'attendances.categories.update','toggleRoute' => 'attendances.categories.toggle','items' => $allAttendanceCategories,'entityLabel' => 'categoria','namePlaceholder' => 'Nome da população atendida','emptyMessage' => 'Nenhuma categoria cadastrada.','inputClass' => $inputClass,'errorBag' => 'attendanceCategory']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app.entity-manager-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dialog-id' => 'attendance-category-dialog','title' => 'Gerenciar população atendida','description' => 'Cadastre, edite ou inative categorias de atendimento.','store-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('attendances.categories.store')),'update-route' => 'attendances.categories.update','toggle-route' => 'attendances.categories.toggle','items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allAttendanceCategories),'entity-label' => 'categoria','name-placeholder' => 'Nome da população atendida','empty-message' => 'Nenhuma categoria cadastrada.','input-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inputClass),'error-bag' => 'attendanceCategory']); ?>
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
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/pages/attendances/partials/category-modal.blade.php ENDPATH**/ ?>