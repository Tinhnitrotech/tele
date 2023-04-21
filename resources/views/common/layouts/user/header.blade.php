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
                        <img src="{{ asset('images/flag/us.png') }}" alt="lang-image" class="mr-1" height="12"> <span class="align-middle">EN</span>
                    </a>
                </div>
            </li>
        </ul>

{{--        <div class="user logo-box">--}}
{{--            <a href="{{ routeByPlaceId('userDashboard') }}" class="logo text-center">--}}
{{--                <span class="logo-lg">--}}
{{--                    <img src="{{ asset('images/logo.png') }}" alt="" height="28">--}}
{{--                </span>--}}
{{--                <span class="logo-sm">--}}
{{--                    <img src="{{ asset('images/logo.png') }}" alt="" height="30">--}}
{{--                </span>--}}
{{--            </a>--}}
{{--        </div>--}}

        <ul class="list-unstyled m-0">
            <li>
                <a href="{{ route('userDashboard'). '?hinan=' . getPlaceID() }}">
                    <h2 class="title_place text-center text-white title-custom">{{ getPlaceName() }}</h2>
                </a>
            </li>
        </ul>

    </div>
</div>
