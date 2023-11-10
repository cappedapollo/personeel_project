@extends('layout.app')
@php
    list($controller, $action) = getActionName();
    $status = __('form.array.archive_status');
    $role_code = Auth::user()->user_role->role_code;
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
	<x-set-titles page="{{ $controller.'_'.$action }}" module="{{ trans_choice('form.label.form', 1) }}"/>
	@include('elements.archives')
@endsection