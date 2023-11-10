@extends('layout.error')
@section('content')
<h1 class="error-title font-weight-boldest text-primary mt-10 mt-md-0 mb-12">Oops!</h1>
<p class="font-weight-boldest display-4">{{ __('messages.not_authorized') }}</p>
@endsection