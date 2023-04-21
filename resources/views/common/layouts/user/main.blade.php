<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="{{ asset('dist_admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist_admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist_admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/common.css') }}" rel="stylesheet" type="text/css">

    @stack('head_css')
    <script src="{{ asset('template_admin/js/vendor.js') }}"></script>
    <script src="{{ asset('template_admin/js/vendor/jquery.js') }}"></script>
</head>
<body>
<header id="topnav">
    @include('common.layouts.user.header')
</header>
<div class="wrapper">
    @yield('content')
</div>
@include('common.layouts.user.footer')
@stack('scripts')
</body>
</html>
