@section('title',request() ->id ? trans('material.title_edit_page'): trans('material.title_create_page') )
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/place.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('admin.validation.add_master_material_validate')
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ request() ->id ? trans('material.title_edit_page') : trans('material.title_create_page') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row row mb-4">
                        <div class="col-lg-6">
                            <form id="add-master-material-form" action="{{ request()->id ? route('admin.adminUpdateMaterial', request()->id ) : route('admin.adminAddMaterial') }} " method="post">
                                @csrf
                                @if(request()->id)
                                    @method('put')
                                @endif
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">{{ trans('material.supply_name') }}<span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" name="name" value="{{ old('name', isset($detail->name) ? $detail->name : null) }}">
                                        @if($errors->has('name'))
                                            <span class="text-danger font-weight-bold text-center">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">{{ trans('material.unit') }}</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" name="unit" value="{{ old('unit', isset($detail->unit) ? $detail->unit : null) }}">
                                        @if($errors->has('unit'))
                                            <span class="text-danger font-weight-bold text-center">{{ $errors->first('unit') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mr-0 row">
                                    <div class="col-3"></div>
                                    <div class="col-9 button-submit">
                                        <a class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site" href="{{ route("admin.adminMaterialList") }}" >
                                                {{ trans('material.cancel') }}
                                        </a>
                                        <button class="btn btn-primary btn-rounded my-2 width-128 common_font_site mr-2" type="submit">
                                            {{ request() ->id ? trans('material.update') : trans('material.submit') }}
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
