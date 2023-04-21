@section('title', trans('login.title_forgot'))
@extends('common.layouts.auth')

@push('head_css')
    <link href="{{ asset('assets/css/reset_pass.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('common.auth.validate.forgot_validate')
@endpush

@section('content')
    <div class="text-center">
        <div class="my-3 item-image">
            <a href="{{ routeByPlaceId('userDashboard') }}">
                <span><img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="120"></span>
            </a>
        </div>
        <h5 class="text-muted text-uppercase py-3 font-16">{{ trans('login.title_forgot') }}</h5>
    </div>

    @if($errors->has('message'))
        <h6 class="text-danger font-weight-bold text-center">{!! trans('login.error_forgot') !!}</h6>
    @endif

    <form action="{{ $routePostForgotPassword ?? '#'}}" method="post" id="telenet-forgot-form" class="form-ig-icon-valid">
        @csrf
        <div class="form-group row mb-3">
            <label for="email" class="col-md-3 col-form-label">{{ trans('login.placeholder_input_email') }}<span class="text-danger">*</span></label>
            <div class="col-md-9">
                <div class="input-group">
                    <input type="email"
                            id="email"
                            class="form-control @if($errors->get('email')) is-invalid @endif"
                            name="email"
                            placeholder="{{ trans('login.placeholder_input_email') }}"
                            value="{{ old('email') }}"
                            required >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @if($errors->has('email'))
                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light px-5">{{ trans('common.send') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
