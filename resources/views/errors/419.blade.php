@extends('layout.error1')
@section('content')
<p class="text-primary mt-10 mt-md-0">419</p>
<div class="card card-custom gutter-b">
	<div class="card-body text-center">
		<a href="#">
			<img src="{{ asset(config('layout.resources.logo')) }}" class="max-h-100px" alt=""/>
		</a>
		<p class="mt-10">{{ __('messages.page_expired') }}</p>
		<p class="font-size-h3 mt-10">
			<a href="{{ config('app.url').app()->getLocale() }}" class="btn btn-primary btn-lg">{{ __('form.label.to').' '.__('menu.dashboard') }}</a>
		</p>
	</div>
</div>
@endsection