@section('title', trans('place.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/place.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dist_admin/assets/libs/switchery/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/switcher.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('dist_admin/assets/libs/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('js/admin/place.js') }}"></script>
    <script src="{{ asset('js/delete_modal.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.switcher.js') }}"></script>
    <script src="{{ asset('js/change_active_status_modal.js') }}"></script>
    <script>
        $.switcher();
    </script>
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('place.title') }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-3 text-center">
                                @if(Session::has('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong>{{ Session::get('message') }}</strong>

                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong>{{ $errors->first() }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-right float-right mt-5 mb-4">
                                    <a href="{{ route('admin.importCSVViewPlace') }}" class="text-white"><button class="btn btn-primary btn-rounded my-2 px-4 common_font_site mr-2">
                                        {{ trans('common.import') }}</button></a>
                                    <a href="{{ route('admin.exportCSVPlace') }}" class="text-white"><button class="btn btn-primary btn-rounded my-2 px-4 common_font_site mr-2">
                                        {{ trans('common.export') }}
                                        </button></a>
                                    <button class=" btn button-add btn-rounded my-2 px-4 common_font_site"
                                            onclick="window.location='{{ route("admin.adminCreatePlace") }}'">
                                        {{ trans('place.button_create') }}
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
                                        <table id="admin_top_table" class="table table-bordered dt-responsive mb-0">
                                            <thead class="table-head">
                                            <tr>
                                                <th class="align-middle" width="5%">ID</th>
                                                <th class="align-middle" width="40%">{{ trans('place.place_name') }}</th>
                                                <th class="align-middle" width="25%">{{ trans('place.address') }}</th>
                                                <th class="align-middle" width="10%">{{ trans('place.capacity') }}</th>
                                                <th class="align-middle" width="10%">{{ trans('place.phone_number') }}</th>
                                                <th class="align-middle" width="10%">{{ trans('place.status') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($result) > 0)
                                            @foreach($result as $key => $value)
                                                <tr>
                                                    <td class="align-middle">{{ $value->id }}</td>
                                                    <td class="align-middle"><span class="custom-text-long width-300">
                                                        <a href="{{route('admin.adminDetail',['id'=>$value->id])}}">{{ getTextChangeLanguage($value->name, $value->name_en) }}</a>
                                                        </span>
                                                    </td>
                                                    <td class="align-middle"><span class="custom-text-long width-250">{{ $value->address_place }}</span></td>
                                                    <td class="align-middle">{{ $value->total_place }}{{trans('place.people')}}</td>
                                                    <td class="align-middle">{{ $value->tel }}</td>
                                                    <td data-toggle="modal" class="align-middle @if($value->is_active) dClick disable_button  @endif" data-target="#modal_confirm_change_active_status" data-url="{{ route('admin.changeActiveStatus',['id'=> $value->id] ) }}">
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox" value="{{ $value->id }}"  @if ($value->active_flg) checked @endif >
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
                                </div>
                                <!-- pagination -->
                                {{ $result->render('common.layouts.pagination') }}
                                <!-- end pagination -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('common.layouts.confirm_change_active_status_modal')
@endsection
