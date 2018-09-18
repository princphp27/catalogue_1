<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Catalogue') }}</title>
<link href="{{ my_asset('fonts/font-awesome.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ my_asset('lib/bootstrap-4/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('css/admin/style.css') }}">
</head>
<body class="bg-white">
<div id="app">
	@yield('content')
</div>
<script type="text/javascript">
	var APP_URL = "{{url('/')}}";
	var APP_ASSETS_URL ="{{ my_asset('/') }}";
</script>
<script src="{{ my_asset('lib/jquery-2.1.4.min.js') }}"></script>
<script src="{{ my_asset('lib/popper.min.js') }}"></script>
<script src="{{ my_asset('lib/bootstrap-4/js/bootstrap.min.js') }}"></script>
<script src="{{ my_asset('lib/notify.js') }}"></script>
@yield('script')
</body>
</html>    	
