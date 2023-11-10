@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.login_js')) }}" type="text/javascript"></script>
@endpush
@section('login-content')
<!--begin::Signin-->
<div class="login-form login-signin">
	@include('components/flash-message')
	<!--begin::Form-->
	<form class="form" novalidate="novalidate" id="kt_login_signin_form" action="{{ route('users.authenticate', app()->getLocale()) }}" method="POST">
		@csrf
		<!--begin::Title-->
		<div class="pb-13 pt-lg-0 pt-5">
			<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">{{ __('form.label.welcome_text').' '.config('app.name') }}</h3>
		</div>
		<!--begin::Title-->
        <!--begin::Form group-->
		<div class="form-group">
			<label class="font-size-h6 font-weight-bolder text-dark">{{ __('form.label.email') }}</label>
			<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="email" autocomplete="off"/>
		</div>
		<!--end::Form group-->
        <!--begin::Form group-->
		<div class="form-group">
			<div class="d-flex justify-content-between mt-n5">
				<label class="font-size-h6 font-weight-bolder text-dark pt-5">{{ __('form.label.password') }}</label>
				<a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">{{ __('form.label.forgot_pwd') }} ?</a>
			</div>
			<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off"/>
		</div>                        
		<!--end::Form group-->
        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
        	<button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">{{ __('form.label.sign_in') }}</button>
    	</div>
    	<!--end::Action-->
	</form>
	<!--end::Form-->
</div>
<!--end::Signin-->
<!--begin::Forgot-->
<div class="login-form login-forgot">
    <!--begin::Form-->
    <form class="form" novalidate="novalidate" id="kt_login_forgot_form" action="{{ route('users.forgot_password', app()->getLocale()) }}" method="post">
    	@csrf
    	<!--begin::Title-->
    	<div class="pb-13 pt-lg-0 pt-5">
    		<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">{{ __('form.label.forgotten_pwd') }} ?</h3>
    		<p class="text-muted font-weight-bold font-size-h4">{{ __('form.label.forgotten_pwd_subtext') }}</p>
		</div>
		<!--end::Title-->
		<!--begin::Form group-->
		<div class="form-group">
			<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off"/>
		</div>
		<!--end::Form group-->
        <!--begin::Form group-->
        <div class="form-group d-flex flex-wrap pb-lg-0">
        	<button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">{{ __('form.label.submit') }}</button>
        	<button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">{{ __('form.label.cancel') }}</button>
    	</div>
    	<!--end::Form group-->
	</form>
	<!--end::Form-->
</div>
<!--end::Forgot-->
@endsection