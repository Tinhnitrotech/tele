<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <p>{{  getCurrentDateTimeAdmin() }}</p>
            </a>
        </li>

{{--        <li class="dropdown notification-list dropdown">--}}
{{--            <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">--}}
{{--                @if(Session::get('language') == 'en')--}}
{{--                    <img src="{{ asset('images/flag/us.png') }}" alt="lang-image" height="12">--}}
{{--                @elseif(Session::get('language') == 'ja')--}}
{{--                    <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" height="12">--}}
{{--                @else--}}
{{--                    <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" height="12">--}}
{{--                @endif--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-right profile-dropdown" x-placement="bottom-end">--}}
{{--                <a href="{{route('setLanguage',['locate'=>'ja'])}}" class="dropdown-item notify-item">--}}
{{--                    <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">JP</span>--}}
{{--                </a>--}}
{{--                <a href="{{route('setLanguage',['locate'=>'en'])}}" class="dropdown-item notify-item">--}}
{{--                    <img src="{{ asset('images/flag/us.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">EN</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </li>--}}

        <li class="dropdown notification-list">
            <a href="{{ routeByPlaceId('staff.logout') }}" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="mdi mdi-logout-variant"></i>
                <span>{{ trans('common.logout') }}</span>
            </a>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box bg-transparent">
        <a href="{{ routeByPlaceId('staff.staffDashboard') }}" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="50">
            </span>
            <span class="logo-sm">
                <img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="40">
            </span>
        </a>
    </div>

    <ul class="list-unstyled m-0">
        <li class="d-none d-sm-block">
            <h2 class="title_place text-center text-white"><span class="custom-text-long custom-width-header">{{ getPlaceName() }}</span></h2>
        </li>
    </ul>
</div>
