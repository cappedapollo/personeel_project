<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset(config('layout.resources.validation_js'))); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset(config('layout.resources.custom_js'))); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>
<?php
$languages = __('form.array.lang');
$country_codes = __('form.array.country_codes');
?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="card gutter-b">
			<div class="card-body">
				<div><?php echo __('messages.registration_text'); ?></div>
			</div>
		</div>
		
		<div class="card card-custom gutter-b">
			<form id="kt_form" class="form" method="POST" enctype="multipart/form-data" action="<?php echo e(route('companies.store', [app()->getLocale()])); ?>">
            	<?php echo csrf_field(); ?>
            	<div class="card-body">
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.company_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.company_name')])); ?>"/>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.coc')); ?>:</label>
                    			<input type="text" class="form-control" name="chamber_of_commerce" value="<?php echo e(old('chamber_of_commerce')); ?>"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.address')); ?>: *</label>
                    			<input type="text" class="form-control" name="address" value="<?php echo e(old('address')); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.address')])); ?>"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.country')); ?>: *</label>
                    			<select name="country_id" class="form-control" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.country')])); ?>">
                    				<option value=""><?php echo e(__('form.label.select').' '.__('form.label.country')); ?></option>
                        			<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cid=>$country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($cid); ?>" <?php echo e($cid==old('country_id') ? 'selected' : ''); ?>><?php echo e($country); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                		</div>
                    </div>
                    <div class="row">
            			<div class="col-xl-3">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.lang')); ?>: *</label>
                    			<select name="language" class="form-control" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.lang')])); ?>">
                    				<option value=""><?php echo e(__('form.label.select').' '.__('form.label.lang')); ?></option>
                        			<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($id); ?>" <?php echo e($id==old('language') ? 'selected' : ''); ?>><?php echo e($language); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                    	</div>
                    	<div class="col-xl-3">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(trans_choice('form.label.employee', 2)); ?>:</label>
                    			<select name="employee_no_id" class="form-control">
                    				<option value=""><?php echo e(__('form.label.select').' '.trans_choice('form.label.employee', 2)); ?></option>
                        			<?php $__currentLoopData = $n_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$n_employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        				<option value="<?php echo e($id); ?>" <?php echo e($id==old('employee_no_id') ? 'selected' : ''); ?>><?php echo e($n_employee); ?></option>
                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    			</select>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">
                    				<?php echo e(__('form.label.upload').' '.__('form.label.logo')); ?>: 
                    				<a href="#" class="btn btn-icon btn-xs btn-light-primary btn-circle" data-toggle="tooltip" data-placement="right" title="<?php echo e(__('messages.clogo_validation')); ?>">
                    					<i class="fas fa-info-circle"></i>
                    				</a>
                				</label>
                    			<div class="custom-file">
                					<input type="file" class="custom-file-input" id="logo" name="logo"/>
                					<label class="custom-file-label" for="logo"><?php echo e(__('form.label.choose_file')); ?></label>
                				</div>
                    		</div>
                		</div>
            		</div>
            		
            		<h3 class="font-size-lg text-dark font-weight-bold mt-10 mb-6"><?php echo e(__('form.label.hr_cperson')); ?>:</h3>
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.first_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name')); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.first_name')])); ?>"/>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.last_name')); ?>: *</label>
                    			<input type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name')); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.last_name')])); ?>"/>
                    		</div>
                		</div>
            		</div>
                    <div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.telephone')); ?>: *</label>
                    			<input type="text" class="form-control" name="telephone" value="<?php echo e(old('telephone')); ?>" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.telephone')])); ?>"/>
                    		</div>
                    	</div>
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.email')); ?>: *</label>
                    			<input type="email" class="form-control" name="email" required data-fv-not-empty___message="<?php echo e(__('validation.required', ['attribute' => __('form.label.email')])); ?>" value="<?php echo e(old('email')); ?>" data-fv-email-address___message="<?php echo e(__('validation.email', ['attribute' => __('form.label.email')])); ?>"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold"><?php echo e(__('form.label.function')); ?>:</label>
                    			<input type="text" class="form-control" name="function" value="<?php echo e(old('function')); ?>"/>
                    		</div>
                    	</div>
                	</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2"><?php echo e(__('form.label.submit')); ?></button>
            	</div>
            </form>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	initialize_file();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/companies/create.blade.php ENDPATH**/ ?>