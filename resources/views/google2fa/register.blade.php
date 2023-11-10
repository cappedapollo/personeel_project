@extends('layout.app')
@section('login-content')
<!--begin::Signin-->
<div class="login-form login-signin">
	@include('components/flash-message')
	<div class="text-center">
    	<img alt="" src="{{ asset(config('layout.resources.2fa_logo')) }}" class="max-h-80px mb-10">
    </div>
    <!--begin::Form-->
    <form class="form" action="{{ url(app()->getLocale().'/verify') }}" method="post">
        @csrf
        <!--begin::Title-->
        <div class="pb-10 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">{{ __('messages.setup_gfa') }}</h3>
        </div>
        <!--begin::Title-->

		<p>{!! __('messages.gfa_step_1') !!}</p>
		<p>
			<a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en_IN&gl=US" class="btn btn-primary font-weight-bold mr-2">
                <i class="socicon-android"></i> {{ __('form.label.android') }}
            </a>
            <a target="_blank" href="https://apps.apple.com/us/app/google-authenticator/id388497605" class="btn btn-primary font-weight-bold mr-2">
                <i class="socicon-apple"></i> {{ __('form.label.ios') }}
            </a>
		</p>
        <p>{!! __('messages.gfa_step_2', ['secret'=>$secret]) !!}</p>
        <div>
            {!! $QR_Image !!}
        </div>
        <p>{!! __('messages.gfa_step_3') !!}</p>
        <div class="pb-lg-0 pb-5">
            <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">{{ __('form.label.complete_login') }}</button>
        </div>
    </form>
    <!--end::Form-->
</div>
<!--end::Signin-->
@endsection    