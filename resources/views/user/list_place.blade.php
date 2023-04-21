<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{ getTypeName().(App::getLocale() == config('constant.language_ja') ? '' : ' ').trans('place.title_user_list'). " - ".getSystemName()}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Plugin css -->
    <link href="{{ asset('dist_admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist_admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist_admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('template_admin/js/vendor.js') }}"></script>
    <script src="{{ asset('template_admin/js/vendor/jquery.js') }}"></script>
</head>
<body>
<header id="topnav">
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
        </div>
    </div>
</header>
<div class="wrapper" id="guest_page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-center title_on_page">{{ getTypeName().(App::getLocale() == config('constant.language_ja') ? '' : ' ').trans('place.title_user_list') }}</h3>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="row justify-content-center dataTables_wrapper">
                                    <div class="col-sm-12">
                                        <div class="table-responsive mb-3">
                                            <table id="admin_top_table" class="table table-bordered dt-responsive mb-0">
                                                <thead class="table-head data-place">
                                                <tr>
                                                    <th class="text-center m-w-60" width="5%">ID</th>
                                                    <th class="text-center m-w-240">{{ trans('place.place_name') }}</th>
                                                    <th class="text-center m-w-300" width="25%">{{ trans('place.address') }}</th>
                                                    <th class="text-center m-w-150" width="15%">{{ trans('common.place_capacity') }}</th>
                                                    <th class="text-center m-w-100" width="10%">{{ trans('common.place_percent') }}</th>
                                                    <th class="text-center m-w-100" width="10%">{{ trans('place.status') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($result) > 0)
                                                    @foreach($result as $key => $value)
                                                        <tr>
                                                            <td class="text-center">{{ $value->id }}</td>
                                                            <td class="text-center">
                                                                <span class="custom-text-long width-350">
                                                                @if($value->active_flg) <a href="{{ route('userDashboard') . '?hinan=' . $value->id }}">{{ $value->name }}</a>
                                                                @else
                                                                    {{ $value->name }}
                                                                @endif
                                                                </span>
                                                            </td>
                                                            <td class="text-center"><span class="custom-text-long width-350">{{ $value->address_place }}</span></td>
                                                            <td class="text-center">
                                                                @if ($value->full_status == config('constant.place_is_full'))
                                                                    {{ $value->total_place }}/{{ $value->total_place }}{{trans('place.people')}}
                                                                @else
                                                                    @if($value->total_person > $value->total_place)
                                                                        {{ $value->total_place }}/{{ $value->total_place }}{{trans('place.people')}}
                                                                    @else
                                                                        {{ $value->total_person }}/{{ $value->total_place }}{{trans('place.people')}}
                                                                    @endif

                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($value->full_status == config('constant.place_is_full'))
                                                                   100%
                                                                @else
                                                                    @if($value->percent > 100) 100% @else {{ $value->percent }}% @endif
                                                                @endif
                                                               </td>
                                                            <td class="text-center dClick">
                                                                <button class="btn btn-sm button-status @if($value->active_flg) btn-danger @else btn-secondary @endif">
                                                                    {{ $value->active_flg ? trans('place.active') : trans('place.inActive')}}
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-warning">
                                                        {{ trans('common.no_data_message') }}
                                                    </div>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('common.layouts.footer', ['classFooter' => 'left-0'])
</body>
</html>

