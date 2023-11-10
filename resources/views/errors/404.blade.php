@extends('layout.error')
@section('content')
<h1 class="error-title font-weight-boldest text-primary mt-md-0 mb-12">404</h1>
<p class="font-weight-boldest display-4">{{ __('messages.page_not_found') }}</p>
<p class="font-size-h3">{!! __('messages.page_not_found_subtext') !!}</p>
@endsection