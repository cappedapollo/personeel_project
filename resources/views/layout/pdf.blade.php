@php
#$date = ($lang=='en') ? date('F d, Y') : date('d F Y');
$date = date('F d, Y');
if($lang=='en') {
	$date = date('F d, Y');
	$bg_center_img = asset(config('layout.resources.pdf_bkgd_center_en'));
}else {
	setlocale(LC_TIME, 'NL_nl');    
	setlocale(LC_ALL, 'nl_NL');
    $timestamp = strtotime(date("Y-m-d"));
    $date = strftime('%d %B %Y', $timestamp);
    $bg_center_img = asset(config('layout.resources.pdf_bkgd_center_du'));
}
@endphp
<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    	<style type="text/css">
            @page { margin: 2.5cm !important; }
            @font-face {
                font-family: 'Montserrat';
                src: url('{{ asset('storage/fonts/Montserrat-Regular.ttf') }}') format("truetype");
                font-weight: normal;
                font-style: normal;
                font-variant: normal;
            }

            body { font-size:12px; font-family: 'Montserrat'; line-height:1.0; text-align:left; }
            body.main-cont-bg { background-position: center; /* background-size: 50% 50%; */ background-repeat: no-repeat; background-image: url({{ $bg_center_img }});   }
            /* header { position: fixed; top:-70px; height: 60px; width:100%; } */
            header { position: fixed; height: 0px; width:140%; top:-100px; left:-100px;  }
            footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
            main { z-index:1000; }
            .row { width:100%; }
            .col-6 { width:48%; display:inline-block; vertical-align: top; }
            .col-10 { width:81%; display:inline-block; vertical-align: top; }
            .col-2 { width:13%; display:inline-block; vertical-align: top; }
            .font-size-lg { font-size: 17px; font-weight: 500; }
            .font-weight-light { font-weight: 400; }
            .table { width:100%; }
            /* .table > tbody > tr > td { padding: 3px 3px 3px 0px; } */
            table th, table td { vertical-align: top; text-align: left; }
            .mt-10 { margin-top: 10px; }
            .mt-20 { margin-top: 20px; }
            .mt-100 { margin-top: 100px; }
            .mt-50 { margin-top: 50px; }
            .mt-0, .my-0 { margin-top: 0px; }
            .mb-2 { margin-bottom: 2px; }
            .my-0 { margin-bottom: 0px; }
            .pt-10 { padding-top: 10px; }
            .pl-20 { padding-left: 20px; }
            .pl-40 { padding-left: 40px; }
            .pb-20 { padding-bottom: 20px; }
            .m-0 { margin: 0px; }
            .p-10 { padding: 10px; }
            .p-5 { padding: 5px; }
            .mr-10 { margin-right: 10px; }
            .text-center { text-align: center; }
            .text-left { text-align: left; }
            .text-right { text-align: right; }
            .width-50 { width:50%; display: inline-block; }
            .width-60 { width:60%; display: inline-block; }
            /* .page-break { page-break-after: always; }
             */
            .pagenum:before { content: counter(page); }
            .text-upper { text-transform: uppercase; }
            .border { border: 1px solid; }
            .stripe { 
            	/* background: repeating-linear-gradient( -45deg, #EAEAEA, #EAEAEA 10px, #333 10px, #333 20px); */
            	background-color: #EAEAEA;
            }
        </style>
        @stack('styles')
    </head>
    <body class="{{ ($submit_btn=='save_pdf') ? 'main-cont-bg' : '' }}">
    	<!--begin::Header-->
		<header>
			<img src="{{ asset(config('layout.resources.pdf_bkgd')) }}" width="100%" height="250px"/>
		</header>
        <!--end::Header-->
        <!--begin::Footer-->
		<footer>
        	<div class="row">
        		<hr/>
        		<span class="text-left col-10">{!! $date.' | '.config('app.main_url') !!}</span>
        		<span class="pagenum text-right col-2"></span>
    		</div>
		</footer>
        <!--end::Footer-->
        <!--begin::Content-->
		<main>
    		<div>
    			@yield('content')
    		</div>
		</main>
		<!--end::Content-->
    </body>
</html>