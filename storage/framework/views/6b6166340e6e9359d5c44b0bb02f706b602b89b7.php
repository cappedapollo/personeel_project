<!--begin::Main-->
<?php echo $__env->make('layout.partials.header_mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="d-flex flex-column flex-root">

	<!--begin::Page-->
	<div class="d-flex flex-row flex-column-fluid page">
		<?php if(Auth::check()): ?>
			<?php echo $__env->make('layout.partials.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
		
		<!--begin::Wrapper-->
		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
			<?php echo $__env->make('layout.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!--begin::Content-->
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				<?php echo $__env->make('layout.partials.subheader.subheader-v1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!--Content area here-->
				
				<?php echo $__env->make('layout.partials.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
			<!--end::Content-->
			<?php echo $__env->make('layout.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
</div>
<!--end::Main--><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/base/layout.blade.php ENDPATH**/ ?>