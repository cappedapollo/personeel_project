<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <style type="text/css">
            .container { border:15px solid #EEF0F8; }
            .header { display:flex; background-color:#FFFFFF; padding:25px; }
            .content { padding:25px; background-color:#EEF0F8; text-align:left; }
            .btn { border:1px solid transparent; padding:0.35rem 0.55rem; border-radius:0.42rem; display:inline-block; text-align:center; vertical-align:middle; font-size:0.855rem; line-height:1.35; text-decoration:none; }
            .btn.btn-primary { color:#FFFFFF; background-color:#29455D; border-color:#29455D; cursor:pointer; }
            .footer { background-color:#FFFFFF; padding: 25px; }
        </style>
    </head>
    <body>
    	<div class="container">
    		<!--begin::Header-->
    		<div class="header">
            	<img src="{{asset(config('layout.resources.logo_email'))}}" height="70px"/>
    		</div>
            <!--end::Header-->
    
    		<!--begin::Content-->
    		<div class="content">
				@yield('content')
    		</div>
    		<!--end::Content-->
    		
    		<!--begin::Footer-->
            <div class="footer">
    			<div>Copyright &copy; {{date('Y').' '.config('app.name')}}</div>
    			<div>All rights reserved.</div>
            </div>
            <!--end::Footer-->
        </div>
    </body>
</html>