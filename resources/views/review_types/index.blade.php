@extends('layout.app')
@php
list($controller, $action) = getActionName();
@endphp
@push('styles')
@foreach(config('layout.resources.index_css') as $style)
    <link href="{{asset($style)}}" rel="stylesheet" type="text/css"/>
@endforeach
@endpush
@push('scripts')
@foreach(config('layout.resources.index_js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
@endforeach
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
@endpush
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-body">
				<form class="form" method="POST" action="{{ route('review_types.store', ['locale'=>app()->getLocale()]) }}">
                	@csrf
                	<input type="hidden" name="id" value=""/>
                	<div class="row">
                		<div class="col-xl-4">
                    		<div class="form-group">
                    			<input type="text" class="form-control" name="name" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.name')])}}" value="{{ old('name') }}"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-2 action-div">
                    		<div class="form-group">
                    			<button type="submit" class="btn btn-primary mr-2">{{ __('form.label.save') }}</button>
                    		</div>
                    	</div>
                    </div>
                </form>
                <div class="table-responsive">
            		<table class="table table-hover">
            			<thead>
            				<tr>
            					<th>{{ __('form.label.number') }}</th>
            					<th>{{ __('form.label.name') }}</th>
            					<th>{{ trans_choice('form.label.action', 2) }}</th>
            				</tr>
            			</thead>
            			<tbody>
            				@foreach ($review_types as $review_type)
            				<tr>
            					<td>{{ $review_type->number }}</td>
            					<td>{{ $review_type->name }}</td>
            					<td>
            						<button id="{{ $review_type->id }}" class="btn btn-icon btn-xs btn-outline-success update" data-toggle="tooltip" data-placement="top" title="{{__('form.label.update')}}"><i class="flaticon-edit"></i></button>
            					</td>
            				</tr>
            				@endforeach
            			</tbody>
            		</table>
            	</div>
        	</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
	$('.update').on('click', function() {
		//$('.action-div').removeClass('d-none');
		var id = $(this).attr('id');
		var name = $(this).closest('tr').find('td:nth-child(2)').html();
		
		$(this).closest('.card').find('.form input[name=id]').val(id);
		$(this).closest('.card').find('.form input[name="name"]').val(name);
		var card_position = $(this).closest('.card').offset();
		$('html, body').animate({scrollTop: card_position.top-100}, "slow");
	});

	$('.form button[type=reset]').on('click', function() {
		$(this).closest('.card').find('.form input[name=id]').val('');
	});
});
</script>
@endpush