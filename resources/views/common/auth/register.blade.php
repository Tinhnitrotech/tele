@extends('common.layouts.auth')
@section('content')
    <div class="text-center">
        <div class="my-3">
            <a href="{{ routeByPlaceId('userDashboard') }}">
                <span><img src="{!! file_exists('images/logo.png') ? asset('images/logo.png') : asset('storage/images/logo.png') !!}" alt="" height="120"></span>
            </a>
        </div>
        <h5 class="text-muted text-uppercase py-3 font-16">{{ trans('login.title_register') }}</h5>
    </div>
    @if($errors->has('message'))
        <h6 class="text-danger font-weight-bold text-center">{!! trans('login.error_forgot') !!}</h6>
    @endif

    <form action="{{ $routePostRegister ?? '#' }}" class="mt-2">
        @csrf
        <div class="form-group mb-3">
            <div class="input-group">
                <input type="email"
                        class="form-control @if($errors->get('email')) is-invalid @endif"
                        name="email"
                        placeholder="{{ trans('login.placeholder_input_email') }}"
                        value="{{ old('email') }}">
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
            <div class="input-group">
                <input type="text"
                        class="form-control @if($errors->get('username')) is-invalid @endif"
                        name="username"
                        placeholder="{{ trans('login.placeholder_input_username') }}"
                        value="{{ old('username') }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            @if($errors->has('username'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('username') }}</span>
            @endif
        </div>

        <div class="form-group mb-3">
            <div class="input-group">
                <input type="password"
                        class="form-control"
                        name="password"
                        placeholder="{{ trans('login.placeholder_input_new_password') }}"
                        value="{{ old('password') }}">
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

        <div class="form-group mb-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox-signup" checked="">
                <label class="custom-control-label" for="checkbox-signup"><a href="#">{{ trans('login.agree_term') }}</a></label>
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary btn-rounded waves-effect waves-light px-5" type="submit"> {{ trans('login.member_registration') }} </button>
        </div>

    </form>
@endsection
@section('footer_auth')
    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-white-50">
                {{trans('login.return_text')}}
                <a href="{{ $routerLogin ?? '#' }}" class="text-white ml-1">
                    <b>{{ trans('login.sign_in') }}</b>
                </a>
            </p>
        </div>
    </div>
    <!-- end row -->
@endsection
