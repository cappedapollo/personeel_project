<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>{{config('app.name')}}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="{{config('app.url')}}" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

		<link href="{{asset('public/css/pages/error-5.css')}}" rel="stylesheet" type="text/css"/>
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
    		<!--begin::Error-->
    		<div class="error error-5 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{asset(config('layout.resources.authorization_img'))}});">
    			<!--begin::Content-->
    			<div class="container d-flex flex-row-fluid flex-column justify-content-md-center p-12">
    				<!--begin::logo-->
                    <a href="#" class="text-center">
        				<img src="{{ asset(config('layout.resources.logo')) }}" class="max-h-100px" alt=""/>
        			</a>
                    <!--end::logo-->
    				@yield('content')
            		<p class="font-size-h3"><a href="{{ config('app.url').app()->getLocale() }}" class="btn btn-primary btn-lg">Go Back</a></p>
    			</div>
    			<!--end::Content-->
    		</div>
    		<!--end::Error-->
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