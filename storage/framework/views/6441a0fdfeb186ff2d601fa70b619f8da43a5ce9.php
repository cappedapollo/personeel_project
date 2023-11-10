
<?php
    list($controller, $action) = getActionName();
    $role_field = 'role_'.app()->getLocale();
    $form_data_btn = __('form.array.form_data_btn');
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

<div class="card card-custom">
	<div class="card-body">
		

		<div class="row mb-2">
			<div class="col-6"></div>
			<div class="col-3">
				<a target="_blank" href="https://login.celerypayroll.com/oauth2/authorize?client_id=8f771a5a-15a9-47ab-9670-1f8c09a1722b&response_type=code&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fcelery%2Fcallback"
				class="btn btn-sm btn-block btn-primary">OAuth Code</a>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<input type="text" class="form-control form-control-sm" id="code" placeholder="Code">
			</div>
			<div class="col-3">
				<button class="btn btn-sm btn-primary btn-block" onclick="AuthToken()">Auth Token</button>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<input type="text" class="form-control form-control-sm" id="token" placeholder="Token">
			</div>
			<div class="col-3">
				<button class="btn btn-sm btn-primary btn-block" onclick="GetContext()">Get Context</button>
			</div>
		</div>

		<div class="row mb-2">
			<div class="col-6">
				<input type="text" class="form-control form-control-sm" id="context_id" placeholder="Context">
			</div>
			<div class="col-3">
				<button class="btn btn-sm btn-primary btn-block" onclick="GetEmployers()">Get Employers</button>
			</div>
		</div>

		<div class="row mb-2">
			<div class="col-6">
				<input type="text" class="form-control form-control-sm" id="employer_id" placeholder="Employer">
			</div>
			<div class="col-3">
				<button class="btn btn-sm btn-primary btn-block" onclick="GetEmployees()">Get Employees</button>
			</div>
		</div>

		<input type="hidden" id="mng_btn_text" value="<?php echo e(trans_choice('form.label.manager', 1)); ?>">
		
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<th><?php echo e(__('form.label.name')); ?></th>
    					<th><?php echo e(__('form.label.function')); ?></th>
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
        					<td><span data-toggle="popover" data-placement="right" data-html="true" data-content="<?php echo e($user->user_role->$role_field); ?>"><?php echo e($user->full_name); ?></span></td>
        					<td><?php echo e($user->function); ?></td>
        					<td>
        						<a href="<?php echo e(url(app()->getLocale().'/competencies/'.$user->id)); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=-1) ? 'btn-primary' : 'btn-outline-primary'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans_choice('form.label.goal', 2)); ?>"><i class="flaticon-cogwheel"></i></a>
        						
        						<?php if($form): ?>
        						<a href="<?php echo e(route('form_data.view', ['form_datum' => base64_encode($user->id.'/1'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)])); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=0) ? 'btn-success' : 'btn-outline-success'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($review_type_1->name); ?>" data-step="<?php echo e($step); ?>" data-btn="1"><?php echo e($form_data_btn['1']['label']); ?></a>
                                <a data-url="<?php echo e(route('form_data.view', ['form_datum' => base64_encode($user->id.'/2'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)])); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=1) ? 'btn-success' : 'btn-outline-success'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($review_type_2->name); ?>" data-step="<?php echo e($step); ?>" onclick="check_progress(this);" data-btn="2"><?php echo e($form_data_btn['2']['label']); ?></a>
                                <a data-url="<?php echo e(route('form_data.view', ['form_datum' => base64_encode($user->id.'/3'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)])); ?>" class="btn btn-icon btn-xs <?php echo e(($step>=2) ? 'btn-success' : 'btn-outline-success'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($review_type_3->name); ?>" data-step="<?php echo e($step); ?>" onclick="check_progress(this);" data-btn="3"><?php echo e($form_data_btn['3']['label']); ?></a>
        						<?php endif; ?>
        						
        						<a href="<?php echo e(route('users.edit', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.update')); ?>"><i class="flaticon-edit"></i></a>
        						<a href="<?php echo e(route('users.show', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.view')); ?>"><i class="flaticon-eye"></i></a>
        						<!-- Delete -->
                            	<form id="delete_form_<?php echo e($user->id); ?>" name="delete_form" action="<?php echo e(route('users.destroy', ['user' => $user->id, 'locale'=>app()->getLocale()])); ?>" method="post" class="btn btn-icon btn-xs">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('form.label.delete')); ?>"><i class="flaticon-delete"></i></button>
                                </form>
                            	<!-- End: Delete -->
                            	
                            	<?php if($form): ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
	function AuthToken() {
		$.ajax({
			url: 'https://login.celerypayroll.com/oauth2/token',
			method: 'POST',
			headers: {
				"Authorization": "Basic <?php echo e(base64_encode("8f771a5a-15a9-47ab-9670-1f8c09a1722b" . ":" . "jXmuW4Vt-3KNH1mcN218fg4Ooh7hcN8OnAP_BjU0LEQ")); ?>",
				"Content-Type": "application/x-www-form-urlencoded"
			},
			data: {
				grant_type: 'authorization_code',
				code: $("#code").val(),
				redirect_uri: "http://127.0.0.1:8000/celery/callback"
			},
			success: function(data) {
				$("#token").val(data["access_token"]);
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	}

	function GetContext() {
		const ACCESS_TOKEN = $("#token").val();
		$.ajax({
			url: '/contexts?token=' + ACCESS_TOKEN,
			method: 'GET',
			success: function(data) {
				if(data.data.length === 0) alert("no context");
				else $("#context_id").val((data.data[0].id));
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	}

	function GetEmployers() {
		const ACCESS_TOKEN = $("#token").val();
		const CONTEXT_ID = $("#context_id").val();
		$.ajax({
			url: '/employers?token=' + ACCESS_TOKEN + '&context_id=' + CONTEXT_ID,
			method: 'GET',
			success: function(data) {
				if(data.data.length === 0) alert("no employer");
				else $("#employer_id").val((data.data[0].id));
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	}

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
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/users/employees.blade.php ENDPATH**/ ?>