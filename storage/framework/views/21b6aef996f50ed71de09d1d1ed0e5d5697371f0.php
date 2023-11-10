
<?php $__env->startSection('login-content'); ?>
<!--begin::Signin-->
<div class="login-form login-signin">
	<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="text-center">
    	<img alt="" src="<?php echo e(asset(config('layout.resources.2fa_logo'))); ?>" class="max-h-80px mb-10">
    </div>
    <!--begin::Form-->
    <form class="form" action="<?php echo e(route('gfa_authenticate', ['locale'=>app()->getLocale()])); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg"><?php echo e(__('form.label.verification_code')); ?></h3>
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="number" name="one_time_password" id="one_time_password" autocomplete="off" required autofocus/>
        </div>
        
        <p><?php echo __('messages.setup_2fa', ['href'=>url(app()->getLocale().'/gfa_generate_link')]); ?></p>
    </form>
    <!--end::Form-->
</div>
<!--end::Signin-->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	$('input[name=one_time_password]').on('keyup', function(){
	    if($(this).val().length == 6){
	        $('.form').submit();
	    }
	});
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/google2fa/index.blade.php ENDPATH**/ ?>