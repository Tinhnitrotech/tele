@extends('common.layouts.app')
@section('title', trans('staff_management.detail_title'))
@push('head_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/staff_management.css') }}">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="title-content-page">{{ trans('staff_management.detail_title') }}</div>
                <div class="row">
                    <div class="col-lg-7 size-18">
                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive-md mb-0">
                                <tr>
                                    <td scope="row" class="w-25">{{ trans('staff_management.name') }}</td>
                                    <td>{{ $detail->name }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">{{ trans('staff_management.tel') }}</td>
                                    <td>{{ $detail->tel }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="button-submit">

                            <a href="{{ Route('admin.staffManagement') }}"><button class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site">{{ trans('common.back') }}</button></a>
                            <a href="{{ Route('admin.staffManagementEdit', request()->id) }}"><button class="btn btn-primary btn-rounded my-2 width-128 common_font_site mr-2">{{ trans('staff_management.edit') }}</button></a>
                        </div>

                        <div class="title-content-page title-history-login">{{ trans('staff_management.history_login_title') }}</div>
                        <div class="table-responsive ">
                            <table class="table table-bordered table-responsive-md mb-2">
                                <thead>
                                <tr class="row-header">
                                    <th>{{ trans('staff_management.no') }}</th>
                                    <th>{{ trans('staff_management.shelter') }}</th>
                                    <th>{{ trans('staff_management.datetime_login') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($detail->places as $key => $place)
                                <tr>
                                    <td>{{ ++$key + ($detail->places->currentPage()-1) * $detail->places->perPage() }}</td>
                                    <td>
                                        <span class="custom-text-long width-300">
                                        {{ getTextChangeLanguage($place['name'], $place['name_en']) }}
                                        </span>
                                    </td>
                                    <td>{{ date('Y/m/d H:m', strtotime($place['login_datetime'])) }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- pagination -->
                            {{ $detail->places->render('common.layouts.pagination') }}
                            <!-- end pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
