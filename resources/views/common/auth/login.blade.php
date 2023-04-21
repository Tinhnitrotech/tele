@section('title', trans('login.title_login'))
@extends('common.layouts.auth', ['colLogin' => 1])
@push('head_css')
    <link href="{{ asset('css/admin/login.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('common.auth.validate.login_validate')
@endpush
@section('content')
    <div class="text-center">
        <div class="my-3 item-image">
            <span><img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="120"></span>
        </div>
        <h5 class="text-muted text-uppercase py-3 font-16">
            @if (!empty($staffLogin) && $staffLogin)
                {{ trans('login.login_title_staff') }}
            @else
                {{ trans('login.login_title_admin') }}
            @endif
        </h5>
    </div>

    @if(Session::has('message'))
        <h6 class="text-success font-weight-bold text-center">{{ Session::get('message') }}</h6>
    @endif

    @if($errors->has('message'))
        <h6 class="text-danger font-weight-bold text-center">{!! trans('login.error') !!}</h6>
    @endif

    <form action="{{ $routePostLogin ?? '#' }}" method="post" id="telenet-login-form" class="form-ig-icon-valid">
        @csrf
        <div class="form-group mb-3">
            <label for="email">{{ trans('login.placeholder_input_email') }}<span class="text-danger">*</span></label>
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

        <div class="form-group mb-3">
            <label for="password">{{ trans('login.placeholder_input_password') }}<span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="password"
                        id="password"
                        class="form-control @if($errors->get('email')) is-invalid @endif"
                        name="password"
                        placeholder="{{ trans('login.placeholder_input_password') }}"
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

        <div class="form-group text-center">
            <button class="btn btn-primary btn-rounded waves-effect waves-light px-5" type="submit">{{ trans('login.login_button') }}</button>
        </div>

        <div class="form-group text-center mb-0">
            <a href="{{ $routeForgot ?? '#' }}" class="text-muted text-forgot">
                {{ trans('login.forget_password_text') }}
            </a>
        </div>

    </form>
@endsection
