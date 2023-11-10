<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		@if(!Auth::check())
		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
			<!--begin::Header Logo-->
			<div class="header-logo">
				<a href="{{ url('/') }}">
					<img alt="{{ config('app.name') }}" src="{{ asset(config('layout.resources.logo')) }}" class="max-h-60px">
				</a>
			</div>
			<!--end::Header Logo-->
		</div>
        @endif
        
		<!--begin::Topbar-->
		@if(Auth::check())
    		@php
    		$first_name = ucfirst(Auth::user()->first_name);
    		$first_letter = $first_name[0];
    		@endphp
		@endif
		<div></div>
		<div class="topbar">
			{{-- Languages --}}
			@php
        	if (app()->getLocale() == 'en') {
                $kt_lang_image = config('layout.resources.lang-flag-en');
            }else {
                $kt_lang_image = config('layout.resources.lang-flag-du');
        	}
        	@endphp
            <div class="dropdown">
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                        <img class="h-20px w-20px rounded-sm" src="{{ asset($kt_lang_image) }}" alt=""/>
                    </div>
                </div>
    
                <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                    @include('layout.partials.extras.dropdown.languages')
                </div>
            </div>
            
            @if(Auth::check())
			<!--begin::User-->
			<div class="dropdown">
				<!--begin::Toggle-->
				<div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
					<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2">
						<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ $first_name }}</span>
						<span class="symbol symbol-35 symbol-light-primary">
							<span class="symbol-label font-size-h5 font-weight-bold">{{ $first_letter }}</span>
						</span>
					</div>
				</div>
				<!--end::Toggle-->

				<!--begin::Dropdown-->
				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
					@include('layout.partials.extras.dropdown.user')
				</div>
				<!--end::Dropdown-->
			</div>
			<!--end::User-->
			@endif
		</div>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->