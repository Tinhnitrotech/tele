@section('title', trans('qrcode.title_import'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/import_csv.js')}}"></script>
@endpush
@section('content')
    <div class="card bg-light mt-4">
        <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5 class="page-title"> {{ trans('qrcode.import_title_page') }}</h5>
                            </div>
                        </div>
                    </div>

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

                    <div class="col-sm-12 text-right mb-3">
                        <a href="{{ route('admin.exportCSVSample') }}">{{ trans('qrcode.export_csv_sample') }}</a>
                    </div>

                    <form id="importCSVForm" method="POST" action="{{ route('admin.importCSVQrCode') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv_file" class="form-control input-file" accept=".csv">
                        @if(Session::has('message_validate'))
                        <span class="text-danger text-center">{{ Session::get('message_validate') }}</span>
                        @endif
                        <br>
                        <div class="col-sm-12 text-center">
                            <button id="upload_csv_file" class="btn btn-primary btn-rounded waves-effect waves-light text-center">{{ trans('qrcode.button_import') }}</button>
                        </div>
                    </form>

                    <h5 id="upload_progress" class="text-center my-3 d-none">{{ trans('qrcode.csv_uploading') }}</h5>

                    <div id="pageloader" class="text-center d-none">
                        <img src="{!! asset('images/loading/Loading.gif') !!}" width="60" alt="Processing..." />
                    </div>

                </div>
        </div>
    </div>

@endsection
