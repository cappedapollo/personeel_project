@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
@endpush
@php
$status = __('form.array.status');
$role_code = $user->user_role->role_code;
$rfield = 'role_'.app()->getLocale();
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b example example-compact">
			<form id="kt_form" class="form" method="POST" action="{{ route('users.update', ['user' => $user->id, 'locale'=>app()->getLocale()]) }}">
            	@csrf
            	@method('PATCH')
            	<div class="card-body">
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.role') }}: *</label>
                    			<select name="user_role_id" class="form-control" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.role')]) }}">
                    				<option value="">{{ __('form.label.select').' '.__('form.label.role') }}</option>
                        			@foreach ($user_roles as $id=>$user_role)
                        				<option value="{{ $user_role->id }}" {{ $user_role->id==$user->user_role_id ? 'selected' : '' }} data-code="{{ $user_role->role_code }}">{{ $user_role->$rfield }}</option>
                        			@endforeach
                    			</select>
                    		</div>
                		</div>
                		<div class="col-xl-6 mng-dropdown {{ in_array($role_code, ['employee', 'manager']) ? '' : 'd-none'}}">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ trans_choice('form.label.manager', 1) }}:</label>
                    			<select name="manager_id" class="form-control">
                    				<option value="">{{ __('form.label.select').' '.trans_choice('form.label.manager', 1) }}</option>
                        			@foreach ($managers as $mid=>$manager)
                        				<option value="{{$mid}}" {{ ($mid==$user->manager_id) ? 'selected' : '' }}>{{$manager}}</option>
                        			@endforeach
                    			</select>
                    		</div>
                		</div>
            		</div>
            		<div class="row">
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.first_name') }}: *</label>
                    			<input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required data-fv-not-empty___message="{{ __('validation.required', ['attribute' => __('form.label.first_name')]) }}" value="{{ old('first_name') }}"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.last_name') }}: *</label>
                    			<input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required data-fv-not-empty___message="{{ __('validation.required', ['attribute' => __('form.label.last_name')]) }}" value="{{ old('last_name') }}"/>
                    		</div>
                    	</div>
                    </div>
                    <div class="row">
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.email') }}: *</label>
                    			<input type="email" class="form-control" name="email" value="{{ $user->email }}" required data-fv-not-empty___message="{{ __('validation.required', ['attribute' => __('form.label.email')]) }}" data-fv-email-address___message="{{ __('validation.email', ['attribute' => __('form.label.email')]) }}"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.function') }}:</label>
                    			<input type="text" class="form-control" name="function" value="{{ $user->function }}"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.status') }}: *</label>
                    			<select name="status" class="form-control" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.status')]) }}">
                    				<option value="">{{ __('form.label.select').' '.__('form.label.status') }}</option>
                        			@foreach ($status as $key=>$value)
                        				<option value="{{ $key }}" {{ $key==$user->status ? 'selected' : '' }}>{{ $value }}</option>
                        			@endforeach
                    			</select>
                    		</div>
                		</div>
            		</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2">{{ __('form.label.save') }}</button>
            		<a class="btn btn-secondary" href="{{ url(app()->getLocale().'/users') }}">{{ __('form.label.cancel') }}</a>
            	</div>
            </form>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
	var role_code = '{{ $role_code }}';
	var has_manager = '';
	if($.inArray(role_code, ['employee', 'manager']) != -1) {
		has_manager = 'yes';
	}
	set_company(has_manager);

	$( "select[name=user_role_id]" ).change(function() {
		var text = $('option:selected', this).data('code');
		if($.inArray(text, ['employee', 'manager']) != -1) {
			text = 'yes';
		}
		set_company(text);
	});
});

function set_company(has_manager) {
	//validation.addField('manager_id', {validators: {notEmpty: { message: "{{__('validation.required', ['attribute' => trans_choice('form.label.manager', 1) ])}}" }}});
	if(has_manager == 'yes') {
		$('.mng-dropdown').removeClass('d-none');	
	}else{
		//validation.removeField('manager_id');
		$('.mng-dropdown select').prop('value', '');
		$('.mng-dropdown').addClass('d-none');
	}
}
</script>
@endpush