@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
@endpush
@php
$role_code = Auth::user()->user_role->role_code;
$disabled = '';
if(in_array($role_code, array('admin', 'matching_user'))) {
	$disabled = 'disabled';
}
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		@if (Auth::user()->first_login == 1)
            <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">{{ __('messages.change_pwd') }}</div>
            </div>
        @endif
		<div class="card card-custom gutter-b">
            <form id="kt_form" class="form" method="POST">
            	@csrf
            	<div class="card-body">
                	<div class="row">
                		<div class="col-xl-6">
                			<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.first_name') }}: *</label>
                    			<input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => 'First name'])}}"/>
                    		</div>
                		</div>
                		<div class="col-xl-6">
                			<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.last_name') }}: *</label>
            					<input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => 'Last name'])}}"/>
                    		</div>
                		</div>
                	</div>
            		
            		<div class="row">
                		<div class="col-xl-6">
                			<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.email') }}: *</label>
                    			<input type="email" class="form-control" name="email" value="{{$user->email}}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => 'Email'])}}" data-fv-email-address___message="{{__('validation.email', ['attribute' => 'Email'])}}"/>
                    		</div>
                		</div>
                		<div class="col-xl-6">
                			<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.telephone') }}:</label>
                    			<input type="number" class="form-control" name="telephone" value="{{$user->telephone}}"/>
                    		</div>
                		</div>
                	</div>
                	
                	<div class="row">
                		<div class="col-xl-6">
                			<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.new_password') }}:</label>
                    			<div class="input-group">
                    				<input type="password" class="form-control" name="password" pattern="((?=.*[A-Z])(?=.*\W).{8,})" title="Password should contain minimum 8 characters with minimimum 1 Capital and 1 symbol" {{Auth::user()->first_login ? 'required' : ''}}/>
                					<div class="input-group-append">
                        				<button type="button" onclick="showPassword('password', this);" class="btn btn-icon btn-outline-info">
                        					<i class="fas fa-eye"></i>
                        					<i class="fas fa-eye-slash d-none"></i>
                        				</button>
                                	</div>
                				</div>
                    		</div>
                		</div>
                		<div class="col-xl-6">
                			<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.confirm').' '.__('form.label.new_password') }}:</label>
                    			<div class="input-group">
                    				<input type="password" class="form-control" name="password_confirmation" pattern="((?=.*[A-Z])(?=.*\W).{8,})" title="Password should contain minimum 8 characters with minimimum 1 Capital and 1 symbol" {{Auth::user()->first_login ? 'required' : ''}}/>
                					<div class="input-group-append">
                        				<button type="button" onclick="showPassword('password_confirmation', this);" class="btn btn-icon btn-outline-info">
                        					<i class="fas fa-eye"></i>
                        					<i class="fas fa-eye-slash d-none"></i>
                        				</button>
                                	</div>
                				</div>
                    		</div>
                		</div>
                	</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2">{{ __('form.label.save') }}</button>
            	</div>
            </form>
    	</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
function showPassword(ele, obj) {
	$(obj).find('i').toggleClass('d-none');
	var type = $('input[name='+ele+']').attr('type');
	var _type = (type=='password') ? 'text' : 'password';
	$('input[name='+ele+']').attr('type', _type);
}
</script>
@endpush