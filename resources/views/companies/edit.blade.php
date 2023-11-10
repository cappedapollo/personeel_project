@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
<script src="{{ asset(config('layout.resources.custom_js')) }}" type="text/javascript"></script>
@endpush
@php
$languages = __('form.array.lang');
$file_key = ($company->file) ? urlencode($company->file->file_key) : '';
$file_url = ($company->file) ? route("files.show", ["file" => $file_key, "locale"=>app()->getLocale()]) : '';
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
			<form id="kt_form" class="form" method="POST" enctype="multipart/form-data" action="{{ route('companies.update', ['company' => $company->id, 'locale'=>app()->getLocale()]) }}">
            	@csrf
            	@method('PATCH')
            	<div class="card-body">
            		<div class="row">
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.company_name') }}: *</label>
                    			<input type="text" class="form-control" name="name" value="{{$company->name}}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.company_name')])}}"/>
                    		</div>
                    	</div>
            			<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.coc') }}: *</label>
                    			<input type="text" class="form-control" name="chamber_of_commerce" value="{{$company->chamber_of_commerce}}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.coc')])}}"/>
                    		</div>
                    	</div>
            		</div>
            		<div class="row">
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.address') }}: *</label>
                    			<input type="text" class="form-control" name="address" value="{{$company->address}}" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.address')])}}"/>
                    		</div>
                    	</div>
                    	<div class="col-xl-6">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.country') }}: *</label>
                    			<select name="country_id" class="form-control" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => __('form.label.country')])}}">
                    				<option value="">{{ __('form.label.select').' '.__('form.label.country') }}</option>
                        			@foreach ($countries as $cid=>$country)
                        				<option value="{{$cid}}" {{$cid==$company->country_id ? 'selected' : ''}}>{{$country}}</option>
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
                    				<option value="">Select Language</option>
                        			@foreach ($languages as $id=>$language)
                        				<option value="{{$id}}" {{$id==$company->language ? 'selected' : ''}}>{{$language}}</option>
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
                        				<option value="{{ $id }}" {{ $id==$company->employee_no_id ? 'selected' : '' }}>{{$n_employee}}</option>
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
                    			<div class="input-group">
                        			<div class="custom-file">
                    					<input type="file" class="custom-file-input" id="logo" name="logo"/>
                    					<label class="custom-file-label" for="logo">{{$company->logo ? $company->file->file_name : __('form.label.choose_file') }}</label>
                    				</div>
                    				@if($company->logo)
                                	<div class="input-group-append">
                        				<a href="{{ $file_url }}" target="_blank" class="btn btn-icon btn-outline-info"><i class="flaticon-download-1"></i></a>
                                	</div>
                                	@endif
                        		</div>
                    		</div>
                		</div>
            		</div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2">{{ __('form.label.save') }}</button>
            		<a class="btn btn-secondary" href="{{ url(app()->getLocale().'/companies') }}">{{ __('form.label.cancel') }}</a>
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