@section('title',trans('change_password.title'))

@extends('common.layouts.staff.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body common_font_site">
                    <div class="clearfix">
                        <h5 class="text-uppercase mt-0 text-center font-weight-bold size-21">{{ trans('change_password.title') }}</h5>
                        <hr>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center">
                                @if ($message = Session::get('message'))
                                    <div class="col-12">
                                        <div class="alert alert-success alert-block text-center">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-8 col-md-12">
                                    <form action="{{ route('staff.staffUpdatePassword') }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="form-group row mb-3">
                                            <label for="password" class="col-md-4 col-form-label">{{ trans('change_password.placeholder_input_current_password') }}<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="password"
                                                            id="password"
                                                            class="form-control"
                                                            name="password"
                                                            placeholder="{{ trans('change_password.placeholder_input_current_password') }}"
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
                                            <label for="password_new" class="col-md-4 col-form-label">{{ trans('login.pass_new') }}<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="password"
                                                            id="password_new"
                                                            class="form-control"
                                                            name="password_new"
                                                            placeholder="{{ trans('login.pass_new') }}"
                                                            value="{{ old('password_new') }}"
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

                                        <div class="form-group row mb-3">
                                            <label for="password_confirm" class="col-md-4 col-form-label">{{ trans('login.pass_new_confirm') }}<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="password"
                                                            id="password_confirm"
                                                            class="form-control"
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
                                                <button type="reset" class="btn btn-lg btn-outline-secondary btn-rounded waves-effect my-2 mx-4 px-5 m-w-2 common_font_site" onclick="window.location='{{ routeByPlaceId('staff.staffDashboard') }}'">
                                                    {{ trans('common.cancel') }}
                                                </button>
                                                <button class="btn btn-lg btn-primary btn-rounded my-2 mx-4 px-5 m-w-2 common_font_site" type="submit">
                                                    {{ trans('common.update') }}
                                                </button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>
                                    <!-- end form -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
