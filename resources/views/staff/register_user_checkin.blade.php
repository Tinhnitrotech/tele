@section('title', trans('register_user_checkin.title_page')." - ".getPlaceName()." - ".getSystemName())
@extends('common.layouts.staff.app')
@push('head_css')
    <link href="{{ asset('css/staff/supplies_index.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/staff/register_user_checkin.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="{{ asset('js/staff/calculator.js') }}"></script>
@endpush
@section('content')
   <div class="row">
       <div class="col-12">
            <div class="card-box">
                <div class="clearfix">
                    <h5 class="text-uppercase mt-0 text-center font-weight-bold size-32">{{ trans('register_user_checkin.title_page') }}</h5>
                    <hr>
                </div>

            @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($error = Session::get('error'))
                    <div class="alert alert-danger alert-block text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $error }}</strong>
                    </div>
                @endif
                <div class="panel-body common_font_site">
                    <form action="{{ route('staff.postPeopleCheckin') }}" method="POST">
                        @csrf
                    <div class="row text-center mt-4">
                        <div class="col-2">
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-4">
                            <h4 class="text-uppercase mt-0 text-center size-21">{{ trans('register_user_checkin.title_in_page') }}</h4>
                        </div>
                        <div class="col-3">
                            <h4 class="text-uppercase mt-0 text-center size-21">{{ trans('register_user_checkin.title_number_user_checkin') }}</h4>
                        </div>
                    </div>
                    <div class="row mb-4 text-center top_row">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_0') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="total_person_checkin" type="text" data-value="" value="{{ number_format($detail->total_person_checkin ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_total'] ?? 0) }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4 text-center">
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.regis_checkin')}}</h5>
                        </div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_1') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="pregnant" type="text" value="{{ number_format($detail->pregnant ?? 0) }}">
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_1'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 text-center">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_2') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="infants" type="text" value="{{ number_format($detail->infants ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_2'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 text-center">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_3') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="disability" type="text" value="{{ number_format($detail->disability ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_3'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 text-center">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_4') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="caregiver" type="text" value="{{ number_format($detail->caregiver ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_4'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 text-center">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_5') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="medical_device_user" type="text" value="{{ number_format($detail->medical_device_user ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_5'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 text-center">
                            <div class="col-2"></div>
                            <div class="col-2">
                                <h5>{{ trans('register_user_checkin.row_6') }}</h5>
                            </div>
                            <div class="col-4">
                                <div class="buttons_added ">
                                    <input class="minus is-form" type="button" value="-">
                                    <input  aria-label="quantity" class="form-control input-qty" name="allergic" type="text" value="{{ number_format($detail->allergic ?? 0) }}" >
                                    <input class="plus is-form" type="button" value="+">
                                </div>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_6'] ?? 0) }}" readonly>
                            </div>
                        </div>
                    <div class="row mb-4 text-center">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_7') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="foreign" type="text" value="{{ number_format($detail->foreign ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_7'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4 text-center">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <h5>{{ trans('register_user_checkin.row_8') }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="buttons_added ">
                                <input class="minus is-form" type="button" value="-">
                                <input  aria-label="quantity" class="form-control input-qty" name="other" type="text" value="{{ number_format($detail->other ?? 0) }}" >
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control text-center" value="{{ number_format($personTotal['person_option_8'] ?? 0) }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <a href="{{ routeByPlaceId('staff.staffDashboard') }}"><button class="btn btn-outline-secondary btn-bottom mr-5 my-2 mx-4 custom-button-mobile" type="button">{{ trans('staff_refuge_index.go_to_top') }}</button></a>
                            <button class="btn btn-primary btn-bottom my-2 mx-4 custom-button-mobile" type="submit">{{ trans('register_user_checkin.button_register') }}</button>
                        </div>
                    </div>
                    </form>
            </div>
       </div>
   </div>
@endsection
