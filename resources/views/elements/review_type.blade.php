@foreach($yearly_review_types as $review_type)
    <div class="col-lg-6 col-xxl-4">
    	<!--begin::List Widget 9-->
    	<div class="card card-custom card-stretch gutter-b">
    		<!--begin::Header-->
    		<div class="card-header">
                <div class="card-title">
                	<div class="card-label font-weight-bolder text-bblack">{{ $review_type->name }}</div>
                </div>
                <div class="card-toolbar">
                	{{-- @if($review_type->archive->count() > 0) --}}
                		<form id="kt_form_{{ $review_type->id }}" class="form" method="POST">
							@csrf
							<input type="hidden" name="review_type_id" value="{{ $review_type->id }}">
                            <select name="year" class="form-control" onchange="get_review_type({{ $review_type->id }});">
                    			@foreach ($review_type->years as $year)
                    				<option value="{{ $year }}" {{ $year==$review_type->selected_year ? 'selected' : '' }}>{{ $year }}</option>
                    			@endforeach
                			</select>
            			</form>
        			{{-- @endif --}}
                </div>
            </div>
    		<!--end::Header-->
    		<!--begin::Body-->
    		<div class="card-body">
    			<!--begin::Chart-->
    			<div id="chart_{{ $review_type->id }}" class="d-flex justify-content-center"></div>
    			<!--end::Chart-->
    		</div>
    		<!--end: Card Body-->
    	</div>
    	<!--end: List Widget 9-->
    </div>
@endforeach
@push('scripts')
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
    		labels: ['{{ __("form.label.pending") }}: '+pending, '{{ __("form.label.executed") }}: '+executed, '{{ __("form.label.approved") }}: '+approved],
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
@endpush