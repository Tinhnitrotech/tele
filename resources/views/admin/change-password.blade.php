@section('title',trans('change_password.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/change_password.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('change_password.title') }}</h5>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('message'))
                        <div class="col-12">
                            <div class="alert alert-success alert-block text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        </div>
                    @endif
                    <div class="row row mb-4">
                        <div class="col-lg-6">
                            <form action="{{ route('admin.adminUpdatePassword') }} " method="post">
                                @csrf
                                @method('put')
                                <div class="form-group row">
                                    <label class="col-6 col-form-label">{{ trans('change_password.placeholder_input_current_password') }}<span class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="password"
                                                   id="password_confirm"
                                                   class="form-control"
                                                   name="password"
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
                                <div class="form-group row">
                                    <label class="col-6 col-form-label">{{ trans('change_password.placeholder_input_new_password') }}<span class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="password"
                                                   id="password_confirm"
                                                   class="form-control"
                                                   name="password_new"
                                                   required >
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has('password_new'))
                                            <span class="text-danger font-weight-bold text-center">{{ $errors->first('password_new') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-6 col-form-label">{{ trans('change_password.placeholder_input_new_password_confirmation') }}<span class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="password"
                                                   id="password_confirm"
                                                   class="form-control"
                                                   name="password_confirm"
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
                                <div class="form-group mr-0 row">
                                    <div class="col-6"></div>
                                    <div class="col-6 button-submit">
                                        <a class="btn button-custom d-flex justify-content-center align-items-center" href="{{ route("admin.adminDashboard") }}" type="button">
                                            {{ trans('common.cancel') }}
                                        </a>
                                        <button class="btn button-custom button-register button-submit-change ml-2" type="submit">
                                            {{ trans('common.update') }}</a>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
