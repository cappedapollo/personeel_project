@extends('layout.app')
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
list($controller, $action) = getActionName();
@endphp
@section('content')
@include('components/flash-message')
<div class="card card-custom">
	<div class="card-body">
		<input type="hidden" id="page" value="{{$controller}}_{{$action}}">
		<input type="hidden" id="search_text" value="{{__('form.label.search')}}">
        <input type="hidden" id="previous_text" value="{{__('form.label.previous')}}">
        <input type="hidden" id="next_text" value="{{__('form.label.next')}}">
		
		<div class="table-responsive">
    		<table class="table table-hover kt_datatable">
    			<thead>
    				<tr>
    					<th>{{ __('form.label.action_by') }}</th>
    					<th>{{ trans_choice('form.label.action', 1) }}</th>
    					<th>{{ __('form.label.created') }}</th>
    				</tr>
    			</thead>
    			<tbody>
    				@foreach ($logs as $log)
    					@php
    					$action_by = ($log->action_byu) ? $log->action_byu->full_name : '-';
    					$action = $log->action;
                        switch($log->module) {
                            case 'user':
                                $user = $log->user;
                                $action = Str::replaceFirst('[user_name]', $user->full_name, $action);
                                break;
                            case 'archive':
                            	$archive = $log->archive;
                            	if($archive) {
                                	$review_type = '';
                                	if ($archive->form_data) {
                                		$_review_type = company_review_type($archive->form_data->review_type->number);
                                		$review_type = $_review_type->name;
                                	}
                            	
                                	$action = Str::replaceFirst('[employee_name]', $archive->user->full_name, $action);
                                    $action = Str::replaceFirst('[review_type]', $review_type, $action);
                                    $action = Str::replaceFirst('[year]', ($archive->form_data) ? $archive->form_data->year : '', $action);
                                }
                                break;
                            case 'form_data':
                            	$form_data = $log->form_data;
                            	$review_type = '';
                            	if ($form_data->review_type) {
                            		$_review_type = company_review_type($form_data->review_type->number);
                            		$review_type = $_review_type->name;
                            	}
                            	
                            	$action = Str::replaceFirst('[user_name]', $action_by, $action);
                                $action = Str::replaceFirst('[employee_name]', $form_data->user->full_name, $action);
                                $action = Str::replaceFirst('[review_type]', $review_type, $action);
                                $action = Str::replaceFirst('[year]', ($form_data->year) ? $form_data->year : '', $action);
                                break;
                            default:
                        }
                        
                        $action = Str::replaceFirst('[action_by]', $action_by, $action);
    					@endphp
        				<tr>
        					<td>{{ $action_by }}</td>
        					<td>{!! nl2br($action) !!}</td>
        					<td>{{ $log->created_at }}</td>
        				</tr>
    				@endforeach
    			</tbody>
    		</table>
    	</div>
	</div>
</div>
@endsection