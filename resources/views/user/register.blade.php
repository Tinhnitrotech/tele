@section('title', trans('user_register.title_register')." - ".getPlaceName()." - ".getSystemName())
@extends('common.layouts.user.main')
@push('head_css')
    <link rel="stylesheet" href="{{ asset('css/user/register.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/check_postal_code.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/staff/add_family.js') }}"></script>
    <script src="{{ asset('js/qr_code.js') }}"></script>
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>

    @if($userAgent == 1)
        <script src="{{ asset('js/instascanIOS.min.js') }}"></script>
        <script src="{{ asset('js/instascan.js') }}"></script>
    @else
        <script src="{{ asset('js/instascan.min.js') }}"></script>
    @endif

    @include('staff.refuge.validate.add_family_validate')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="row">
                        <div class="d-none loading text-primary" id="loading">Loading&#8230;</div>

                        <div class="col-lg-12">
                            <h3 class="text-center title_on_page">{{ trans('user_register.title') }}</h3>


{{--                            <div class="button_detect">--}}
{{--                                <label for="capture_image" class="capture_image">--}}
{{--                                    <input type="file" accept="image/*" capture="camera" id="capture_image" caption style="display:none">--}}
{{--                                    {{ trans('staff_add_family.capture_image') }}--}}
{{--                                </label>--}}
{{--                            </div>--}}

                            <div class="btn-group btn-group-toggle button_scan clearfix" data-toggle="buttons" >
                                <label class="btn btn-primary">
                                    <button id="scanFrontCamera" class="button_front_camera">{{ trans('staff_add_family.front_camera') }}</button>
                                </label>
                                <label class="btn btn-secondary active">
                                    <button id="scanBackCamera" class="button_back_camera">{{ trans('staff_add_family.back_camera') }}</button>
                                </label>
                            </div>
                            <div class="clearfix"></div>

                            <video id="preview" width="300px" height="300px" class="video-back d-none" playsinline style="position: relative;"></video>
                            <hr>
                            @if (!empty($data['errors_beyond_capacity']))
                                <div class="alert alert-danger alert-block text-center">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $data['errors_beyond_capacity'] }}</strong>
                                </div>
                            @endif
                            @if(Session::has('message'))
                                <div class="alert alert-danger alert-block text-center w-100 mt-1">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong class="common_font_site">{{ Session::get('message') }}</strong>
                                </div>
                            @endif

                            <div class="alert alert-danger alert-block text-center w-100 mt-1 qr-scan d-none">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong class="error-scan"></strong>
                            </div>
                            <!-- form -->
                            @include('staff.refuge.form_family')
                            <!-- end form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('staff.script_template')
@endsection

