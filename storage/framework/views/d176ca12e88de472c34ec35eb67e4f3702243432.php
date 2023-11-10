<div class="col-lg-12">
	<!--begin::List Widget 9-->
	<div class="card card-custom card-stretch gutter-b">
		<!--begin::Header-->
		<div class="card-header">
            <div class="card-title">
            	<div class="card-label font-weight-bolder text-bblack"><?php echo e(__('form.label.progress')); ?></div>
            </div>
            <?php if($role_code != 'employee'): ?>
            <div class="card-toolbar">
            	<div class="">
        			<select name="user_id" class="form-control" onchange="get_archive(this, '');">
        				<option value=""><?php echo e(__('form.label.select').' '.trans_choice('menu.user', 1)); ?></option>
            			<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            				<option value="<?php echo e($user->id); ?>"><?php echo e($user->last_name.', '.$user->first_name); ?></option>
            			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        			</select>
        		</div>
            </div>
            <?php endif; ?>
        </div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body">
			<!--begin::Chart-->
			<div id="progress_chart" class="text-center"></div>
			<!--end::Chart-->
		</div>
		<!--end: Card Body-->
	</div>
	<!--end: List Widget 9-->
</div>
<?php $__env->startPush('scripts'); ?>
<script>
$(function() {
	var loggedin_id = '<?php echo e(Auth::id()); ?>';
	var user_role = '<?php echo e($role_code); ?>';
	if(user_role == 'employee') {
		get_archive('', loggedin_id);
	}
});

function get_archive(obj, loggedin_user_id) {
	var user_id = '';
	if(loggedin_user_id != '') {
		user_id = loggedin_user_id;
	}else {
		user_id = $(obj).val();
	}
		
	var url = "<?php echo e(route('form_data.get_data', ['locale'=>app()->getLocale()])); ?>";
	$.ajax({
        url: url,
        type: 'POST',
        dataType: "json",
        data: {'_token': '<?php echo e(csrf_token()); ?>', 'user_id':user_id},
        success: function (result){
        	var ratings = <?php echo json_encode($ratings); ?>;
            var sub_categories = result.sub_categories;
            var _sub_categories = [];
            $.each(sub_categories, function( index, sub_category ) {
            	_sub_categories.push(sub_category.<?php echo $sub_cat_field;?>);
            	
            	/*var sub_cat = (sub_category.<?php echo $sub_cat_field;?>).split(" ");
            	sub_cat.forEach(function(item, i, title){
            	  	if(i==1 || i==3)
            	    	title[i] += "<br/>";
            	  	else
            	  	title[i] += ' ';
            	});
            	var sub_cat_arr = [sub_cat.join('').split("<br/>")];
            	_sub_categories.push(sub_cat.join('').split("<br/>"));*/
            });
            
        	// Shared Colors Definition
        	const col1 = '#88a9c3';
        	const col2 = '#e2d6c9';
        	const col3 = '#123948';
        	const col4 = '#f4a215';
        	const col5 = '#e8ded3';
        	const apexChart = "#progress_chart";
        	var allowChartUpdate = true;
    		var options = {
    			series: [],
    			chart: {
    				type: 'bar',
    				height: 450,
    				toolbar: { show: false },
    			},
    			plotOptions: {
    				bar: {
    					horizontal: true,
    					columnWidth: '55%',
    					endingShape: 'rounded',
    					dataLabels: {
    				        position: 'bottom',
    				        /* offsetY: -15,
    				        offsetX: -15,
    				        offset: -15 */
				      	}
    				},
    			},
    			dataLabels: {
    				enabled: true,
    				formatter: function (val, opt) {
    					return opt.w.globals.seriesNames[opt.seriesIndex] + ":  " + ratings[val]
		          	},
		          	offsetX: 0,
		          	textAnchor: 'start',
    			},
    			stroke: {
    				show: true,
    				width: 2,
    				colors: ['transparent']
    			},
    			xaxis: {
    				categories: _sub_categories,
    				labels: {
  				    	show: true,
  				      	formatter: function (val) {
    						return ratings[val]
    					},
  				    },
    			},
    			yaxis: {
    				title: {
    					text: ''
    				},
    				labels: {
    					minWidth: 0,
    					maxWidth: 700,
    				}
    			},
    			fill: {
    				opacity: 1
    			},
    			tooltip: {
    				y: {
    					formatter: function (val) {
    						return ratings[val]
    					}
    				}
    			},
    			colors: [col1, col2]
    		};

    		var chart = new ApexCharts(document.querySelector(apexChart), options);
    		if(result.series != '') {
        		chart.render();
        		chart.updateSeries(result.series);
            }else {
            	//chart.destroy();
            	chart = null;
                $('#progress_chart').html('<span class="font-weight-bold text-bblack"><?php echo e(__("messages.no_data")); ?></span>');
            }
        }
    });
}
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/elements/progress.blade.php ENDPATH**/ ?>