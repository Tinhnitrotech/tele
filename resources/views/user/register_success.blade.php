@section('title', trans('user_register.title_register')." - ".getPlaceName()." - ".getSystemName())
@extends('common.layouts.user.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3 class="text-center page-title size-32">{{ trans('user_register.register_success') }}</h3>
                            <div class="mt-2 size-48">{{ trans('user_register.family_code') }}</div>
                            <button type="button" class="btn btn-success btn-lg btn-block custom-button">@if(Session::has('familyCode')) {{ Session::get('familyCode') }} @endif</button>
                            <h3 class="text-center page-title my-3 size-32">{{ trans('user_register.register_success_note') }}</h3>
{{--                            <div class="text-center">--}}
{{--                                <img src="{{ asset('storage/' . $data->qr_code) }}">--}}
{{--                            </div>--}}
                            <a href="{{ routeByPlaceId('user.member') }}">
                                <button class="btn btn-primary waves-effect waves-light mr-1 custom-button m-w-8 size-48" type="submit">
                                    {{ trans('user_register.go_home') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

