@section('title', (isset(Request()->id) ? trans('staff_add_family.page_title_edit') : trans('staff_add_family.page_title'))." - ".getPlaceName()." - ".getSystemName())

@extends('common.layouts.staff.app')

@push('head_css')
    <link href="{{ asset('css/staff/add_family.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('/js/check_postal_code.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/staff/add_family.js') }}"></script>
    <script src="{{ asset('js/qr_code.js') }}"></script>
    @if(isset($userAgent) && $userAgent == 1)
        <script src="{{ asset('js/instascanIOS.min.js') }}"></script>
        <script src="{{ asset('js/instascan.js') }}"></script>
    @else
        <script src="{{ asset('js/instascan.min.js') }}"></script>
    @endif
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('staff.refuge.validate.add_family_validate')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body common_font_site">
                    <div class="d-none loading text-primary" id="loading">Loading&#8230;</div>
                    <div class="clearfix">
                        <h3 class="text-uppercase mt-0 text-center title_on_page">{{ $sectionTitle ?? '' }}</h3>

{{--                        <div class="button_detect">--}}
{{--                            <label for="capture_image" class="capture_image">--}}
{{--                                <input type="file" accept="image/*" capture="camera" id="capture_image" caption style="display:none">--}}
{{--                                {{ trans('staff_add_family.capture_image') }}--}}
{{--                            </label>--}}
{{--                        </div>--}}

                        <div class="btn-group btn-group-toggle button_scan_staff clearfix" data-toggle="buttons" >
                            <label class="btn btn-primary">
                                <button id="scanFrontCamera" class="button_front_camera">{{ trans('staff_add_family.front_camera') }}</button>
                            </label>
                            <label class="btn btn-secondary active">
                                <button id="scanBackCamera" class="button_back_camera">{{ trans('staff_add_family.back_camera') }}</button>
                            </label>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="justify-content-center">
                                @if ($error = Session::get('error'))
                                    <div class="alert alert-danger alert-block text-center">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $error }}</strong>
                                    </div>
                                @endif
                                @if($errors->has('errors_beyond_capacity'))
                                    <div class="alert alert-danger alert-block text-center">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $errors->first('errors_beyond_capacity') }}</strong>
                                    </div>
                                @endif
                                @if(Session::has('message'))
                                    <div class="alert alert-danger alert-block text-center">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ Session::get('message') }}</strong>
                                    </div>
                                @endif

                                <div class="alert alert-danger alert-block text-center w-100 mt-1 qr-scan d-none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong class="error-scan"></strong>
                                </div>

                                <video id="preview" width="300px" height="300px" class="video-back d-none" playsinline></video>
                                <!-- form -->
                                @include('staff.refuge.form_family')
                                <!-- end form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    @include('staff.script_template')

@endsection
