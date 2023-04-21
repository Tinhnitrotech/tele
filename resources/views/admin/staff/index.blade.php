@extends('common.layouts.app')
@section('title', trans('staff_management.list_title'))
@push('head_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/staff_management.css') }}">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/delete_modal.js') }}"></script>
@endpush
<?php
$search = (isset($_GET['search'])) ? htmlentities($_GET['search']) : '';
?>
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="page-title mb-3">{{ trans('staff_management.list_title') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3 text-center">
                        @include('common.flash_message')
                    </div>
                </div>
                <div class="row common_font_site">
                    <div class="col-6">
                        <form action="{{ route('admin.staffManagement') }}" method="GET">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-4 col-form-label">{{ trans('staff_management.name_no_kana') }}</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" id="example-text-input" name="search" value="{{ $search }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4"></div>
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light custom-button-search">{{ trans('staff_management.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="page-title-right float-right mt-5 mb-4">
                            <a href="{{ route('admin.importCSVViewStaffManagement') }}" class="text-white">
                                <button class="btn btn-primary btn-rounded my-2 px-4 common_font_site mr-2">
                                    {{ trans('common.import') }}
                                </button>
                            </a>
                            <a href="{{ route('admin.exportCSVStaffManagement') }}" class="text-white">
                                <button class="btn btn-primary btn-rounded my-2 px-4 common_font_site mr-2">
                                    {{ trans('common.export') }}
                                </button>
                            </a>
                            <a href="{{route('admin.staffManagementAdd')}}">
                                <button class="btn button-add btn-rounded my-2 px-4 common_font_site">
                                    {{ trans('staff_management.add') }}
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive mb-3">
                        <table class="table table-bordered mb-0 text-center">
                            <thead>
                            <tr class="row-header">
                                <th class="align-middle" width="5%">{{ trans('staff_management.no') }}</th>
                                <th class="align-middle">{{ trans('staff_management.name_no_kana') }}</th>
                                <th class="align-middle">{{ trans('staff_management.email') }}</th>
                                <th class="align-middle">{{ trans('staff_management.tel') }}</th>
                                <th class="align-middle">{{ trans('staff_management.edit') }}</th>
                                <th class="align-middle">{{ trans('staff_management.delete') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($listStaff) > 0)
                            @foreach($listStaff as $key => $item)
                            <tr data-widget="expandable-table" aria-expanded="false">
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="text-left align-middle"><a href="{{ route('admin.staffManagementShow', $item->id) }}">{{ $item->name }}</a></td>
                                <td class="align-middle">{{ $item->email }}</td>
                                <td class="align-middle">{{ $item->tel }}</td>
                                <td class="align-middle">
                                    <a class="link-tag-custom" href="{{ route('admin.staffManagementEdit', $item->id) }}">
                                        <button class="btn btn-sm btn-outline-info button-status-staff">{{ trans('staff_management.edit') }}</button>
                                    </a>
                                </td>
                                <td data-toggle="modal" data-target="#modal_confirm_delete" data-url="{{ route('admin.staffManagementDelete',['id'=> $item->id ,'name'=> $item->name]) }}" class="delete-staff align-middle">
                                    <button class="btn btn-sm btn-outline-primary delete-button delete-company button-status-staff">{{ trans('staff_management.delete') }}</button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <div class="alert alert-warning">
                                    {{ trans('common.no_data_message') }}
                                </div>
                            @endif
                            </tbody>
                        </table>
                        </div>
                        <!-- pagination -->
                        {{ $listStaff->render('common.layouts.pagination') }}
                        <!-- end pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.layouts.confirm_delete_modal')
@endsection
