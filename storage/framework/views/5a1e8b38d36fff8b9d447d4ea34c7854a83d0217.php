
<?php
list($controller, $action) = getActionName();
?>
<?php $__env->startPush('styles'); ?>
<?php $__currentLoopData = config('layout.resources.index_css'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link href="<?php echo e(asset($style)); ?>" rel="stylesheet" type="text/css"/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__currentLoopData = config('layout.resources.index_js'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script src="<?php echo e(asset($script)); ?>" type="text/javascript"></script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php
$languages = __('form.array.lang');
?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.flash-message','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('flash-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.set-titles','data' => ['page' => ''.e($controller.'_'.$action).'','module' => ''.e(trans_choice('menu.company', 1)).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('set-titles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => ''.e($controller.'_'.$action).'','module' => ''.e(trans_choice('menu.company', 1)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<div class="card card-custom">
	<div class="card-body">
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<th><?php echo e(__('form.label.company_name')); ?></th>
    					<th><?php echo e(trans_choice('form.label.employee', 2)); ?></th>
    					<th><?php echo e(__('form.label.total_emp')); ?></th>
    					<th><?php echo e(__('form.label.name')); ?></th>
    					<th><?php echo e(__('form.label.country')); ?></th>
    					<th><?php echo e(__('form.label.created')); ?></th>
    					<th><?php echo e(trans_choice('form.label.action', 2)); ?></th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    					<?php 
    					$company_user = $company->company_user->first();
    					$created_at = str_replace('/', '-', $company->created_at);
        				$created_at = date('Y-m-d', strtotime($created_at));
        				$status_text = 'activate';
        				$status = 'active';
        				$aicon = 'flaticon2-check-mark';
        				if($company->status=='active') {
        					$status_text = 'deactivate';
        					$status = 'inactive';
        					$aicon = 'flaticon2-cross';
        				}
    					?>
        				<tr>
        					<td><?php echo e($company->name); ?></td>
        					<td><?php echo e($company->employee_no ? $company->employee_no->nos : '-'); ?></td>
        					<td><?php echo e($company->company_user->count()); ?></td>
        					<td><?php echo e(($company_user) ? $company_user->user->full_name : '-'); ?></td>
        					<td><?php echo e($company->country ? $company->country->name : '-'); ?></td>
        					<td data-sort='<?php echo e($created_at); ?>'><?php echo e($company->created_at); ?></td>
        					<td>
        						<a href="<?php echo e(route('companies.supdate', ['company' => $company->id, 'locale'=>app()->getLocale(), 'status'=>$status])); ?>" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.'.$status_text)); ?>"><i class="<?php echo e($aicon); ?>"></i></a>
        						<a href="<?php echo e(route('companies.edit', ['company' => $company->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.update')); ?>"><i class="flaticon-edit"></i></a>
    							<a href="<?php echo e(route('companies.show', ['company' => $company->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.view')); ?>"><i class="flaticon-eye"></i></a>
    							<a href="<?php echo e(route('categories.pdf', ['company' => $company->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.pdf')); ?>"><i class="far fa-file-pdf"></i></a>
    							<!-- Delete -->
                            	<form id="delete_form_<?php echo e($company->id); ?>" name="delete_form" action="<?php echo e(route('companies.destroy', ['company' => $company->id, 'locale'=>app()->getLocale()])); ?>" method="post" class="btn btn-icon btn-xs">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.delete')); ?>"><i class="flaticon-delete"></i></button>
                                </form>
                            	<!-- End: Delete -->
        					</td>
        				</tr>
    				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    			</tbody>
    		</table>
    	</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/companies/index.blade.php ENDPATH**/ ?>