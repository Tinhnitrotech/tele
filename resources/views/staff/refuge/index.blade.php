@section('title', trans('staff_refuge_index.page_title')." - ".getPlaceName()." - ".getSystemName())

@extends('common.layouts.staff.app')

@push('head_css')
    <link href="{{ asset('dist_admin/assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body common_font_site">
                    <div class="clearfix">
                        <h5 class="text-uppercase mt-0 text-center font-weight-bold size-32">{{ trans('staff_refuge_index.section_title') }}</h5>
                        <hr>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center dataTables_wrapper">
                                <div class="col-sm-12">
                                    <form action="{{ route('staff.familyIndex') }}" method="GET">
                                        <div class="form-group row">
                                            <label for="family_code" class="col-lg-2 col-md-3 col-form-label font-weight-bold common_font_site">{{ trans('staff_refuge_index.household_number') }}</label>
                                            <div class="col-lg-2 col-md-2">
                                                <input type="text"
                                                    id="family_code"
                                                    class="form-control"
                                                    name="family_code"
                                                    placeholder=""
                                                    value="{{ !empty($data->family_code) ? $data->family_code : old('family_code') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-lg-2 col-md-3 col-form-label font-weight-bold common_font_site">{{ trans('staff_refuge_index.name_phonetic') }}</label>
                                            <div class="col-lg-4 col-md-4">
                                                <input type="text"
                                                    id="name"
                                                    class="form-control"
                                                    name="name"
                                                    placeholder=""
                                                    value="{{ !empty($data->name) ? $data->name : old('name') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 col-md-3 col-form-label"></label>
                                            <div class="col-lg-10 col-md-9">
                                                <button type="submit" class="btn btn-primary btn-rounded mb-2 px-5 common_font_site">{{ trans('staff_refuge_index.search') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end col -->

                                <div class="col-sm-12">
                                    <div class="float-left mb-2">
                                        <p class="font-weight-bold common_font_site size-28">{{ trans('staff_refuge_index.total_family') }}: {{ $total_family }}</p>
                                    </div>
                                    <div class="page-title-right float-right  mb-2">

                                        <a href="{{ routeByPlaceId("staff.staffDashboard") }}">
                                            <button class="btn btn-rounded btn-primary m-w-2 mb-3 common_font_site custom-mobile">
                                                {{trans('staff_refuge_index.go_to_top')}}
                                            </button>
                                        </a>

                                        <a href="{{ routeByPlaceId("staff.familyExport", ['family_code' =>!empty($data->family_code) ? $data->family_code : old('family_code'),
                                                    'place_id' =>getPlaceID(),
                                                    'name' => !empty($data->name) ? $data->name : old('name')]) }}">
                                            <button class="btn btn-rounded btn-primary m-w-2 mb-3 common_font_site custom-mobile">
                                                {{ trans('common.export') }}
                                            </button>
                                        </a>

                                        <button class="btn btn-rounded btn-success m-w-2 mb-3 common_font_site custom-mobile"
                                                onclick="window.location='{{ routeByPlaceId('staff.addFamily') }}'">
                                            {{trans('staff_refuge_index.btn_sign_up')}}
                                        </button>

                                    </div>

                                </div>

                                <!-- end col -->

                                <div class="col-sm-12">
                                    <div class="table-responsive mb-3">
                                        @if ($message = Session::get('message'))
                                            <div class="alert alert-success alert-block text-center">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <table id="admin_top_table" class="table table-bordered table-striped dt-responsive mb-0 text-center">
                                            <thead class="table-head">
                                            <tr class="row-header">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    @php
                                                        $classItemTh = '';
                                                        if ($i == 1) {
                                                           $classItemTh = 'm-w-60';
                                                        }
                                                        else if ($i == 2 || $i == 3 || $i == 4){
                                                           $classItemTh = 'm-w-100';
                                                        }
                                                        else if ($i == 7 || $i == 6){
                                                              $classItemTh = 'm-w-70';
                                                        }
                                                         else if ($i == 8) {
                                                            $classItemTh = 'm-w-240';
                                                        }
                                                        else if ($i == 9 || $i == 10) {
                                                            $classItemTh = 'm-w-140';
                                                        }
                                                        else $classItemTh = 'm-w-200';
                                                    @endphp
                                                    @if ($i == 1)
                                                        <th class="{{ $classItemTh }}">ID</th>
                                                    @else
                                                        <th class="{{ $classItemTh }}">{{ trans('staff_refuge_index.th_' . $i) }}</th>
                                                    @endif
                                                @endfor
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($data) && sizeof($data) > 0)
                                                    @foreach ($data as $key => $person)
                                                        <tr>
                                                            <td class="w-60-px">
                                                                {{ $person['family_id']}}
                                                            </td>
                                                            <td class="w-60-px">
                                                                {{ $person['index'] }}
                                                            </td>
                                                            <td>
                                                                {{ $person['family_code']}}
                                                            </td>
                                                            <td class="w-60-px">
                                                                @if ($person['is_owner'] == 0)
                                                                    {{ trans('staff_refuge_index.representative') }}
                                                                @endif
                                                            </td>
                                                            <td class="text-left ">
                                                                <a href="{{ routeByPlaceId('staff.familyDetail', ['id' => $person['family_id']]) }}">{{ $person['personName'] }}</a>
                                                            </td>
                                                            <td>
                                                                {{ getGenderName($person['gender']) }}
                                                            </td>
                                                            <td>
                                                                {{ $person['age'] }}
                                                            </td>
                                                            <td>
                                                                {{ trans('common.person_requiring_option')[$person['option']] ?? ''}}
                                                            </td>
                                                            <td>
                                                                {{ $person['note'] }}
                                                            </td>
                                                            <td>
                                                                {{ !empty($person['created_at']) ? date('Y/m/d', strtotime($person['created_at'])) : '' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-danger alert-block text-center">
                                                        {{ trans('common.no_data_message') }}
                                                    </div>
                                                @endif
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                    <!-- end div-table -->
                                </div>
                                <!-- end col -->

                                <!-- pagination -->
                                {{ $data->render('common.layouts.pagination') }}
                                <!-- end pagination -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
