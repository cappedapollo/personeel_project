@foreach($yearly_review_types as $review_type)
    <div class="col-lg-6 col-xxl-4">
    	<!--begin::List Widget 9-->
    	<div class="card card-custom card-stretch gutter-b">
    		<!--begin::Header-->
    		<div class="card-header">
                <div class="card-title align-items-start flex-column">
                	<span class="card-label font-weight-bolder text-bblack">{{ $review_type->name }}</span>
                	<span class="mt-3 font-weight-light font-size-lg">{{ __('form.label.signing_employees') }}</span>
                </div>
            </div>
    		<!--end::Header-->
    		<!--begin::Body-->
    		<div class="card-body">
    			<!--begin::Chart-->
    			<div id="executed_chart_{{ $review_type->id }}" class="d-flex justify-content-center"></div>
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
	const primary = '#c33332';
	const success = '#88a9c3';
	const warning = '#e8ded3';

	var review_types = '<?php echo json_encode($yearly_review_types); ?>';
	$.each($.parseJSON(review_types), function( index, review_type ) {

		var agree_count = review_type.agree_count;
		var took_note_count = review_type.took_note_count;
		var not_sign_count = review_type.not_sign_count;
		const apexChart = "#executed_chart_"+review_type.id;
		var options = {
			/*title: {
			    text: '{{ __("form.label.executed") }}',
			    align: 'center',
			},*/
			series: [{
				name: '{{ __("form.label.agree") }}',
				data: [agree_count]
			}, {
				name: '{{ __("form.label.took_note") }}',
				data: [took_note_count]
			}, {
				name: '{{ __("form.label.not_sign") }}',
				data: [not_sign_count]
			}],
			chart: {
				type: 'bar',
				height: 230,
				toolbar: { show: false },
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: [''],
			},
			yaxis: {
				title: {
					text: ''
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val
					}
				}
			},
			colors: [primary, success, warning]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	});
});
</script>
@endpush