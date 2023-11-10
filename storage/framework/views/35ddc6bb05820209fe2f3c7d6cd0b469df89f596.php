<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset(config('layout.resources.validation_js'))); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>
<?php
$role_code = Auth::user()->user_role->role_code;
$status = __('form.array.status');
$rfield = 'role_'.app()->getLocale();
?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
	<div class="col-lg-12">
		<?php if($role_code == 'admin'): ?>
		<div class="accordion accordion-solid accordion-panel accordion-svg-toggle mb-5" id="accordionExample3">
        	<div class="card">
                <div class="card-header" id="heading3">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse3">
                    	<span class="svg-icon svg-icon-primary">
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                           <polygon points="0 0 24 0 24 24 0 24"></polygon>
                           <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                           <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                          </g>
                         </svg>
                        </span>
                        <div class="card-label pl-4"><?php echo e(__('form.label.explanation')); ?></div>
                    </div>
                </div>
                <div id="collapse3" class="collapse" data-parent="#accordionExample3">
                    <div class="card-body">
						<?php echo __('messages.expl_add_user'); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
		<div class="card card-custom gutter-b example example-compact">
			<form id="kt_form" class="form" method="POST" action="<?php echo e(route('users.store', ['locale'=>app()->getLocale()])); ?>">
            	<?php echo csrf_field(); ?>
            	<div class="card-body">
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.role')); ?>: *</label>
                    			<select name="user_role_id" class="form-control" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.role')])); ?>">
                    				<option value=""><?php echo e(__('form.label.select').' '.__('form.label.role')); ?></option>
                        			<?php $__currentLoopData = $user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$user_role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($user_role->id); ?>" <?php echo e($user_role->id==old('user_role_id') ? 'selected' : ''); ?> data-code="<?php echo e($user_role->role_code); ?>"><?php echo e($user_role->$rfield); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
                		<div class="col-xl-6 mng-dropdown d-none">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(trans_choice('form.label.manager', 1)); ?>:</label>
                    			<select name="manager_id" class="form-control">
                    				<option value=""><?php echo e(__('form.label.select').' '.trans_choice('form.label.manager', 1)); ?></option>
                        			<?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid=>$manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($mid); ?>" <?php echo e($mid==old('manager_id') ? 'selected' : ''); ?>><?php echo e($manager); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
            		</div>
            		<div class="row">
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.first_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="first_name" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.first_name')])); ?>" value="<?php echo e(old('first_name')); ?>"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.last_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="last_name" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.last_name')])); ?>" value="<?php echo e(old('last_name')); ?>"/>
                    		</div>
                    	</div>
                    </div>
                    <div class="row">
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.email')); ?>: *</label>
                    			<input type="email" class="form-control" name="email" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.email')])); ?>" value="<?php echo e(old('email')); ?>" data-fv-email-address___message="<?php echo e(__('validation.email', ['attribute' => __('form.label.email')])); ?>"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.function')); ?>:</label>
                    			<input type="text" class="form-control" name="function" value="<?php echo e(old('function')); ?>"/>
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
                        				<option value="<?php echo e($key); ?>" <?php echo e($key==old('status') ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
                	</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2"><?php echo e(__('form.label.save')); ?></button>
            		<a class="btn btn-secondary" href="<?php echo e(url('users')); ?>"><?php echo e(__('form.label.cancel')); ?></a>
            	</div>
            </form>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	$( "select[name=user_role_id]" ).change(function() {
		var text = $('option:selected', this).data('code');
		$('.mng-dropdown').addClass('d-none');
		$('.mng-dropdown select').prop('value', '');
		if($.inArray(text, ['employee', 'manager']) != -1) {
			//validation.addField('manager_id', {validators: {notEmpty: { message: "<?php echo e(__('validation.required', ['attribute' => trans_choice('form.label.manager', 1)])); ?>" }}});
			$('.mng-dropdown').removeClass('d-none');	
		}else{
			//validation.removeField('manager_id');
		}
	});
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/users/create.blade.php ENDPATH**/ ?>