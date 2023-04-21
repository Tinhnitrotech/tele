<div class="navbar-custom">

    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <p>{{  getCurrentDateTimeAdmin() }}</p>
            </a>
        </li>


        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="d-none d-sm-inline-block ml-1 font-weight-medium">{{ getUserLogin() }}</span>
                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <a href="{{ route('admin.adminChangePassword')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-edit-outline"></i>
                    <span>{{ trans('common.change_password') }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <!-- item-->
                <a href="{{ route('admin.logout')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout-variant"></i>
                    <span>{{ trans('common.logout') }}</span>
                </a>

            </div>
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
{{--            <div class="dropdown-menu dropdown-menu-right profile-dropdown text-center" x-placement="bottom-end">--}}
{{--                <a href="{{route('setLanguage',['locate'=>'ja'])}}" class="dropdown-item notify-item">--}}
{{--                    <img src="{{ asset('images/flag/jp.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">JP</span>--}}
{{--                </a>--}}
{{--                <a href="{{route('setLanguage',['locate'=>'en'])}}" class="dropdown-item notify-item">--}}
{{--                    <img src="{{ asset('images/flag/us.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">EN</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </li>--}}

    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('admin.adminDashboard') }}" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="50">
            </span>
            <span class="logo-sm">
                <img src="{!! asset('images/admin.png') !!}" alt="" height="40">
            </span>
        </a>
    </div>


    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>
    </ul>

    <h3 class="admin_title text-white mt-2">{{ getSystemNameAdmin() }} - @yield('title')</h3>

</div>
