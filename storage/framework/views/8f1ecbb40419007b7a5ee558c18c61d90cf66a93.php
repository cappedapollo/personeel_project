<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset(config('layout.resources.validation_js'))); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>
<?php
$status = __('form.array.status');
$role_code = $user->user_role->role_code;
$rfield = 'role_'.app()->getLocale();
?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b example example-compact">
			<form id="kt_form" class="form" method="POST" action="<?php echo e(route('users.update', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>">
            	<?php echo csrf_field(); ?>
            	<?php echo method_field('PATCH'); ?>
            	<div class="card-body">
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.role')); ?>: *</label>
                    			<select name="user_role_id" class="form-control" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.role')])); ?>">
                    				<option value=""><?php echo e(__('form.label.select').' '.__('form.label.role')); ?></option>
                        			<?php $__currentLoopData = $user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$user_role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($user_role->id); ?>" <?php echo e($user_role->id==$user->user_role_id ? 'selected' : ''); ?> data-code="<?php echo e($user_role->role_code); ?>"><?php echo e($user_role->$rfield); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
                		<div class="col-xl-6 mng-dropdown <?php echo e(in_array($role_code, ['employee', 'manager']) ? '' : 'd-none'); ?>">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(trans_choice('form.label.manager', 1)); ?>:</label>
                    			<select name="manager_id" class="form-control">
                    				<option value=""><?php echo e(__('form.label.select').' '.trans_choice('form.label.manager', 1)); ?></option>
                        			<?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid=>$manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($mid); ?>" <?php echo e(($mid==$user->manager_id) ? 'selected' : ''); ?>><?php echo e($manager); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
            		</div>
            		<div class="row">
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.first_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="first_name" value="<?php echo e($user->first_name); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.first_name')])); ?>" value="<?php echo e(old('first_name')); ?>"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.last_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="last_name" value="<?php echo e($user->last_name); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.last_name')])); ?>" value="<?php echo e(old('last_name')); ?>"/>
                    		</div>
                    	</div>
                    </div>
                    <div class="row">
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.email')); ?>: *</label>
                    			<input type="email" class="form-control" name="email" value="<?php echo e($user->email); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.email')])); ?>" data-fv-email-address___message="<?php echo e(__('validation.email', ['attribute' => __('form.label.email')])); ?>"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.function')); ?>:</label>
                    			<input type="text" class="form-control" name="function" value="<?php echo e($user->function); ?>"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.status')); ?>: *</label>
                    			<select name="status" class="form-control" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.status')])); ?>">
                    				<option value=""><?php echo e(__('form.label.select').' '.__('form.label.status')); ?></option>
                        			<?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($key); ?>" <?php echo e($key==$user->status ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
            		</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2"><?php echo e(__('form.label.save')); ?></button>
            		<a class="btn btn-secondary" href="<?php echo e(url(app()->getLocale().'/users')); ?>"><?php echo e(__('form.label.cancel')); ?></a>
            	</div>
            </form>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	var role_code = '<?php echo e($role_code); ?>';
	var has_manager = '';
	if($.inArray(role_code, ['employee', 'manager']) != -1) {
		has_manager = 'yes';
	}
	set_company(has_manager);

	$( "select[name=user_role_id]" ).change(function() {
		var text = $('option:selected', this).data('code');
		if($.inArray(text, ['employee', 'manager']) != -1) {
			text = 'yes';
		}
		set_company(text);
	});
});

function set_company(has_manager) {
	//validation.addField('manager_id', {validators: {notEmpty: { message: "<?php echo e(__('validation.required', ['attribute' => trans_choice('form.label.manager', 1) ])); ?>" }}});
	if(has_manager == 'yes') {
		$('.mng-dropdown').removeClass('d-none');	
	}else{
		//validation.removeField('manager_id');
		$('.mng-dropdown select').prop('value', '');
		$('.mng-dropdown').addClass('d-none');
	}
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/users/edit.blade.php ENDPATH**/ ?>