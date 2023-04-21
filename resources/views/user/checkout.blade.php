@section('title', trans('user_search.title_user_checkout')." - ".getPlaceName()." - ".getSystemName())
@extends('common.layouts.user.main')
@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/user/search.js') }}" type="text/javascript"></script>
    <script>
        var male_code = "{{ config('constant.male') }}";
        var male = "{{ trans('common.male') }}";
        var female = "{{ trans('common.female') }}";
        var owner = "{{ trans('user_register.is_owner') }}";
        var no_data = "{{ trans('user_register.no_data') }}";
        var family_code = "{{ trans('staff_refuge_detail.section_title_sub') }}";
    </script>
    @include('user.validate_member_register')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="card-box">
                    <div class="row">
                        <div class="col-12 text-right">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="text-center page-content p-3 font-weight-bold size-48">{{ trans('user_register.member_exit') }}</h1>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <a class="text-white" href="{{ routeByPlaceId('user.member') }}">
                                            <button type="button" class="btn btn-user-register btn-secondary waves-effect waves-light btn-radius mr-1 m-w-2">
                                                {{ trans('user_register.user_checkin') }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <hr>
                            <form action="javascript:void(0);" method="POST" id="memberRegisterForm">
                                @csrf
                                <input hidden name="is_remote" value="1">
                                <div class="row text-center">
                                    <div class="col-12 col-sm-4">
                                        <h3 class="text-left page-title p-3 font-weight-bold size-32">{{ trans('user_register.check_out') }}</h3>
                                        <div class="col-12">
                                            <div class="form-group text-left clearfix">
                                                <div>
                                                    <input class="form-control common_font_site" name="family_code" value="{{ old('family_code') }}" type="text" placeholder="{{ trans('user_register.family_code') }}">
                                                    @error('family_code')
                                                    <span class="text-danger text-center">{{ $errors->first('family_code') }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group text-left clearfix">
                                                <div>
                                                    <input name="password" type="text" value="{{ old('password') }}" class="form-control common_font_site" placeholder="{{ trans('user_register.password') }}">
                                                    @error('password')
                                                    <span class="text-danger text-center">{{ $errors->first('password') }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <button type="submit" id="submit_search" class="btn btn-primary mb-2 px-5 custom-button">
                                            {{ trans('user_register.search') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none loading text-primary" id="loading">Loading&#8230;</div>
        <div class="row d-none" id="no-data">
            <div class="col-12">
                <div class="card-box text-center"></div>
            </div>
        </div>

        <div class="row d-none" id="search">
            <div class="col-12">
                <div class="card-box">
                    <div class="panel-body">
                        <div class="clearfix">
                            <h4 class="text-uppercase mt-0 text-center font-weight-bold size-32">{{ trans('staff_refuge_detail.section_title') }}</h4>
                            <hr>

                            <h4 class="text-uppercase mt-0 px-4 text-right">
                                <ins id="family-code"></ins>
                            </h4>
                        </div>

                        <div class="row mb-4 size-28">
                            <div class="col-12">
                                <div class="row justify-content-center dataTables_wrapper">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-lg-3 col-md-5 col-sm-5 font-weight-bold">{{ trans('common.evacuation_day') }}</label>
                                            <div class="col-lg-9 col-md-7 col-sm-7" id="date-create">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <label class="col-lg-3 col-md-5 col-sm-5 font-weight-bold">{{ trans('staff_refuge_detail.street_address') }}</label>
                                            <div class="col-lg-9 col-md-7 col-sm-7 mb-2" id="address"></div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <label class="col-lg-3 col-md-5 col-sm-5 font-weight-bold">{{ trans('staff_refuge_detail.phone_rep') }}</label>
                                            <div class="col-lg-9 col-md-7 col-sm-7" id="phone-number"></div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-md-5 col-sm-5 font-weight-bold">{{ trans('staff_refuge_detail.household_list') }}</label>
                                            <div class="col-lg-9 col-md-12 col-sm-12">
                                                <div class="col-sm-12 row">
                                                    <div class="table-responsive mb-3">
                                                        <table id="admin_top_table" class="table table-bordered table-striped dt-responsive mb-0 text-center">
                                                            <thead class="table-head">
                                                            <tr class="row-header">
                                                                @for ($i = 1; $i <= 8; $i++)
                                                                    <th class="@if($i == 1) w-75-px @elseif($i == 2 || $i == 7) m-w-140 @elseif($i == 4 || $i == 5) m-w-90  @else m-w-290 @endif">{{ trans('staff_refuge_detail.th_' . $i) }}</th>
                                                                @endfor
                                                            </tr>
                                                            </thead>
                                                            <tbody id="family-detail">
                                                            </tbody>
                                                        </table>
                                                        <!-- end table -->
                                                    </div>
                                                    <!-- end div-table -->
                                                </div>
                                                <!-- end col -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-sm-12">
                                        <form id="user_leave" action="" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-lg btn-primary btn-rounded my-2 px-5 button-note m-w-8">{{ trans('user_register.confirm_public_information') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection

