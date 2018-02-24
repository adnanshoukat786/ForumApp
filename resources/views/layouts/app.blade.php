<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="forumApp" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ URL('css/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'VanHack Test') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script>
	var webroot = "{{ URL('/') }}";
	</script>
</head>
<body>
    <div id="app" ng-controller="forumController" ng-cloak  >
        @yield('content')
    </div>

    <!-- Scripts -->
	 <script src="{{ asset('js/app/angular.min.js') }}"></script>
    <script src="{{ asset('js/app/angular-controller.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/app/moment.min.js') }}"></script>
	<!-- load angular-moment -->
	<script src="{{ asset('js/app/angular-moment.min.js') }}"></script>
	<script src="{{ asset('js/notify.js') }}"></script>
</body>
</html>
