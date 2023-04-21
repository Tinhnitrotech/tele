@section('title', trans('material.title_export'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/place.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="card bg-light mt-4">
        <div class="card-box">
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ Session::get('message') }}
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="panel-body">
                <div class="clearfix">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="page-title"> {{ trans('material.import_title_page') }}</h5>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.importCSVMasterMaterial') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="csv_file" class="form-control input-file" accept=".csv">
                    @if(Session::has('message_validate'))
                        <span class="text-danger text-center">{{ Session::get('message_validate') }}</span>
                    @endif
                    <br>
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary btn-rounded waves-effect waves-light text-center">{{ trans('material.button_import') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
