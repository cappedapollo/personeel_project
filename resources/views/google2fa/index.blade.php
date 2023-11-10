@extends('layout.app')
@section('login-content')
<!--begin::Signin-->
<div class="login-form login-signin">
	@include('components/flash-message')
	<div class="text-center">
    	<img alt="" src="{{ asset(config('layout.resources.2fa_logo')) }}" class="max-h-80px mb-10">
    </div>
    <!--begin::Form-->
    <form class="form" action="{{ route('gfa_authenticate', ['locale'=>app()->getLocale()]) }}" method="post">
        @csrf
        <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">{{ __('form.label.verification_code') }}</h3>
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="number" name="one_time_password" id="one_time_password" autocomplete="off" required autofocus/>
        </div>
        
        <p>{!! __('messages.setup_2fa', ['href'=>url(app()->getLocale().'/gfa_generate_link')]) !!}</p>
    </form>
    <!--end::Form-->
</div>
<!--end::Signin-->
@endsection
@push('scripts')
<script>
$(function() {
	$('input[name=one_time_password]').on('keyup', function(){
	    if($(this).val().length == 6){
	        $('.form').submit();
	    }
	});
});
</script>
@endpush