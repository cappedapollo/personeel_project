@extends('layout.app')
@php
	$status = __('form.array.status');
	$ur_field = 'role_'.app()->getLocale();
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
        	<div class="card-body">
            	<div class="table-responsive">
    				<table class="table table-striped table-borderless">
                		<tbody>
                			<tr>
                				<td class="font-weight-bold">{{ __('form.label.name') }}:</td>
                				<td class="text-right">{{ $user->full_name }}</td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold">{{ __('form.label.email') }}:</td>
                				<td class="text-right">{{ $user->email }}</td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold">{{ __('form.label.function') }}:</td>
                				<td class="text-right">{{ $user->function ? $user->function : '-' }}</td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold">{{ __('form.label.role') }}:</td>
                				<td class="text-right">{{ ($user->user_role) ? $user->user_role->$ur_field : '-' }}</td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold">{{ trans_choice('form.label.manager', 1) }}:</td>
                				<td class="text-right">{{ ($user->manager) ? $user->manager->full_name : '-' }}</td>
                			</tr>
                			<tr>
                				<td class="font-weight-bold">{{ __('form.label.status') }}:</td>
                				<td class="text-right">{{ $status[$user->status] }}</td>
                			</tr>
            			</tbody>
        			</table>
    			</div>
            </div>
        </div>
        <!--end::Card-->
	</div>
</div>
@endsection