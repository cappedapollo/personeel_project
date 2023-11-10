@php
list($controller, $action) = getActionName();
@endphp
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>{{config('app.name')}} | @yield('title', $page_title ?? '')</title>
		<!-- <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." /> -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="{{config('app.url')}}" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		
		@if (in_array($action, array('login', 'reset_password', 'verify', 'gfa_register', 'gfa_authenticate')))
		<link href="{{ asset(config('layout.resources.login_css')) }}" rel="stylesheet" type="text/css"/>
		@endif
		
		<!--begin::Global Theme and Layout Themes Styles(used by all pages)-->
        @foreach(config('layout.resources.css') as $style)
            <link href="{{asset($style)}}" rel="stylesheet" type="text/css"/>
        @endforeach
		<!--end::Global Theme Styles-->

		<link rel="shortcut icon" href="{{ asset(config('layout.resources.favicon')) }}" />
		
		{{-- Includable CSS --}}
        @stack('styles')
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading {{(Auth::check() && $controller!='PageController') ? 'aside-enabled aside-fixed aside-minimize-hoverable' : ''}}">
		@if (in_array($action, array('login', 'reset_password', 'gfa_register', 'verify', 'gfa_authenticate')))
        	@include('layout.login')
        @else
        	@include('layout.base.layout')
        @endif

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>
            var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
        </script>
		<!--end::Global Config-->

		<!--begin::Global Theme Bundle(used by all pages)-->
		@foreach(config('layout.resources.js') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
		<!--end::Global Theme Bundle-->
		
		{{-- Includable JS --}}
        @stack('scripts')
	</body>
	<!--end::Body-->
</html>