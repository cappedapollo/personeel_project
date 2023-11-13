@extends('layout.app')
@php
    list($controller, $action) = getActionName();
    $role_field = 'role_'.app()->getLocale();
    $form_data_btn = __('form.array.form_data_btn');
    $review_type_1 = $review_types->firstWhere('number', 1);
    $review_type_2 = $review_types->firstWhere('number', 2);
    $review_type_3 = $review_types->firstWhere('number', 3);
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
@endpush
@section('content')
<x-flash-message/>
<x-set-titles page="{{ $controller.'_'.$action }}" module="{{ trans_choice('menu.user', 1) }}"/>

<div class="card card-custom">
	<div class="card-body">

		<input type="hidden" id="mng_btn_text" value="{{ trans_choice('form.label.manager', 1) }}">
		
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<th>{{ __('form.label.name') }}</th>
    					<th>{{ __('form.label.function') }}</th>
    					<th>{{ __('form.label.performance_actions') }}</th>
    				</tr>
    			</thead>
    			<tbody>
    				@foreach ($users as $user)
    					@php
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
    					@endphp
    					<tr>
        					<td><span data-toggle="popover" data-placement="right" data-html="true" data-content="{{ $user->user_role->$role_field }}">{{ $user->full_name }}</span></td>
        					<td>{{ $user->function }}</td>
        					<td>
        						<a href="{{ url(app()->getLocale().'/competencies/'.$user->id) }}" class="btn btn-icon btn-xs {{ ($step>=-1) ? 'btn-primary' : 'btn-outline-primary' }}" data-toggle="tooltip" data-placement="top" title="{{ trans_choice('form.label.goal', 2) }}"><i class="flaticon-cogwheel"></i></a>
        						
        						@if($form)
        						<a href="{{ route('form_data.view', ['form_datum' => base64_encode($user->id.'/1'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)]) }}" class="btn btn-icon btn-xs {{ ($step>=0) ? 'btn-success' : 'btn-outline-success' }}" data-toggle="tooltip" data-placement="top" title="{{ $review_type_1->name }}" data-step="{{ $step }}" data-btn="1">{{ $form_data_btn['1']['label'] }}</a>
                                <a data-url="{{ route('form_data.view', ['form_datum' => base64_encode($user->id.'/2'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)]) }}" class="btn btn-icon btn-xs {{ ($step>=1) ? 'btn-success' : 'btn-outline-success' }}" data-toggle="tooltip" data-placement="top" title="{{ $review_type_2->name }}" data-step="{{ $step }}" onclick="check_progress(this);" data-btn="2">{{ $form_data_btn['2']['label'] }}</a>
                                <a data-url="{{ route('form_data.view', ['form_datum' => base64_encode($user->id.'/3'), 'locale'=>app()->getLocale(), 'random'=>getRandomString(1)]) }}" class="btn btn-icon btn-xs {{ ($step>=2) ? 'btn-success' : 'btn-outline-success' }}" data-toggle="tooltip" data-placement="top" title="{{ $review_type_3->name }}" data-step="{{ $step }}" onclick="check_progress(this);" data-btn="3">{{ $form_data_btn['3']['label'] }}</a>
        						@endif
        						
        						<a href="{{ route('users.edit', ['user' => $user->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.update') }}"><i class="flaticon-edit"></i></a>
        						<a href="{{ route('users.show', ['user' => $user->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.view') }}"><i class="flaticon-eye"></i></a>
        						<!-- Delete -->
                            	<form id="delete_form_{{ $user->id }}" name="delete_form" action="{{ route('users.destroy', ['user' => $user->id, 'locale'=>app()->getLocale()]) }}" method="post" class="btn btn-icon btn-xs">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.delete') }}"><i class="flaticon-delete"></i></button>
                                </form>
                            	<!-- End: Delete -->
                            	
                            	@if($form)
        						<a href="{{ route('archives.show', ['archive' => $user->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-primary" data-toggle="tooltip" data-placement="top" title="{{ trans_choice('menu.archive', 1) }}"><i class="fa fa-archive"></i></a>
        						<a href="{{ route('logs.view', ['module_id' => $user->id, 'module'=>'user', 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-primary" data-toggle="tooltip" data-placement="top" title="{{ trans_choice('menu.log', 2) }}"><i class="flaticon-file-2"></i></a>
        						@endif
        					</td>
        				</tr>
    				@endforeach
    			</tbody>
    		</table>
    	</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
	
});

function check_progress(obj) {
	var step = $(obj).data('step');
	step = step + 1;
	if(step < $(obj).data('btn')) {
		var msg = '';
		if(step == '1') {
			msg = "{{ __('messages.p_validation') }}";
		}else if(step == '2') {
			msg = "{{ __('messages.f_validation') }}";
		}
		Swal.fire(msg, "", "info");
		return false;
	}else {
		window.location.href = $(obj).data('url');
	}
}
</script>
@endpush