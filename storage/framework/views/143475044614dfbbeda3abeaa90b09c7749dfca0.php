
<?php
    list($controller, $action) = getActionName();
    $role_code = Auth::user()->user_role->role_code;
    $status = __('form.array.status');
    $form_data_btn = __('form.array.form_data_btn');
    $role_field = 'role_'.app()->getLocale();
    $manager_text = $user_roles->firstWhere('role_code', 'manager');
    $review_type_1 = $review_types->firstWhere('number', 1);
    $review_type_2 = $review_types->firstWhere('number', 2);
    $review_type_3 = $review_types->firstWhere('number', 3);
?>
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
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.flash-message','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('flash-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.set-titles','data' => ['page' => ''.e($controller.'_'.$action).'','module' => ''.e(trans_choice('menu.user', 1)).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('set-titles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => ''.e($controller.'_'.$action).'','module' => ''.e(trans_choice('menu.user', 1)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

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
				<?php echo __('messages.expl_users_'.$role_code); ?>

            </div>
        </div>
    </div>
</div>
        
<div class="card card-custom">
	<div class="card-body">
		<input type="hidden" id="mng_btn_text" value="<?php echo e(trans_choice('form.label.manager', 1)); ?>">
		<input type="hidden" id="role_code" value="<?php echo e($role_code); ?>">
		
		<?php if(!in_array($role_code, array('manager'))): ?>
		<div class="row mb-5">
			<div class="col-lg-3">
				<label class="font-weight-bold">
					<?php echo e(__('form.label.role')); ?>:
					<a href="#" class="btn btn-icon btn-xs btn-light-primary btn-circle" data-toggle="tooltip" data-placement="right" title="<?php echo e(__('messages.role_dd_text')); ?>">
    					<i class="fas fa-info-circle"></i>
    				</a>
				</label>
				<select name="user_role_id" class="form-control datatable-input"  data-col-index="2">
    				<option value=""><?php echo e(__('form.label.all')); ?></option>
        			<?php $__currentLoopData = $user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        				<option value="<?php echo e($user_role->id); ?>"><?php echo e($user_role->$role_field); ?></option>
        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    			</select>
			</div>
			<div class="col-lg-3">
				<label class="font-weight-bold">
					<?php echo e(trans_choice('form.label.manager', 1)); ?>:
					<a href="#" class="btn btn-icon btn-xs btn-light-primary btn-circle" data-toggle="tooltip" data-placement="right" title="<?php echo e(__('messages.emp_dd_text')); ?>">
    					<i class="fas fa-info-circle"></i>
    				</a>
				</label>
				<select name="manager_id" class="form-control datatable-input"  data-col-index="5">
    				<option value=""><?php echo e(__('form.label.all')); ?></option>
        			<?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid=>$manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        				<option value="<?php echo e($mid); ?>"><?php echo e($manager); ?></option>
        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    			</select>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<?php if(!in_array($role_code, array('manager'))): ?>
    					<th></th>
    					<th class="d-none"></th>
    					<th class="d-none"></th>
    					<?php endif; ?>
    					<th><?php echo e(__('form.label.name')); ?></th>
    					<th><?php echo e(__('form.label.function')); ?></th>
    					<th><?php echo e($manager_text->$role_field); ?></th>
    					<th><?php echo e(__('form.label.performance_actions')); ?></th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    					<?php
    					$step = -1;
    					$form_data = array();
    					$form = $user->form->where('completed', 'no')->sortDesc()->first();
    					if($form) {
    						$step = 0;
                            if($form->form_data) {
                                $form_data = $form->form_data->where('year', '!=', null)->sortDesc()->first();
                            }
                        }
                        if($form_data) {
                        	$step = $form_data->review_type->number;
                        }
    					?>
    					<tr>
        					<?php if(!in_array($role_code, array('manager'))): ?>
        					<td></td>
        					<td class="d-none"><?php echo e($user->id); ?></td>
        					<td class="d-none"><?php echo e($user->user_role->$role_field); ?></td>
        					<?php endif; ?>
        					<td><span data-toggle="popover" data-placement="right" data-html="true" data-content="<?php echo e($user->user_role->$role_field); ?>"><?php echo e($user->full_name); ?></span></td>
        					<td><?php echo e($user->function); ?></td>
        					<td><?php echo e(($user->manager) ? $user->manager->full_name : '-'); ?></td>
        					<td>
        						<?php if(in_array($role_code, array('admin', 'manager')) && $user->manager): ?>
        						<!-- <a href="" class="btn btn-icon btn-xs btn-outline-primary" data-toggle="tooltip" data-placement="top" title=""><i class="flaticon2-graphic"></i></a> -->
        						<a href="<?php echo e(url(app()->getLocale().'/competencies/'.$user->id)); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=-1) ? 'btn-primary' : 'btn-outline-primary'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans_choice('form.label.goal', 2)); ?>"><i class="flaticon-cogwheel"></i></a>
        						<?php endif; ?>
        						
        						<?php if(in_array($role_code, array('admin', 'manager')) && $form): ?>
        							<?php
        								$show = true;
        								if	($role_code=='manager' && $user->manager_id!=Auth::id())
        								{
        									$show = false;
        								}
        							?>
        							<?php if($show): ?>
                						<a href="<?php echo e(route('form_data.view', ['form_datum' => base64_encode($user->id.'/1'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)])); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=0) ? 'btn-success' : 'btn-outline-success'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($review_type_1->name); ?>" data-step="<?php echo e($step); ?>" data-btn="1"><?php echo e($form_data_btn['1']['label']); ?></a>
                                        <a data-url="<?php echo e(route('form_data.view', ['form_datum' => base64_encode($user->id.'/2'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)])); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=1) ? 'btn-success' : 'btn-outline-success'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($review_type_2->name); ?>" data-step="<?php echo e($step); ?>" onclick="check_progress(this);" data-btn="2"><?php echo e($form_data_btn['2']['label']); ?></a>
                                        <a data-url="<?php echo e(route('form_data.view', ['form_datum' => base64_encode($user->id.'/3'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)])); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=2) ? 'btn-success' : 'btn-outline-success'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($review_type_3->name); ?>" data-step="<?php echo e($step); ?>" onclick="check_progress(this);" data-btn="3"><?php echo e($form_data_btn['3']['label']); ?></a>
                                    <?php endif; ?>
        						<?php endif; ?>
        						
        						<?php if(!in_array($role_code, array('manager'))): ?>
        						<a href="<?php echo e(route('users.edit', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.update')); ?>"><i class="flaticon-edit"></i></a>
        						<a href="<?php echo e(route('users.show', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.view')); ?>"><i class="flaticon-eye"></i></a>
        						<!-- Delete -->
                            	<form id="delete_form_<?php echo e($user->id); ?>" name="delete_form" action="<?php echo e(route('users.destroy', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>" method="post" class="btn btn-icon btn-xs">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.delete')); ?>"><i class="flaticon-delete"></i></button>
                                </form>
                            	<!-- End: Delete -->
                            	<?php endif; ?>
                            	
                            	<?php if(in_array($role_code, array('admin', 'manager')) && $form): ?>
        						<a href="<?php echo e(route('archives.show', ['archive' => $user->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans_choice('menu.archive', 1)); ?>"><i class="fa fa-archive"></i></a>
        						<a href="<?php echo e(route('logs.view', ['module_id' => $user->id, 'module'=>'user', 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans_choice('menu.log', 2)); ?>"><i class="flaticon-file-2"></i></a>
        						<?php endif; ?>
        					</td>
        				</tr>
    				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    			</tbody>
    		</table>
    	</div>
	</div>
</div>

<!-- start: Modal to plan -->
<div class="modal fade" id="link-mng-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="link-mng-form" class="form" method="POST" action="<?php echo e(route('users.update_mng', ['locale'=>app()->getLocale()])); ?>">
        	<?php echo csrf_field(); ?>
        	<input type="hidden" name="user_ids">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="link-mng-label"><?php echo e(__('form.label.link').' '.trans_choice('form.label.manager', 1)); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="form-group">
            			<select name="manager_id" class="form-control">
            				<option value=""><?php echo e(__('form.label.select').' '.trans_choice('form.label.manager', 1)); ?></option>
                			<?php $__currentLoopData = $users_to_link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uid=>$user_to_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                				<option value="<?php echo e($uid); ?>"><?php echo e($user_to_link); ?></option>
                			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            			</select>
            		</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><?php echo e(__('form.label.close')); ?></button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><?php echo e(__('form.label.save')); ?></button>
                </div>
            </div>
    	</form>
    </div>
</div>
<!-- end: Modal to plan -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	
});
function check_progress(obj) {
	var step = $(obj).data('step');
	step = step + 1;
	if(step < $(obj).data('btn')) {
		var msg = '';
		if(step == '1') {
			msg = "<?php echo e(__('messages.p_validation')); ?>";
		}else if(step == '2') {
			msg = "<?php echo e(__('messages.f_validation')); ?>";
		}
		Swal.fire(msg, "", "info");
		return false;
	}else {
		window.location.href = $(obj).data('url');
	}
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/users/index.blade.php ENDPATH**/ ?>