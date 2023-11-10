<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>{{config('app.name')}} | @yield('title', $page_title ?? '')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="{{config('app.url')}}" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Global Theme and Layout Themes Styles(used by all pages)-->
        @foreach(config('layout.resources.css') as $style)
            <link href="{{asset($style)}}" rel="stylesheet" type="text/css"/>
        @endforeach
		<!--end::Global Theme Styles-->

		<link rel="shortcut icon" href="{{asset(config('layout.resources.favicon'))}}" />
		
		{{-- Includable CSS --}}
        @stack('styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    	<!--begin::Main-->
    	<div class="d-flex flex-column flex-root">
    		<div class="d-flex flex-column flex-row-fluid text-center m-20">
    			<a href="{{ url('/') }}" class="mb-20">
                	<img alt="{{ config('app.name') }}" src="{{ asset(config('layout.resources.logo')) }}" class="max-h-70px">
                </a>
    			@yield('content')
			</div>
    	</div>
    	<!--end::Main-->
    	
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