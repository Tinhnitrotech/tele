@section('title', trans('admin_refuge_detail.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body size-18">
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('admin_refuge_detail.title') }}</h5>
                                <h4 class="text-uppercase mt-2 text-right">
                                    <ins>{{ trans('staff_refuge_detail.section_title_sub') }} {{ $data->family_code }}</ins>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center dataTables_wrapper">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label class="col-md-2 font-weight-bold">{{ trans('common.evacuation_day') }}</label>
                                        <div class="col-md-10">
{{--                                           @if($data->qr_code)--}}
{{--                                            <div class="visible-print-admin text-right">--}}
{{--                                                <img src="{{ asset('storage/' . $data->qr_code) }}">--}}
{{--                                            </div>--}}
{{--                                            @endif--}}
                                            {{ formatDate($data->join_date)}}
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-md-2 font-weight-bold">{{ trans('admin_refuge_detail.street_address') }}</label>
                                        <div class="col-md-10 mb-2">
                                            〒{{$data->zip_code}} - {{$data->prefecture_name}} {{$data->address}}
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-md-2 font-weight-bold">{{ trans('admin_refuge_detail.phone_rep') }}</label>
                                        <div class="col-md-10">
                                            {{$data->tel}}
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <label class="col-md-2 font-weight-bold">{{ trans('common.language_register') }}</label>
                                        <div class="col-md-10">
                                            {{ getTextLanguage($data->language_register) }}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 font-weight-bold">{{ trans('admin_refuge_detail.household_list') }}</label>
                                        <div class="col-md-10 px-0">
                                            <div class="col-sm-12 row d-block m-0">
                                                <div class="page-title-right float-right text-right mb-2">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row m-0">
                                                <div class="table-responsive mb-3">
                                                    <table id="admin_top_table" class="table table-bordered table-striped dt-responsive mb-0 text-center">
                                                        <thead class="table-head">
                                                        <tr class="row-header">
                                                            <th width="5%">No.</th>
                                                            <th width="15%">{{ trans('admin_refuge_detail.th_2') }}</th>
                                                            <th>{{ trans('admin_refuge_detail.th_3') }}</th>
                                                            <th width="6%">{{ trans('admin_refuge_detail.th_4') }}</th>
                                                            <th width="6%">{{ trans('admin_refuge_detail.th_5') }}</th>
                                                            <th width="17%">{{ trans('admin_refuge_detail.th_6') }}</th>
                                                            <th width="12%">{{ trans('admin_refuge_detail.th_7') }}</th>
                                                            <th width="7%">{{ trans('admin_refuge_detail.th_8') }}</th>
                                                            <th width="7%">{{ trans('admin_refuge_detail.th_9')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data->person as $key => $person)
                                                            <tr data-widget="expandable-table" aria-expanded="false">
                                                                <td>
                                                                    {{ $key +1 }}
                                                                </td>
                                                                <td>
                                                                    @if ($person->is_owner == 0)
                                                                        {{ trans('staff_refuge_index.representative') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                        {{ $person->name }}
                                                                </td>
                                                                <td>
                                                                    {{ getGenderName($person->gender) }}
                                                                </td>
                                                                <td>
                                                                    {{ $person->age }}
                                                                </td>
                                                                <td>
                                                                    {{ trans('common.person_requiring_option')[$person->option] ?? ''}}
                                                                </td>
                                                                <td>
                                                                    {{ $person->note }}
                                                                </td>
                                                                <td>
                                                                    {{ date('Y/m/d', strtotime($person->created_at)) }}
                                                                </td>
                                                                <td>
                                                                    {{ $data->updated_at && $data->updated_at != $data->created_at ? date('Y/m/d', strtotime($data->updated_at)): '' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-9 m-0">
                                                @include('staff.refuge.history_join_log')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <a class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site" href="{{ route("admin.evacuationManagement") }}">{{ trans('common.back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
