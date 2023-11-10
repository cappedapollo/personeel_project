<div class="col-lg-12">
    <div class="card card-custom">
    	<div class="card-body">
    		<div class="table-responsive">
        		<table class="table table-hover kt_datatable">
        			<thead>
        				<tr>
        					<th><?php echo e(trans_choice('menu.review_type', 1)); ?></th>
        					<th><?php echo e(__('form.label.year')); ?></th>
        					<th><?php echo e(__('form.label.created')); ?></th>
        					<th><?php echo e(__('form.label.status')); ?></th>
        					<th><?php echo e(__('form.label.status').' '.__('form.label.timestamp')); ?></th>
        					<?php if(in_array($role_code, array('admin', 'employee', 'manager'))): ?>
        					<th><?php echo e(trans_choice('form.label.action', 2)); ?></th>
        					<?php endif; ?>
        				</tr>
        			</thead>
        			<tbody>
        				<?php $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        					<?php
        					//$file_url = getLinkFromBucket($archive->file->file_key);
        					$file_key = ($archive->file) ? urlencode($archive->file->file_key) : '';
        					
        					$review_type = '-';
        					if ($archive->form_data) {
        						$_review_type = company_review_type($archive->form_data->review_type->number);
        						$review_type = $_review_type->name;
        					}
        					?>
            				<tr>
            					<td><a href="<?php echo e(route('files.show', ['locale' => app()->getLocale(), 'file' => $file_key])); ?>" target="_blank"><?php echo e($review_type); ?></a></td>
            					<td><?php echo e(($archive->form_data) ? $archive->form_data->year : '-'); ?></td>
            					<td><?php echo e($archive->created_at); ?></td>
            					<td><?php echo e(($archive->status) ? $status[$archive->status] : '-'); ?></td>
            					<td><?php echo e(($archive->status == 'reviewed') ? $archive->reviewed_on : '-'); ?></td>
            					<?php if(in_array($role_code, array('admin', 'employee', 'manager'))): ?>
            					<td>
            						<?php if(in_array($role_code, array('admin'))): ?>
                						<?php if(in_array($role_code, array('admin')) && ($archive->status == 'pending')): ?>
                						<a href="<?php echo e(route('archives.supdate', ['archive' => $archive->id, 'locale'=>app()->getLocale(), 'status'=>'reviewed'])); ?>" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.approve')); ?>"><i class="flaticon2-check-mark"></i></a>
                						<?php endif; ?>
                						<!-- Delete -->
                                    	<form id="delete_form_<?php echo e($archive->id); ?>" name="delete_form" action="<?php echo e(route('archives.destroy', ['archive' => $archive->id, 'locale'=>app()->getLocale()])); ?>" method="post" class="btn btn-icon btn-xs">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.delete_title', ['title'=>trans_choice('form.label.form', 1)])); ?>"><i class="flaticon-delete"></i></button>
                                        </form>
                                    	<!-- End: Delete -->
                                	<?php endif; ?>
                                	
                                	
                                		<?php if($archive->status == 'employee' && $archive->user_id==Auth::id()): ?>
                                		<button class="btn btn-icon btn-xs btn-outline-info" 
                                			data-toggle="modal" 
                                			data-target="#status-modal" 
                                			data-review-type="<?php echo e($archive->form_data ? $archive->form_data->review_type->name : '-'); ?>" 
                                			data-year="<?php echo e(($archive->form_data) ? $archive->form_data->year : '-'); ?>" 
                                			data-id="<?php echo e($archive->id); ?>"
                                			data-url = "<?php echo e(route('archives.update', ['archive' => $archive->id, 'locale'=>app()->getLocale()])); ?>">
                                			
                                			<i class="flaticon2-check-mark"></i>
                            			</button>
                                		<?php endif; ?>
                                	
        						</td>
        						<?php endif; ?>
            				</tr>
        				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        			</tbody>
        		</table>
        	</div>
    	</div>
    </div>
</div>

<!-- start: Modal to add final -->
<div class="modal fade" id="status-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="status-form" class="form" method="POST" action="">
        	<?php echo csrf_field(); ?>
        	<?php echo method_field('PATCH'); ?>
        	<input type="hidden" name="status" value="pending"/>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="status-modal-label"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="form-group">
                		<div class="radio-list">
                            <label class="radio read-content">
                                <input type="radio" name="content" value="read" required="required"/>
                                <span></span>
                                <div><?php echo e(__('form.label.read_content')); ?></div>
                            </label>
                            <label class="radio note-content">
                                <input type="radio" name="content" value="note" required="required"/>
                                <span></span>
                                <div><?php echo e(__('form.label.note_content')); ?></div>
                            </label>
                        </div>
            		</div>
            		<div class="form-group">
						<label class="font-weight-bold"><?php echo e(__('form.label.enter_full_name')); ?>: *</label>
            			<input type="text" class="form-control" name="full_name" required="required"/>
            		</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><?php echo e(__('form.label.close')); ?></button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><?php echo e(__('form.label.submit')); ?></button>
                </div>
            </div>
    	</form>
    </div>
</div>
<!-- end: Modal to add final -->
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
$(function() {
	$('#status-modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var review_type = button.data('review-type');
		var year = button.data('year');
		var url = button.data('url');
		
		$('#status-modal .modal-title').html(review_type+' '+year);
		var read_content = "<?php echo e(__('form.label.read_content')); ?>";
		var note_content = "<?php echo e(__('form.label.note_content')); ?>";

		$('#status-modal label.read-content div').html(read_content.replace(/:review_type/g, review_type));
		$('#status-modal label.note-content div').html(note_content.replace(/:review_type/g, review_type));
		$('#status-modal').find('#status-form').attr('action', url);
		$('#status-modal').find('input[name="full_name"]').val('');
		$('#status-modal').find('input[type="radio"]').prop('checked', false);
	});
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/elements/archives.blade.php ENDPATH**/ ?>