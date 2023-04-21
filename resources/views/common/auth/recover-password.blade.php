@section('title', trans('login.title_reset'))
@extends('common.layouts.auth')

@push('head_css')
    <link href="{{ asset('css/staff/reset_pass.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('common.auth.validate.reset_validate')
@endpush

@section('content')
    <div class="text-center">
        <div class="my-3">
            <a href="{{ routeByPlaceId('userDashboard') }}">
                <span><img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="120"></span>
            </a>
        </div>
        <h5 class="text-muted text-uppercase py-3 font-16">{{ trans('login.title_reset') }}</h5>
    </div>

    @if($errors->has('message'))
        <h6 class="text-danger font-weight-bold text-center">{!! trans('login.error_forgot') !!}</h6>
    @endif

    <form action="{{ $routePostResetPassword ?? '#' }}" method="post" id="telenet-reset-form" class="form-ig-icon-valid">
        @csrf
        <input type="hidden" name="token" value="{{ request()->token }}">
        <div class="form-group row mb-3">
            <label for="password" class="col-md-4 col-form-label">{{ trans('login.pass_new') }}<span class="text-danger">*</span></label>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="password"
                            id="password"
                            class="form-control @if($errors->get('password')) is-invalid @endif"
                            name="password"
                            placeholder="{{ trans('login.pass_new') }}"
                            value="{{ old('password') }}"
                            required >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @if($errors->has('password'))
                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="password_confirm" class="col-md-4 col-form-label">{{ trans('login.pass_new_confirm') }}<span class="text-danger">*</span></label>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="password"
                            id="password_confirm"
                            class="form-control @if($errors->get('password_confirm')) is-invalid @endif"
                            name="password_confirm"
                            placeholder="{{ trans('login.pass_new_confirm') }}"
                            value="{{ old('password_confirm') }}"
                            required >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @if($errors->has('password_confirm'))
                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('password_confirm') }}</span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light px-5">{{ trans('common.save') }}</button>
            </div>
            <!-- /.col -->
        </div>
        @if($errors->has('message'))
            <h6 class="text-danger font-weight-bold text-center">{{ $errors->get('message') }}</h6>
        @endif
    </form>
@endsection
