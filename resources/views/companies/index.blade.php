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
@endpush
@php
$languages = __('form.array.lang');
@endphp
@section('content')
<x-flash-message/>
<x-set-titles page="{{ $controller.'_'.$action }}" module="{{ trans_choice('menu.company', 1) }}"/>

<div class="card card-custom">
	<div class="card-body">
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<th>{{ __('form.label.company_name') }}</th>
    					<th>{{ trans_choice('form.label.employee', 2) }}</th>
    					<th>{{ __('form.label.total_emp') }}</th>
    					<th>{{ __('form.label.name') }}</th>
    					<th>{{ __('form.label.country') }}</th>
    					<th>{{ __('form.label.created') }}</th>
    					<th>{{ trans_choice('form.label.action', 2) }}</th>
    				</tr>
    			</thead>
    			<tbody>
    				@foreach ($companies as $company)
    					@php 
    					$company_user = $company->company_user->first();
    					$created_at = str_replace('/', '-', $company->created_at);
        				$created_at = date('Y-m-d', strtotime($created_at));
        				$status_text = 'activate';
        				$status = 'active';
        				$aicon = 'flaticon2-check-mark';
        				if($company->status=='active') {
        					$status_text = 'deactivate';
        					$status = 'inactive';
        					$aicon = 'flaticon2-cross';
        				}
    					@endphp
        				<tr>
        					<td>{{ $company->name }}</td>
        					<td>{{ $company->employee_no ? $company->employee_no->nos : '-' }}</td>
        					<td>{{ $company->company_user->count() }}</td>
        					<td>{{ ($company_user) ? $company_user->user->full_name : '-' }}</td>
        					<td>{{ $company->country ? $company->country->name : '-' }}</td>
        					<td data-sort='{{ $created_at }}'>{{ $company->created_at }}</td>
        					<td>
        						<a href="{{ route('companies.supdate', ['company' => $company->id, 'locale'=>app()->getLocale(), 'status'=>$status]) }}" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.'.$status_text) }}"><i class="{{ $aicon }}"></i></a>
        						<a href="{{ route('companies.edit', ['company' => $company->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.update') }}"><i class="flaticon-edit"></i></a>
    							<a href="{{ route('companies.show', ['company' => $company->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.view') }}"><i class="flaticon-eye"></i></a>
    							<a href="{{ route('categories.pdf', ['company' => $company->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-icon btn-xs btn-outline-success" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.pdf') }}"><i class="far fa-file-pdf"></i></a>
    							<!-- Delete -->
                            	<form id="delete_form_{{$company->id}}" name="delete_form" action="{{ route('companies.destroy', ['company' => $company->id, 'locale'=>app()->getLocale()])}}" method="post" class="btn btn-icon btn-xs">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.delete') }}"><i class="flaticon-delete"></i></button>
                                </form>
                            	<!-- End: Delete -->
        					</td>
        				</tr>
    				@endforeach
    			</tbody>
    		</table>
    	</div>
	</div>
</div>
@endsection