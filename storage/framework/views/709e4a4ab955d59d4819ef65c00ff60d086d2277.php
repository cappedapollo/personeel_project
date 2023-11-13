<?php $__env->startPush('styles'); ?>
<?php $__currentLoopData = config('layout.resources.index_css'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link href="<?php echo e(asset($style)); ?>" rel="stylesheet" type="text/css"/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__currentLoopData = config('layout.resources.index_js'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script src="<?php echo e(asset($script)); ?>" type="text/javascript"></script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php
list($controller, $action) = getActionName();
$storage_path = config('filesystems.storage_path');
$template_dir = config('filesystems.dirs.template');
?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="accordion accordion-solid accordion-panel accordion-svg-toggle mb-5" id="accordionExample3">
        	<div class="card">
                <div class="card-header" id="heading3">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse3">
                    	<span class="svg-icon svg-icon-primary">
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                           <polygon points="0 0 24 0 24 24 0 24"></polygon>
                           <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                           <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                          </g>
                         </svg>
                        </span>
                        <div class="card-label pl-4"><?php echo e(__('form.label.explanation')); ?></div>
                    </div>
                </div>
                <div id="collapse3" class="collapse" data-parent="#accordionExample3">
                    <div class="card-body">
						<?php echo __('messages.expl_user_import'); ?>

                    </div>
                </div>
            </div>
        </div>
        
		<div class="card card-custom gutter-b">
			<div class="card-header">
        		<div class="card-toolbar">
        			<a href="<?php echo e(url(app()->getLocale().'/tdownload')); ?>" class="btn btn-secondary mr-2"><?php echo e(__('form.label.download').' '.__('form.label.template')); ?></a>
        			
        			<div class="dropzone dropzone-multi" id="kt_dropzone_5">
        				<div class="dropzone-panel mb-lg-0 mb-2">
        					<a class="dropzone-select btn btn-primary mr-2"><?php echo e(__('form.label.upload').' '.__('form.label.xlsx')); ?></a>
        				</div>
        			</div>
        			<!-- <a href="<?php echo e(asset($storage_path.$template_dir.'/personeel_template.csv')); ?>" class="btn btn-secondary mr-2"><?php echo e(__('form.label.download').' '.__('form.label.template')); ?></a> -->

					<a href="<?php echo e('https://login.celerypayroll.com/oauth2/authorize?scope=offline_access&client_id=8f771a5a-15a9-47ab-9670-1f8c09a1722b&response_type=code&redirect_uri='. urlencode(url('/celery/callback'))); ?>" class="btn btn-outline-danger mr-2"><?php echo e(__('form.label.import').' '.__('form.label.from').' '.__('form.label.celery')); ?></a>

        		</div>
        	</div>
			<div class="card-body">
				<input type="hidden" id="page" value="<?php echo e($controller); ?>_<?php echo e($action); ?>">
        		<input type="hidden" id="delete_title_text" value="<?php echo e(__('messages.delete_file_title')); ?>">
        		<input type="hidden" id="delete_conf_text" value="<?php echo e(__('messages.delete_conf')); ?>">
        		<input type="hidden" id="cancel_text" value="<?php echo e(__('form.label.cancel')); ?>">
		
        		<div class="table-responsive">
            		<table class="table table-hover">
            			<thead>
            				<tr>
            					<th><?php echo e(__('form.label.file').' '.__('form.label.name')); ?></th>
            					<th><?php echo e(__('form.label.total').' '.trans_choice('form.label.person', 2)); ?></th>
            					<th><?php echo e(__('form.label.upload').' '.__('form.label.date')); ?></th>
            					<th><?php echo e(trans_choice('menu.user', 1)); ?></th>
            				</tr>
            			</thead>
            			<tbody>
            				<?php $__currentLoopData = $imports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $import): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            				<tr>
            					<td><?php echo e($import->file_name); ?></td>
            					<td><?php echo e($import->total_users); ?></td>
            					<td><?php echo e($import->created_at); ?></td>
            					<td><?php echo e(($import->created_by) ? $import->created_by->full_name : '-'); ?></td>
            				</tr>
            				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            			</tbody>
            		</table>
            	</div>
        	</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	var id = '#kt_dropzone_5';
	var url_to_upload = "<?php echo e(route('user_imports.import', ['locale'=>app()->getLocale()])); ?>";
	var csrf_token = '<?php echo e(csrf_token()); ?>';

    var myDropzone5 = new Dropzone(id, { // Make the whole body a dropzone
        url: url_to_upload, // Set the url for your upload script location
        parallelUploads: 20,
        //maxFilesize: 1, // Max filesize in MB
        //previewTemplate: previewTemplate,
        //previewsContainer: id + " .dropzone-items", // Define the container to display the previews
        clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
        //acceptedFiles: ".csv, text/csv, application/vnd.ms-excel, application/csv, text/x-csv, application/x-csv, text/comma-separated-values, text/x-comma-separated-values",
        acceptedFiles: 'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    });

    myDropzone5.on("sending", function(file, xhr, data) {
        // Show the total progress bar when upload starts
        data.append("_token", csrf_token);
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone5.on("complete", function(progress) {
    	location.reload(true);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/user_imports/index.blade.php ENDPATH**/ ?>