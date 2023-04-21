@extends('common.layouts.app')
@section('title', trans('admin_management.detail_title'))
@push('head_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/staff_management.css') }}">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="title-content-page">{{ trans('admin_management.detail_title') }}</div>
                <div class="row">
                    <div class="col-lg-7 common_font_site">
                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive-md mb-0">
                                <tr>
                                    <td scope="row" class="w-50">{{ trans('admin_management.name') }}</td>
                                    <td>{{ $detail->name }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">{{ trans('admin_management.email') }}</td>
                                    <td>{{ $detail->email }}<br>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="button-submit">

                            <a href="{{ Route('admin.adminManagement') }}"><button class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site">{{ trans('common.back') }}</button></a>
                            <a href="{{ Route('admin.adminManagementEdit', request()->id) }}"><button class="btn btn-primary btn-rounded my-2 width-128 common_font_site mr-2">{{ trans('admin_management.edit') }}</button></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
