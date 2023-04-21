@section('title', trans('material.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/place.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/delete_modal.js') }}"></script>
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('material.title') }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-3 text-center">
                                @include('common.flash_message')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-right float-right mt-5 mb-4">
                                    <a href="{{ route('admin.importCSVViewMaterial') }}" class="text-white">
                                        <button class="btn btn-primary btn-rounded my-2 px-4 common_font_site mr-2">{{ trans('common.import') }}</button>
                                    </a>
                                    <a href="{{ route('admin.adminExportCSVMasterSupply') }}" class="text-white">
                                        <button class="btn btn-primary btn-rounded my-2 px-4 common_font_site mr-2">{{ trans('common.export') }}</button>
                                    </a>
                                    <button class="btn button-add btn-rounded my-2 px-4 common_font_site"
                                            onclick="window.location='{{ route("admin.adminCreateMaterial") }}'">
                                        {{ trans('material.button_create') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center dataTables_wrapper">
                                <div class="col-sm-12">
                                    <div class="table-responsive mb-3">
                                        <table id="admin_top_table" class="table table-bordered dt-responsive mb-0 text-center">
                                            <thead class="table-head">
                                            <tr>
                                                <th>ID</th>
                                                <th>{{ trans('material.supply_name') }}</th>
                                                <th>{{ trans('material.unit') }}</th>
                                                <th>{{ trans('material.action_column') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($listMasterMaterial) > 0)
                                            @foreach($listMasterMaterial as $key => $item)
                                                <tr>
                                                    <td class="align-middle" width="5%">{{ $item->id }}</td>
                                                    <td class="align-middle">
                                                        <a href="{{route('admin.adminEditMaterial',$item->id)}}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="align-middle" width="20%">{{ $item->unit }}</td>
                                                    <td class="align-middle" width="10%">
                                                        <div class="form-inline form-action">
                                                            <div class="form-group">
                                                                <button id="button1"
                                                                        class="btn btn-sm btn-outline-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#modal_confirm_delete"
                                                                        data-url="{{ route('admin.adminDeleteMaterial',['id'=> $item->id ,'name'=> $item->name]) }}">
                                                                    {{ trans('place.action_column') }}
                                                                </button>
                                                            </div>
                                                        </div>
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
                                    {{ $listMasterMaterial->render('common.layouts.pagination') }}
                                    <!-- end pagination -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.layouts.confirm_delete_modal')
@endsection
