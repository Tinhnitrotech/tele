<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{ trans('user_top.title_page')." - ".getPlaceName()." - ".getSystemName() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Plugin css -->
    <link href="{{ asset('dist_admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist_admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist_admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/user/guest.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('template_admin/js/vendor.js') }}"></script>
    <script src="{{ asset('template_admin/js/vendor/jquery.js') }}"></script>
</head>
<body>
<header id="topnav" class="guest_page">
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="dropdown notification-list">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                        <p>{{  getCurrentDateTime() }}</p>
                    </a>
                </li>

                <li class="dropdown notification-list dropdown">
                    <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        @if(Session::get('language') == 'en')
                            <img src="{{ asset('images/flag/us.png') }}" alt="lang-image" height="12">
                        @elseif(Session::get('language') == 'ja')
                            <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" height="12">
                        @else
                            <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" height="12">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown" x-placement="bottom-end">
                        <a href="{{route('setLanguage',['locate'=>'ja'])}}" class="dropdown-item notify-item">
                            <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">JP</span>
                        </a>
                        <a href="{{route('setLanguage',['locate'=>'en'])}}" class="dropdown-item notify-item">
                            <img src="{{ asset('images/flag/us.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">US</span>
                        </a>
                    </div>
                </li>
            </ul>

            <div class="user logo-box">
{{--                <a href="#" class="logo text-center">--}}
{{--                <span class="logo-lg">--}}
{{--                    <img src="{{ asset('images/logo.png') }}" alt="" height="28">--}}
{{--                </span>--}}
{{--                    <span class="logo-sm">--}}
{{--                    <img src="{{ asset('images/logo.png') }}" alt="" height="30">--}}
{{--                </span>--}}
{{--                </a>--}}
            </div>

            <ul class="list-unstyled m-0">
                <li>
                    <a href="{{ route('userDashboard'). '?hinan=' . getPlaceID() }}">
                        <h2 class="title_place text-center text-white">{{ getSystemName() }}</h2>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</header>
<div class="wrapper" id="guest_page">
    <div class="container-fluid">

        @if ($message = Session::get('message'))
            <div class="alert alert-success alert-block text-center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-warning alert-block text-center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if(getPlaceName())
            <div class="row mb-6">
                <div class="col-12">
                    <div class="card-box">
                        <h2 class="text-center title_on_page"><span class="custom-text-long width-80">{{ getPlaceName()}}</span></h2>
                    </div>
                </div>
            </div>
        @endif
        @if($isActive)
            <div class="row mt-6">
                <div class="col-lg-1"></div>
                <div class=" custom-div col-lg-5">
                    <a href="{{ routeByPlaceId('user.member') }}">
                        <button
                            class="btn button-user btn-block btn-lg btn-primary waves-effect waves-light btn_button text-white">
                            <h3 class="text-white">{{ trans('user_top.check_in') }}</h3></button>
                    </a>
                </div>
                <div class=" custom-div col-lg-5">
                    <a href="{{ routeByPlaceId('userCheckout') }}">
                        <button
                            class="btn button-user btn-block btn-lg btn-outline-primary waves-effect waves-light">
                            <h3>{{ trans('user_top.check_out') }}</h3></button>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@if($isActive)
    <div class="col-lg-12 text-right go_to_staff">
        <a href="{{ routeByPlaceId('staff.staffLogin') }}">{{ trans('user_top.go_to_staff') }}</a>
    </div>
@endif
@include('common.layouts.user.footer', ['classFooter' => 'position-fixed'])
@stack('scripts')
</body>
</html>
