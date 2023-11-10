<div class="col-lg-6 col-xxl-4">
	<!--begin::List Widget 9-->
	<div class="card card-custom card-stretch gutter-b">
		<!--begin::Header-->
		<div class="card-header">
			<h3 class="card-title">
				<span class="font-weight-bolder text-bblack"><?php echo e(trans_choice('menu.log', 2)); ?></span>
			</h3>
			<div class="card-toolbar">
				<a href="<?php echo e(url(app()->getLocale().'/logs')); ?>" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon">
					<i class="fas fa-external-link-alt text-bblack"></i>
				</a>
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body pt-4">
			<!--begin::Timeline-->
			<div class="timeline timeline-6 mt-3">
				<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$action_by = ($log->action_byu) ? $log->action_byu->full_name : '-';
					$action = $log->action;
					$created_at = $log->created_at;
            		$created_at = ($lang=='en') ? date('M d', strtotime($created_at)) : date('d M', strtotime($created_at));
            		$color = Arr::random($colors);
            		
                    switch($log->module) {
                    	case 'user':
                            $user = $log->user;
                            if ($user)
                            {
                            	$action = Str::replaceFirst('[user_name]', $user->full_name, $action);
                        	}
                            break;
                        case 'archive':
                        	$archive = $log->archive;
                        	if($archive) {
                            	$action = Str::replaceFirst('[employee_name]', ($archive->user) ? $archive->user->full_name : '', $action);
                                $action = Str::replaceFirst('[review_type]', ($archive->form_data) ? $archive->form_data->review_type->name : '', $action);
                                $action = Str::replaceFirst('[year]', ($archive->form_data) ? $archive->form_data->year : '', $action);
                            }
                            break;
                        case 'form_data':
                        	$form_data = $log->form_data;
                        	if($form_data) {
                                $action = Str::replaceFirst('[employee_name]', $form_data->user->full_name, $action);
                                $action = Str::replaceFirst('[review_type]', ($form_data->review_type) ? $form_data->review_type->name : '', $action);
                                $action = Str::replaceFirst('[year]', ($form_data->year) ? $form_data->year : '', $action);
                            }
                            $action = Str::replaceFirst('[user_name]', $action_by, $action);
                            break;
                        default:
                    }
                    
                    $action = Str::replaceFirst('[action_by]', $action_by, $action);
					?>
    				<!--begin::Item-->
    				<div class="timeline-item align-items-start">
    					<!--begin::Label-->
    					<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"><?php echo e($created_at); ?></div>
    					<!--end::Label-->
    					<!--begin::Badge-->
    					<div class="timeline-badge">
    						<i class="fas fa-circle text-dark-yellow icon-nm"></i>
    					</div>
    					<!--end::Badge-->
    					<!--begin::Text-->
    					<div class="font-weight-bolder text-dark-75 pl-3 font-size-lg"><?php echo nl2br($action); ?></div>
    					<!--end::Text-->
    				</div>
    				<!--end::Item-->
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
			<!--end::Timeline-->
		</div>
		<!--end: Card Body-->
	</div>
	<!--end: List Widget 9-->
</div><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/elements/log.blade.php ENDPATH**/ ?>