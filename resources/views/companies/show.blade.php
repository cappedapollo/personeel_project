@extends('layout.app')
@push('scripts')
@foreach(config('layout.resources.index_js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
@endforeach
@endpush
@php
$languages = __('form.array.lang');
$status = __('form.array.status');
$ur_field = 'role_'.app()->getLocale();
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b card-stretch">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ trans_choice('menu.company', 1).' '.trans_choice('form.label.detail', 2) }}:</h3>
                </div>
            </div>
            <div class="card-body">
        		<div class="d-flex align-items-center justify-content-between mb-2">
        			<span class="font-weight-bold mr-2">{{ __('form.label.name') }}:</span>
        			<span class="text-muted">{{ $company->name }}</span>
        		</div>
        		<div class="d-flex align-items-center justify-content-between mb-2">
        			<span class="font-weight-bold mr-2">{{ __('form.label.coc') }}:</span>
        			<span class="text-muted">{{ $company->chamber_of_commerce ? $company->chamber_of_commerce : '-' }}</span>
        		</div>
        		<div class="d-flex align-items-center justify-content-between mb-2">
        			<span class="font-weight-bold mr-2">{{ __('form.label.address') }}:</span>
        			<span class="text-muted">{{ $company->address ? $company->address : '-' }}</span>
        		</div>
        		<div class="d-flex align-items-center justify-content-between mb-2">
        			<span class="font-weight-bold mr-2">{{ __('form.label.country') }}:</span>
        			<span class="text-muted">{{ $company->country ? $company->country->name : '-' }}</span>
        		</div>
        		<div class="d-flex align-items-center justify-content-between">
        			<span class="font-weight-bold mr-2">{{ __('form.label.lang') }}:</span>
        			<span class="text-muted">{{ $company->language ? $languages[$company->language] : '-' }}</span>
        		</div>
            </div>
        </div>
        <!--end::Card-->
	</div>
	<div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b card-stretch">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ trans_choice('menu.company', 1).' '.__('form.label.logo') }}:</h3>
                </div>
            </div>
            <div class="card-body">
            	@php
            	$clogo = ($company->file) ? getLinkFromBucket($company->file->file_key) : '';
            	//$document_url = getLinkFromBucket($file->file_key);
            	@endphp
        		<img alt="{{ $company->name }}" src="{{ $clogo }}" class="max-h-150px">
            </div>
        </div>
        <!--end::Card-->
	</div>
</div>

<!-- user list -->
<div class="card card-custom">
	<div class="card-header">
        <div class="card-title">
            <h3 class="card-label">{{ trans_choice('menu.user', 1).' '.__('menu.list') }}:</h3>
        </div>
    </div>
	<div class="card-body">
		<input type="hidden" id="delete_title_text" value="{{__('messages.delete_title')}}">
		<input type="hidden" id="delete_conf_text" value="{{__('messages.delete_conf')}}">
		<input type="hidden" id="cancel_text" value="{{__('form.label.cancel')}}">
		
		<div class="table-responsive">
    		<table class="table table-hover">
    			<thead>
    				<tr>
    					<th>{{ __('form.label.first_name') }}</th>
    					<th>{{ __('form.label.last_name') }}</th>
    					<th>{{ __('form.label.email') }}</th>
    					<th>{{ __('form.label.role') }}</th>
    					<th>{{ __('form.label.status') }}</th>
    					<th>{{ __('form.label.telephone') }}</th>
    					<th>{{ trans_choice('form.label.action', 2) }}</th>
    				</tr>
    			</thead>
    			<tbody>
    				@if($company->company_user)
    					@foreach($company->company_user as $cuser)
    						@php
    						$user_id = ($cuser->user) ? $cuser->user->id : '0';
    						@endphp
        				<tr>
        					<td>{{ $cuser->user ? $cuser->user->first_name : '-' }}</td>
        					<td>{{ $cuser->user ? $cuser->user->last_name : '-' }}</td>
        					<td>{{ $cuser->user ? $cuser->user->email : '-' }}</td>
        					<td>{{ $cuser->user ? $cuser->user->user_role->$ur_field : '-' }}</td>
        					<td>{{ $cuser->user ? $status[$cuser->user->status] : '-' }}</td>
        					<td>{{ $cuser->user ? $cuser->user->telephone : '-' }}</td>
        					<td>
        						@if($cuser->user && $cuser->user->status=='inactive')
        						<a href="{{ route('users.supdate', ['user' => $user_id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.activate').' '.trans_choice('menu.user', 1) }}"><i class="flaticon2-check-mark"></i></a>
        						@endif
        						<a href="{{ route('users.edit', ['user' => $user_id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.update') }}"><i class="flaticon-edit"></i></a>
    							<!-- Delete -->
                            	<form id="delete_form_{{ $user_id }}" name="delete_form" action="{{ route('users.destroy', ['user' => $user_id, 'locale'=>app()->getLocale()]) }}" method="post" class="btn btn-icon btn-xs">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.delete') }}"><i class="flaticon-delete"></i></button>
                                </form>
                            	<!-- End: Delete -->
        					</td>
        				</tr>
        				@endforeach
        			@endif
    			</tbody>
    		</table>
    	</div>
	</div>
</div>
@endsection