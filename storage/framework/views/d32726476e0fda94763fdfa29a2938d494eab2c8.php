<?php
$role_code = Auth::user()->user_role->role_code;
$panel3_title = __('form.label.lforms');
if($role_code == 'admin') {
	$panel3_title = __('form.label.to_approve');
}elseif($role_code == 'manager') {
	$panel3_title = __('form.label.approve_mng');
}
?>
<div class="col-lg-6 col-xxl-4">
	<!--begin::List Widget 9-->
	<div class="card card-custom card-stretch gutter-b">
		<!--begin::Header-->
		<div class="card-header">
			<h3 class="card-title">
				<span class="font-weight-bolder text-bblack"><?php echo e($panel3_title); ?></span>
			</h3>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body pt-4">
			<!--begin::Timeline-->
			<div class="timeline timeline-6 mt-3">
				<?php $__currentLoopData = $_archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$created_at = str_replace('/', '-', $archive->created_at);
            		$created_at = ($lang=='en') ? date('M d', strtotime($created_at)) : date('d M', strtotime($created_at));
            		
            		$user_name = $archive->user ? $archive->user->full_name : '-';
            		$review_type = $archive->form_data ? $archive->form_data->review_type->name : '';
            		
            		$file_key = ($archive->file) ? urlencode($archive->file->file_key) : '';
					?>
    				<!--begin::Item-->
    				<div class="timeline-item align-items-start">
    					<!--begin::Label-->
    					<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"><?php echo e($created_at); ?></div>
    					<!--end::Label-->
    					<!--begin::Badge-->
    					<div class="timeline-badge">
    						<i class="fas fa-circle text-dark icon-sm"></i>
    					</div>
    					<!--end::Badge-->
    					<!--begin::Text-->
    					<div class="font-weight-bolder text-dark-75 pl-3 font-size-lg">
    						<a href="<?php echo e(route('archives.show', ['archive' => $archive->user->id, 'locale'=>app()->getLocale()])); ?>" class="text-bblack-hover">
    							<?php echo e($user_name.' - '.$review_type); ?>

    						</a>		
						</div>
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
</div><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/elements/form.blade.php ENDPATH**/ ?>