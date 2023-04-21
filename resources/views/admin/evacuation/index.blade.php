@extends('common.layouts.app')
@section('title', trans('evacuation_management.list_title'))
@push('head_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/evacuation_management.css') }}">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="page-title mb-3">{{ trans('evacuation_management.list_title') }}</h5>
                            </div>
                        </div>
                        <div class="row common_font_site">
                            <div class="col-12">
                                <div id="form-search" class=" col-lg-6">
                                    <form action="{{ route('admin.evacuationManagement') }}" method="GET">
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">{{ trans('evacuation_management.address') }}</label>
                                            <div class="col-lg-7">
                                                <select class="form-control" name="place_id">
                                                    <option value="">{{ trans('user_register.please_select') }}</option>
                                                    @foreach ($places as $key => $item)
                                                        <option @if ($data->place_id  == $item->id) selected @endif value="{{ $item->id }}">{{ getTextChangeLanguage($item->name, $item->name_en) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">{{ trans('evacuation_management.number_family') }}</label>
                                            <div class="col-lg-7">
                                                <input class="form-control" type="text"
                                                       name="family_code"
                                                       value="{{ !empty($data->family_code) ? $data->family_code : old('family_code') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-5 col-form-label">{{ trans('evacuation_management.name') }}</label>
                                            <div class="col-lg-7">
                                                <input class="form-control" type="text"
                                                       name="name"
                                                       value="{{ !empty($data->name) ? $data->name : old('name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9">
                                                <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light custom-button-search">{{ trans('evacuation_management.search') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-left mb-2">
                                    <p class="font-weight-bold common_font_site size-28">{{ trans('evacuation_management.total_family') }}: {{ $total_family }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="page-title-right float-right  mb-2">
                                    <button class="btn btn-primary btn-rounded my-2 px-4 common_font_site" type="button"
                                            onclick="window.location='{{ route('admin.evacuationExportCSVEvacuation',
                                                    ['family_code' =>!empty($data->family_code) ? $data->family_code : old('family_code'),
                                                    'place_id' =>!empty($data->place_id) ? $data->place_id : old('place_id'),
                                                    'name' => !empty($data->name) ? $data->name : old('name')]) }}'">
                                        {{ trans('common.export') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        @include('common.flash_message')
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center dataTables_wrapper">
                                <div class="col-sm-12">
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-responsive-md mb-2 text-center">
                                            <thead>
                                            <tr class="row-header">
                                                <th class="width-5">ID</th>
                                                <th class="width-5 m-w-60">
                                                    {{ trans('evacuation_management.amount_family_1') }} <br/>
                                                    {{ trans('evacuation_management.amount_family_2') }}
                                                </th>
                                                <th class="width-10">{{ trans('evacuation_management.family_code') }}</th>
                                                <th class="width-7">{{ trans('evacuation_management.typical_family') }}</th>
                                                <th>{{ trans('evacuation_management.name') }}</th>
                                                <th class="width-5">{{ trans('evacuation_management.gender') }}</th>
                                                <th class="width-5">{{ trans('evacuation_management.age') }}</th>
                                                <th class="width-14">{{ trans('evacuation_management.people_require') }}</th>
                                                <th class="width-10">{{ trans('evacuation_management.remark') }}</th>
                                                <th class="width-13">{{ trans('place.place_name') }}</th>
                                                <th class="width-10">{{ trans('evacuation_management.date_departure') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($data) > 0)
                                                @foreach ($data as $key => $person)
                                                    <tr data-widget="expandable-table" aria-expanded="false">
                                                        <td>
                                                            {{ $person['family_id'] }}
                                                        </td>
                                                        <td>
                                                            {{ $person['index'] }}
                                                        </td>
                                                        <td>
                                                            {{ $person['family_code'] }}
                                                        </td>
                                                        <td>
                                                            @if ($person['is_owner'] == 0)
                                                                {{ trans('staff_refuge_index.representative') }}
                                                            @endif
                                                        </td>
                                                        <td class="text-left ">
                                                            <a href="{{route('admin.familyDetail',$person['family_id'])}}">{{ $person['personName'] }}</a>
                                                        </td>
                                                        <td>
                                                            {{ getGenderName($person['gender']) }}
                                                        </td>
                                                        <td>
                                                            {{ $person['age'] }}
                                                        </td>
                                                        <td>
                                                            {{ trans('common.person_requiring_option')[$person['option'] ]?? ''}}
                                                        </td>
                                                        <td>
                                                            {{ $person['note'] }}
                                                        </td>
                                                        <td>
                                                            <span class="custom-text-long width-200">
                                                            {{ $person['placeName'] ? getTextChangeLanguage($person['placeName'], $person['placeNameEn'])  : trans('evacuation_management.no_place') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{$person['out_date'] ? date('Y/m/d', strtotime($person['out_date'])) : '' }}
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
                                    </div>
                                    <!-- pagination -->
                                {{ $data->render('common.layouts.pagination') }}
                                <!-- end pagination -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
