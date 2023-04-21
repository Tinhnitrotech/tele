@section('title', trans('qrcode.title_import'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/import_csv.js')}}"></script>
    <script src="{{ asset('js/delete_modal.js') }}"></script>
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

                @if (!is_null($batch))
                    @if ($batch->failedJobs < 1)
                    <div id="progress_info" class="text-center mt-3">
                        @if ($batch->progress() == 100)
                            <h5>{{ trans('qrcode.qrcode_render_success') }}</h5>
                        @else
                            <h5>{{ trans('qrcode.qrcode_rendering') }}</h5>
                        @endif

                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="{{ $batch->progress() }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $batch->progress() }}%;">
                                {{ $batch->progress() }}%
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($batch->progress() < 100 && $batch->failedJobs < 1)
                        <div id="progress_reload" class="d-none"></div>
                    @endif

                    @if ($batch->progress() == 100)
                        <div class="col-sm-12 text-center my-3">
                            <div id="download_zip_section">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_confirm_delete" data-url="{{ route('admin.cancelZipQrCode') }}">
                                    <button class="btn btn-rounded btn-outline-secondary mr-4 width-128 common_font_site">{{ trans('qrcode.delete') }}</button>
                                </a>
                                <a href="{{ route('admin.downloadZipQrCode') }}">
                                    <button id="download_zip_file" class="btn btn-primary btn-rounded waves-effect waves-light text-center">{{ trans('qrcode.download') }}</button>
                                </a>
                            </div>
                        </div>
                    
                        <h5 id="download_progress" class="text-center my-3 d-none">{{ trans('qrcode.qrcode_downloading') }}</h5>
                    @endif

                @endif

                @if (is_null($batch) || $batch->failedJobs > 0)
                    <div class="col-sm-12 text-center my-3">
                        <h5 id="fail_job" class="text-center my-3">{{ trans('qrcode.create_qrcode_fail') }}</h5>
                        <a href="{{ route('admin.cancelZipQrCode') }}">
                            <button class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site">{{ trans('common.back') }}</button>
                        </a>
                    </div>
                @endif

                    <div id="pageloader" class="text-center d-none">
                        <img src="{!! asset('images/loading/Loading.gif') !!}" width="60" alt="Processing..." />
                    </div>

                </div>
        </div>
    </div>

@include('common.layouts.confirm_delete_method_get_modal')
@endsection
