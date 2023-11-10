
<?php $__env->startSection('content'); ?>
<p class="text-primary mt-10 mt-md-0">419</p>
<div class="card card-custom gutter-b">
	<div class="card-body text-center">
		<a href="#">
			<img src="<?php echo e(asset(config('layout.resources.logo'))); ?>" class="max-h-100px" alt=""/>
		</a>
		<p class="mt-10"><?php echo e(__('messages.page_expired')); ?></p>
		<p class="font-size-h3 mt-10">
			<a href="<?php echo e(config('app.url').app()->getLocale()); ?>" class="btn btn-primary btn-lg"><?php echo e(__('form.label.to').' '.__('menu.dashboard')); ?></a>
		</p>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.error1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/errors/419.blade.php ENDPATH**/ ?>