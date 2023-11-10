
<?php
	$status = __('form.array.status');
	$ur_field = 'role_'.app()->getLocale();
?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
        	<div class="card-body">
            	<div class="table-responsive">
    				<table class="table table-striped table-borderless">
                		<tbody>
                			<tr>
                				<td class="font-weight-bold"><?php echo e(__('form.label.name')); ?>:</td>
                				<td class="text-right"><?php echo e($user->full_name); ?></td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold"><?php echo e(__('form.label.email')); ?>:</td>
                				<td class="text-right"><?php echo e($user->email); ?></td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold"><?php echo e(__('form.label.function')); ?>:</td>
                				<td class="text-right"><?php echo e($user->function ? $user->function : '-'); ?></td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold"><?php echo e(__('form.label.role')); ?>:</td>
                				<td class="text-right"><?php echo e(($user->user_role) ? $user->user_role->$ur_field : '-'); ?></td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold"><?php echo e(trans_choice('form.label.manager', 1)); ?>:</td>
                				<td class="text-right"><?php echo e(($user->manager) ? $user->manager->full_name : '-'); ?></td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold"><?php echo e(__('form.label.status')); ?>:</td>
                				<td class="text-right"><?php echo e($status[$user->status]); ?></td>
                			</tr>
            			</tbody>
        			</table>
    			</div>
            </div>
        </div>
        <!--end::Card-->
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/users/show.blade.php ENDPATH**/ ?>