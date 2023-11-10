<?php
list($controller, $action) = getActionName();
?>
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title><?php echo e(config('app.name')); ?> | <?php echo $__env->yieldContent('title', $page_title ?? ''); ?></title>
		<!-- <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." /> -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="<?php echo e(config('app.url')); ?>" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		
		<?php if(in_array($action, array('login', 'reset_password', 'verify', 'gfa_register', 'gfa_authenticate'))): ?>
		<link href="<?php echo e(asset(config('layout.resources.login_css'))); ?>" rel="stylesheet" type="text/css"/>
		<?php endif; ?>
		
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
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading <?php echo e((Auth::check() && $controller!='PageController') ? 'aside-enabled aside-fixed aside-minimize-hoverable' : ''); ?>">
		<?php if(in_array($action, array('login', 'reset_password', 'gfa_register', 'verify', 'gfa_authenticate'))): ?>
        	<?php echo $__env->make('layout.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
        	<?php echo $__env->make('layout.base.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

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
</html><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/app.blade.php ENDPATH**/ ?>