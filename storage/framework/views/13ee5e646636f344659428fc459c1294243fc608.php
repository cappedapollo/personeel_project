<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		<?php if(!Auth::check()): ?>
		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
			<!--begin::Header Logo-->
			<div class="header-logo">
				<a href="<?php echo e(url('/')); ?>">
					<img alt="<?php echo e(config('app.name')); ?>" src="<?php echo e(asset(config('layout.resources.logo'))); ?>" class="max-h-60px">
				</a>
			</div>
			<!--end::Header Logo-->
		</div>
        <?php endif; ?>
        
		<!--begin::Topbar-->
		<?php if(Auth::check()): ?>
    		<?php
    		$first_name = ucfirst(Auth::user()->first_name);
    		$first_letter = $first_name[0];
    		?>
		<?php endif; ?>
		<div></div>
		<div class="topbar">
			
			<?php
        	if (app()->getLocale() == 'en') {
                $kt_lang_image = config('layout.resources.lang-flag-en');
            }else {
                $kt_lang_image = config('layout.resources.lang-flag-du');
        	}
        	?>
            <div class="dropdown">
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                        <img class="h-20px w-20px rounded-sm" src="<?php echo e(asset($kt_lang_image)); ?>" alt=""/>
                    </div>
                </div>
    
                <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                    <?php echo $__env->make('layout.partials.extras.dropdown.languages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            
            <?php if(Auth::check()): ?>
			<!--begin::User-->
			<div class="dropdown">
				<!--begin::Toggle-->
				<div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
					<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2">
						<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?php echo e($first_name); ?></span>
						<span class="symbol symbol-35 symbol-light-primary">
							<span class="symbol-label font-size-h5 font-weight-bold"><?php echo e($first_letter); ?></span>
						</span>
					</div>
				</div>
				<!--end::Toggle-->

				<!--begin::Dropdown-->
				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
					<?php echo $__env->make('layout.partials.extras.dropdown.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				<!--end::Dropdown-->
			</div>
			<!--end::User-->
			<?php endif; ?>
		</div>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header--><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/partials/header.blade.php ENDPATH**/ ?>