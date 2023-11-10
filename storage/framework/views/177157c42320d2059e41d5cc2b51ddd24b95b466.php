<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title><?php echo e(config('app.name')); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="<?php echo e(config('app.url')); ?>" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

		<link href="<?php echo e(asset('public/css/pages/error-5.css')); ?>" rel="stylesheet" type="text/css"/>
		<!--begin::Global Theme and Layout Themes Styles(used by all pages)-->
        <?php $__currentLoopData = config('layout.resources.css'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <link href="<?php echo e(asset($style)); ?>" rel="stylesheet" type="text/css"/>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<!--end::Global Theme Styles-->

		<link rel="shortcut icon" href="<?php echo e(asset(config('layout.resources.favicon'))); ?>" />
		
		
        <?php echo $__env->yieldPushContent('styles'); ?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    	<!--begin::Main-->
    	<div class="d-flex flex-column flex-root">
    		<!--begin::Error-->
    		<div class="error error-5 d-flex flex-row-fluid bgi-size-cover bgi-position-center">
    			<!--begin::Content-->
    			<div class="container d-flex flex-row-fluid flex-column justify-content-md-center p-12">
    				<?php echo $__env->yieldContent('content'); ?>
    			</div>
    			<!--end::Content-->
    		</div>
    		<!--end::Error-->
    	</div>
    	<!--end::Main-->
    	
    	<!--begin::Global Config(global config for global JS scripts)-->
		<script>
            var KTAppSettings = <?php echo json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES); ?>;
        </script>
		<!--end::Global Config-->

		<!--begin::Global Theme Bundle(used by all pages)-->
		<?php $__currentLoopData = config('layout.resources.js'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script src="<?php echo e(asset($script)); ?>" type="text/javascript"></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<!--end::Global Theme Bundle-->
		
		
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
    <!--end::Body-->
</html><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/error1.blade.php ENDPATH**/ ?>