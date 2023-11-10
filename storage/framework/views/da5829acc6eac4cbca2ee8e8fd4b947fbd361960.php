<?php $__currentLoopData = $yearly_review_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-6 col-xxl-4">
    	<!--begin::List Widget 9-->
    	<div class="card card-custom card-stretch gutter-b">
    		<!--begin::Header-->
    		<div class="card-header">
                <div class="card-title">
                	<div class="card-label font-weight-bolder text-bblack"><?php echo e($review_type->name); ?></div>
                </div>
                <div class="card-toolbar">
                	
                		<form id="kt_form_<?php echo e($review_type->id); ?>" class="form" method="POST">
							<?php echo csrf_field(); ?>
							<input type="hidden" name="review_type_id" value="<?php echo e($review_type->id); ?>">
                            <select name="year" class="form-control" onchange="get_review_type(<?php echo e($review_type->id); ?>);">
                    			<?php $__currentLoopData = $review_type->years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    				<option value="<?php echo e($year); ?>" <?php echo e($year==$review_type->selected_year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                    			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                			</select>
            			</form>
        			
                </div>
            </div>
    		<!--end::Header-->
    		<!--begin::Body-->
    		<div class="card-body">
    			<!--begin::Chart-->
    			<div id="chart_<?php echo e($review_type->id); ?>" class="d-flex justify-content-center"></div>
    			<!--end::Chart-->
    		</div>
    		<!--end: Card Body-->
    	</div>
    	<!--end: List Widget 9-->
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	// Shared Colors Definition
	const primary = '#88a9c3';
	const success = '#123948';
	const info = '#e2d6c9';
	const warning = '#FFA800';
	const danger = '#F64E60';

	var review_types = '<?php echo json_encode($yearly_review_types); ?>';
	$.each($.parseJSON(review_types), function( index, review_type )
	{
		var user_count = '<?php echo $users->count(); ?>';
		var executed = review_type.pending_archive;
		var approved = review_type.reviewed_archive;
		var pending = user_count - executed - approved;
		if(pending < 0) {
    		pending = 0;
    	}
		
    	const apexChart = "#chart_"+review_type.id;
    	var options = {
    		series: [pending, executed, approved],
    		chart: {
    			width: 380,
    			type: 'donut',
    		},
    		labels: ['<?php echo e(__("form.label.pending")); ?>: '+pending, '<?php echo e(__("form.label.executed")); ?>: '+executed, '<?php echo e(__("form.label.approved")); ?>: '+approved],
    		responsive: [{
    			breakpoint: 480,
    			options: {
    				chart: {
    					width: 200
    				},
    				legend: {
    					position: 'bottom'
    				}
    			}
    		}],
    		colors: [primary, success, info],
    		tooltip: {
    			enabled: false
			},
    	};
    
    	var chart = new ApexCharts(document.querySelector(apexChart), options);
    	chart.render();
	});
});

function get_review_type(review_type_id) {
	$('#kt_form_'+review_type_id).submit();
}
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/elements/review_type.blade.php ENDPATH**/ ?>