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
    <link href="{{ asset('css/admin/evacuation_management.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('template_admin/js/vendor.js') }}"></script>
    <script src="{{ asset('template_admin/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/check_postal_code.js') }}"></script>
    <script src="{{ asset('js/admin/change_display_info.js')}}"></script>
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
                                    <h3 class="text-center title_on_page">{{ getTypeName().(App::getLocale() == config('constant.language_ja') ? '' : ' ').trans('public_evacuation_management.list_title') }}</h3>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="clearfix">
                                <div class="row common_font_site">
                                    <div class="col-12">
                                        <div id="form-search" class="col-lg-6">
                                            <form action="{{ route('publicEvacuationManagement') }}" method="GET">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">{{ trans('public_evacuation_management.search_name') }}</label>
                                                    <div class="col-lg-6 mt-1 mb-3">
                                                        <input class="form-control" type="text"
                                                               name="name"
                                                               value="{{ !empty($data->name) ? $data->name : old('name') }}">
                                                    </div>
                                                    <input id="displayInfoMode" type="hidden"
                                                           name="display_option"
                                                           value="{{ $data->display_option }}">
                                                    <div class="col-lg-3">
                                                        <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light custom-button-search">{{ trans('public_evacuation_management.search') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-4"></div>
                                            <div class="col-4 my-4">
                                                <select class="form-control" id="displayInfoSelect" onchange="changeDisplayInfo(this.value)">
                                                    @foreach (trans('public_evacuation_management.display_info_option') as $value => $type)
                                                        <option @if ($data->display_option == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                @include('common.flash_message')
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="row justify-content-center dataTables_wrapper">
                                        <div class="col-sm-12">
                                            <div class="table-responsive mb-3">
                                                <table class="table table-bordered table-responsive-md mb-2 text-center">
                                                    <thead class="table-head data-place">
                                                    <tr class="row-header">
                                                        <th class="text-center m-w-300">
                                                            {{ trans('place.place_name') }}
                                                        </th>
                                                        <th class="text-center m-w-100">
                                                            {{ trans('public_evacuation_management.name') }}
                                                        </th>
                                                        <th class="text-center m-w-100 col-data-age @if ($data->display_option == '3' || $data->display_option == '4') d-none @endif"">
                                                            {{ trans('public_evacuation_management.age') }}
                                                        </th>
                                                        <th class="text-center m-w-240 col-data-address @if ($data->display_option == '2' || $data->display_option == '4') d-none @endif">
                                                            {{ trans('public_evacuation_management.address') }}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($data) > 0)
                                                        @foreach ($data as $key => $person)
                                                            <tr data-widget="expandable-table" aria-expanded="false">
                                                                <td class="text-center">
                                                                    {{ $person['placeName'] ? getTextChangeLanguage($person['placeName'], $person['placeNameEn'])  : trans('evacuation_management.no_place') }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $person['personName'] }}
                                                                </td>
                                                                <td class="text-center col-data-age @if ($data->display_option == '3' || $data->display_option == '4') d-none @endif">
                                                                    {{ $person['age'] }}
                                                                </td>
                                                                <td class="text-center col-data-address @if ($data->display_option == '2' || $data->display_option == '4') d-none @endif">
                                                                    {{  config('constant.prefectures.' . $person['prefecture_id']) }} {{ $person['address_default'] }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <div class="alert alert-danger alert-block text-center">
                                                            {{ trans('common.no_data_message') }}
                                                        </div>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- pagination -->
                                        {{ $data->render('common.layouts.pagination') }}
                                        <!-- end pagination -->
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

