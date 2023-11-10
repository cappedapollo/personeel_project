@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
<script src="{{ asset(config('layout.resources.custom_js')) }}" type="text/javascript"></script>
@endpush
@php
$languages = __('form.array.lang');
$country_codes = __('form.array.country_codes');
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		<div class="card gutter-b">
			<div class="card-body">
				<div>{!! __('messages.registration_text') !!}</div>
			</div>
		</div>
		
		<div class="card card-custom gutter-b">
			<form id="kt_form" class="form" method="POST" enctype="multipart/form-data" action="{{ route('companies.store', [app()->getLocale()]) }}">
            	@csrf
            	<div class="card-body">
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.company_name') }}: *</label>
                    			<input type="text" class="form-control" name="name" value="{{ old('name') }}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.company_name')])}}"/>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.coc') }}:</label>
                    			<input type="text" class="form-control" name="chamber_of_commerce" value="{{ old('chamber_of_commerce') }}"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.address') }}: *</label>
                    			<input type="text" class="form-control" name="address" value="{{ old('address') }}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.address')])}}"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.country') }}: *</label>
                    			<select name="country_id" class="form-control" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.country')])}}">
                    				<option value="">{{ __('form.label.select').' '.__('form.label.country') }}</option>
                        			@foreach ($countries as $cid=>$country)
                        				<option value="{{$cid}}" {{ $cid==old('country_id') ? 'selected' : '' }}>{{$country}}</option>
                        			@endforeach
                    			</select>
                    		</div>
                		</div>
                    </div>
                    <div class="row">
            			<div class="col-xl-3">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.lang') }}: *</label>
                    			<select name="language" class="form-control" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.lang')])}}">
                    				<option value="">{{ __('form.label.select').' '.__('form.label.lang') }}</option>
                        			@foreach ($languages as $id=>$language)
                        				<option value="{{$id}}" {{ $id==old('language') ? 'selected' : '' }}>{{$language}}</option>
                        			@endforeach
                    			</select>
                    		</div>
                    	</div>
                    	<div class="col-xl-3">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ trans_choice('form.label.employee', 2) }}:</label>
                    			<select name="employee_no_id" class="form-control">
                    				<option value="">{{ __('form.label.select').' '.trans_choice('form.label.employee', 2) }}</option>
                        			@foreach ($n_employees as $id=>$n_employee)
                        				<option value="{{ $id }}" {{ $id==old('employee_no_id') ? 'selected' : '' }}>{{$n_employee}}</option>
                        			@endforeach
                    			</select>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">
                    				{{ __('form.label.upload').' '.__('form.label.logo') }}: 
                    				<a href="#" class="btn btn-icon btn-xs btn-light-primary btn-circle" data-toggle="tooltip" data-placement="right" title="{{ __('messages.clogo_validation') }}">
                    					<i class="fas fa-info-circle"></i>
                    				</a>
                				</label>
                    			<div class="custom-file">
                					<input type="file" class="custom-file-input" id="logo" name="logo"/>
                					<label class="custom-file-label" for="logo">{{ __('form.label.choose_file') }}</label>
                				</div>
                    		</div>
                		</div>
            		</div>
            		
            		<h3 class="font-size-lg text-dark font-weight-bold mt-10 mb-6">{{ __('form.label.hr_cperson') }}:</h3>
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.first_name') }}: *</label>
                    			<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.first_name')])}}"/>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.last_name') }}: *</label>
                    			<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.last_name')])}}"/>
                    		</div>
                		</div>
            		</div>
                    <div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.telephone') }}: *</label>
                    			<input type="text" class="form-control" name="telephone" value="{{ old('telephone') }}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.telephone')])}}"/>
                    		</div>
                    	</div>
                		<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.email') }}: *</label>
                    			<input type="email" class="form-control" name="email" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.email')])}}" value="{{ old('email') }}" data-fv-email-address___message="{{__('validation.email', ['attribute' => __('form.label.email')])}}"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.function') }}:</label>
                    			<input type="text" class="form-control" name="function" value="{{ old('function') }}"/>
                    		</div>
                    	</div>
                	</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2">{{ __('form.label.submit') }}</button>
            	</div>
            </form>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
	initialize_file();
});
</script>
@endpush