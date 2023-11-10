<!--begin::Main-->
<div class="d-flex flex-column flex-root">
	<!--begin::Login-->
	<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #ffffff;">
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(<?php echo e(asset(config('layout.resources.login_side_logo'))); ?>); background-size:cover;"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->

        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::logo-->
            <a href="#" class="text-center pt-10">
				<img src="<?php echo e(asset(config('layout.resources.logo'))); ?>" class="max-h-70px" alt=""/>
			</a>
            <!--end::logo-->
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <?php echo $__env->yieldContent('login-content'); ?>
            </div>
            <!--end::Content body-->
        </div>
        <!--end::Content-->
	</div>
    <!--end::Login-->
</div>
<!--end::Main--><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/login.blade.php ENDPATH**/ ?>