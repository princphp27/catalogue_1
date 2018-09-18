<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Catalogue::Admin') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ my_asset('fonts/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('lib/bootstrap-4/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('lib/dataTables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('css/admin/style.css') }}">

@yield('style')
</head>
<body>
@include('admin.layouts.sidebar')
<div id="right-panel" class="right-panel">
	@include('admin.layouts.header')
	<div class="content mt-3">
		@include('admin.layouts.breadcrumb')
		@yield('content')
	</div>
</div>
@include('admin.layouts.footer')

<script type="text/javascript">
var APP_URL = "{{url('/')}}";
var APP_ASSETS_URL ="{{ my_asset('/') }}";
var IS_AUTHENTICATED = '<?php echo Auth::check();?>';
</script>

<script src="{{ my_asset('lib/popper.min.js')}}"></script>
<script src="{{ my_asset('lib/jquery-2.1.4.min.js') }}"></script>
<script src="{{ my_asset('lib/bootstrap-4/js/bootstrap.min.js') }}"></script>
<script src="{{ my_asset('lib/dataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ my_asset('lib/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- <script src="{{ my_asset('js/StorageHelpers.js') }}"></script> -->
<script src="{{ my_asset('js/admin/Helpers.js') }}"></script>
<script src="{{ my_asset('js/admin/ViewHelpers.js') }}"></script>
<script src="{{ my_asset('js/admin/common.js') }}"></script>
@yield('script')
</body>
</html>
