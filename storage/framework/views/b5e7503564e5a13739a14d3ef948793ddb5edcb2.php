<?php
$role_field = 'role_'.app()->getLocale();
?>

<div class="d-flex align-items-center p-8 rounded-top">
    
    <div class="d-flex flex-column">
        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
			<?php echo e(ucwords(Auth::user()->full_name)); ?>

		</a>
        <div class="text-muted mt-1">
            <?php echo e(Auth::user()->user_role->$role_field); ?>

        </div>
        <div class="navi mt-2">
            <a href="#" class="navi-item">
                <span class="navi-link p-0 pb-2">
                    <span class="navi-icon mr-1">
						<span class="svg-icon svg-icon-lg svg-icon-success"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-notification.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"/>
                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"/>
                            </g>
                        </svg><!--end::Svg Icon--></span>
					</span>
                    <span class="navi-text text-muted text-hover-primary"><?php echo e(Auth::user()->email); ?></span>
                </span>
            </a>
        </div>
    </div>
</div>


<div class="navi navi-spacer-x-0 pt-5">
    
    <div class="navi-separator mt-3"></div>
    <div class="px-8 py-5">
    	<a href="<?php echo e(url(app()->getLocale().'/profile')); ?>" class="btn btn-light-danger font-weight-bold mr-3"><?php echo e(__('form.label.update')); ?></a>
        <a href="<?php echo e(url(app()->getLocale().'/logout')); ?>" class="btn btn-light-primary font-weight-bold"><?php echo e(__('form.label.sign_out')); ?></a>
    </div>
</div>
<?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/partials/extras/dropdown/user.blade.php ENDPATH**/ ?>