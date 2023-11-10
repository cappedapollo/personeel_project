<!--begin::Main-->
@include('layout.partials.header_mobile')
<div class="d-flex flex-column flex-root">

	<!--begin::Page-->
	<div class="d-flex flex-row flex-column-fluid page">
		@if(Auth::check())
			@include('layout.partials.aside')
		@endif
		
		<!--begin::Wrapper-->
		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
			@include('layout.partials.header')
			<!--begin::Content-->
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				@include('layout.partials.subheader.subheader-v1')
				<!--Content area here-->
				
				@include('layout.partials.content')
			</div>
			<!--end::Content-->
			@include('layout.partials.footer')
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
</div>
<!--end::Main-->