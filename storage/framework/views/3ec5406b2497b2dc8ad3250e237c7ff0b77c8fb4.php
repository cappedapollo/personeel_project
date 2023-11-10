
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
?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('components/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card card-custom">
	<div class="card-body">
		<input type="hidden" id="page" value="<?php echo e($controller); ?>_<?php echo e($action); ?>">
		<input type="hidden" id="search_text" value="<?php echo e(__('form.label.search')); ?>">
        <input type="hidden" id="previous_text" value="<?php echo e(__('form.label.previous')); ?>">
        <input type="hidden" id="next_text" value="<?php echo e(__('form.label.next')); ?>">
		
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<th><?php echo e(__('form.label.action_by')); ?></th>
    					<th><?php echo e(trans_choice('form.label.action', 1)); ?></th>
    					<th><?php echo e(__('form.label.created')); ?></th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    					<?php
    					$action_by = ($log->action_byu) ? $log->action_byu->full_name : '-';
    					$action = $log->action;
                        switch($log->module) {
                            case 'user':
                                $user = $log->user;
                                $action = Str::replaceFirst('[user_name]', $user->full_name, $action);
                                break;
                            case 'archive':
                            	$archive = $log->archive;
                            	if($archive) {
                                	$review_type = '';
                                	if ($archive->form_data) {
                                		$_review_type = company_review_type($archive->form_data->review_type->number);
                                		$review_type = $_review_type->name;
                                	}
                            	
                                	$action = Str::replaceFirst('[employee_name]', $archive->user->full_name, $action);
                                    $action = Str::replaceFirst('[review_type]', $review_type, $action);
                                    $action = Str::replaceFirst('[year]', ($archive->form_data) ? $archive->form_data->year : '', $action);
                                }
                                break;
                            case 'form_data':
                            	$form_data = $log->form_data;
                            	$review_type = '';
                            	if ($form_data->review_type) {
                            		$_review_type = company_review_type($form_data->review_type->number);
                            		$review_type = $_review_type->name;
                            	}
                            	
                            	$action = Str::replaceFirst('[user_name]', $action_by, $action);
                                $action = Str::replaceFirst('[employee_name]', $form_data->user->full_name, $action);
                                $action = Str::replaceFirst('[review_type]', $review_type, $action);
                                $action = Str::replaceFirst('[year]', ($form_data->year) ? $form_data->year : '', $action);
                                break;
                            default:
                        }
                        
                        $action = Str::replaceFirst('[action_by]', $action_by, $action);
    					?>
        				<tr>
        					<td><?php echo e($action_by); ?></td>
        					<td><?php echo nl2br($action); ?></td>
        					<td><?php echo e($log->created_at); ?></td>
        				</tr>
    				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    			</tbody>
    		</table>
    	</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/logs/index.blade.php ENDPATH**/ ?>