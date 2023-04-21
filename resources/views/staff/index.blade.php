@section('title', trans('staff_dashboard.page_title')." - ".getPlaceName()." - ".getSystemName())
@extends('common.layouts.staff.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body size-28">
                    <div class="clearfix">
                        <h5 class="text-uppercase mt-0 font-weight-bold size-32">{{ trans('staff_dashboard.section_title') }}</h5>
                        <hr>
                    </div>

                    <div class="row justify-content-center text-center mt-5 mb-5">
                        @if ($message = Session::get('message'))
                            <div class="col-12">
                                <div class="alert alert-success alert-block text-center">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            </div>
                        @endif

                        <div class=" col-12 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <a href="{{ routeByPlaceId('staff.suppliesIndex') }}" class="btn btn-lg btn-primary  mb-2 px-4 width-lg button_staff_page">{{ trans('staff_dashboard.btn_left') }}</a>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <a href="{{ routeByPlaceId('staff.familyIndex') }}" class="btn btn-lg btn-primary mb-2 px-4 width-lg button_staff_page">{{ trans('staff_dashboard.btn_right') }}</a>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <a href="{{ routeByPlaceId('staff.peopleCheckin') }}" class="btn btn-lg btn-primary mb-2 px-4 width-lg button_staff_page">{{ trans('staff_dashboard.go_to_checkin_user') }}</a>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-6">
                                    <div class="col-sm-12 text-center">
                                        <h5 class="mb-1 size-32">{{ trans('staff_dashboard.box_title_left') }}</h5>
                                    </div>
                                    <!-- end col -->

                                    <table>
                                        <tbody>
                                            @if (!empty($place))
                                                <tr>
                                                    <td class="width-350 space-150 space-10">{{ trans('staff_dashboard.td_2') }} </td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $place->total_place ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                @if (!empty($personTotal))
                                                    <tr>
                                                        <td class="space-150 width-350 space-10">{{ trans('staff_dashboard.total_person') }} </td>
                                                        <td class="text-center width-200">:</td>
                                                        <td class="text-right m-w-160 rp-min">{{ $personTotal['total_person_checkin'] ?? 0 }}</td>
                                                        <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="space-150 width-350 space-10">{{ trans('staff_dashboard.blank') }} </td>
                                                        <td class="text-center width-200">:</td>
                                                        <td class="text-right m-w-160 rp-min">{{ ($place->total_place - $personTotal['total_person_checkin']) ?? 0 }}</td>
                                                        <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="space-150 width-350 space-10"> </td>
                                                        <td class="text-center height-47"> </td>
                                                        <td class="text-right m-w-160 rp-min"></td>
                                                        <td class="text-left m-w-70"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="space-150 width-350 space-10">{{ trans('staff_dashboard.total_family') }} </td>
                                                        <td class="text-center width-200">:</td>
                                                        <td class="text-right m-w-160 rp-min">{{ $personTotal['total_family'] ?? 0 }}</td>
                                                        <td class="text-left m-w-70"> {{ trans('staff_dashboard.family') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="space-150 width-350 space-10">{{ trans('staff_dashboard.td_4') }} </td>
                                                        <td class="text-center width-200">:</td>
                                                        <td class="text-right m-w-160 rp-min">{{ $personTotal['person_male'] ?? 0 }}</td>
                                                        <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="space-150 width-350 space-10">{{ trans('staff_dashboard.td_5') }} </td>
                                                        <td class="text-center width-200">:</td>
                                                        <td class="text-right m-w-160 rp-min">{{ $personTotal['person_female'] ?? 0 }}</td>
                                                        <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="space-150 width-350 space-10">{{ trans('staff_dashboard.count_person') }} </td>
                                                        <td class="text-center width-200">:</td>
                                                        <td class="text-right m-w-160 rp-min">{{ $personTotal['count_person'] ?? 0 }}</td>
                                                        <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="col-sm-12 text-center">
                                        <h5 class="mb-1 size-32">{{ trans('staff_dashboard.box_title_right') }}</h5>
                                    </div>
                                    <!-- end col -->
                                    <table>
                                        <tbody>
                                            @if (!empty($personTotal))
                                                <tr>
                                                    <td class="width-350 space-150 space-10">{{ trans('register_user_checkin.row_1') }}</td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['pregnant_woman'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_2') }} </td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['infant'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_3') }} </td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['persons_with_disabilities'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_4') }}</td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['nursing_care_recipient'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_5') }} </td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['medical_device_users'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_6') }} </td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['allergies'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_7') }}</td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{  $personTotal['foreign_nationality']  ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                                <tr> 
                                                    <td class="space-150 width-350 space-10">{{ trans('register_user_checkin.row_8') }}</td>
                                                    <td class="text-center width-200">:</td>
                                                    <td class="text-right m-w-160 rp-min">{{ $personTotal['other'] ?? 0 }}</td>
                                                    <td class="text-left m-w-70"> {{ trans('staff_dashboard.people') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
