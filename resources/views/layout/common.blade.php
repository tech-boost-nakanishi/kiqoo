<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width,initial-scale=1,shrink-to-fit=no" name="viewport">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title')</title>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/index.css') }}" rel="stylesheet">
		<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>

    <body>
    	@yield('header')

    	<div class="container" style="margin-top: 30px; margin-bottom: 30px; min-height: calc(100vh - 70px - 60px - 60px);">
    		<div class="row">
					@yield('sidebar')
					@yield('content')
					@yield('auth')
			</div>
		</div>

		@yield('footer')
		<a href="#top" class="pageTop">
			<span class="arrow"></span>
		</a>
    </body>
</html>