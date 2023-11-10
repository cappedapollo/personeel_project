@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.reset_js')) }}" type="text/javascript"></script>
@endpush
@section('login-content')
<!--begin::Signin-->
<div class="login-form login-signin">
	@include('components/flash-message')
    <!--begin::Form-->
    <form class="form" novalidate="novalidate" id="kt_login_reset_form" action="{{ route('users.reset_password', app()->getLocale()) }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{$token}}"/>
        <!--begin::Title-->
        <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">{{ __('form.label.reset_password') }}</h3>
        </div>
        <!--begin::Title-->

        <!--begin::Form group-->
        <div class="form-group">
            <div class="d-flex justify-content-between mt-n5">
                <label class="font-size-h6 font-weight-bolder text-dark pt-5">{{ __('form.label.password') }}</label>
            </div>
            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off"/>
        </div>
        <!--end::Form group-->
        
        <!--begin::Form group-->
        <div class="form-group">
            <div class="d-flex justify-content-between mt-n5">
                <label class="font-size-h6 font-weight-bolder text-dark pt-5">{{ __('form.label.confirm_password') }}</label>
            </div>
            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="confirm_password" autocomplete="off"/>
        </div>
        <!--end::Form group-->

        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
            <button type="button" id="kt_login_reset_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">{{ __('form.label.reset') }}</button>
        </div>
        <!--end::Action-->
    </form>
    <!--end::Form-->
</div>
<!--end::Signin-->
@endsection