@extends('common.layouts.app')
@section('title', request()->id ? trans('staff_management.edit_title') : trans('staff_management.create_title'))
@push('head_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/staff_management.css') }}">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('/js/check_postal_code.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('/js/admin/add_staff.js') }}"></script>
    <script type="text/javascript">
        $(document).on("input", ".check_postcode", function() {
            AjaxZip3.zip2addr('postal_code_1', 'postal_code_2', 'prefecture_id', 'address');
        });
    </script>
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('admin.validation.register_staff_validate')
@endpush
@section('content')
    {{request()->get('id')}}
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="title-content-page">{{ request()->id ? trans('staff_management.edit_title') : trans('staff_management.create_title') }}</div>
                @include('common.flash_message')
                <form id="register-staff-form" action="{{ request()->id ? Route('admin.staffManagementUpdate', request()->id) : Route('admin.staffManagementStore') }}" class="row" method="post">
                    @csrf
                    @if(request()->id)
                        @method('put')
                    @endif
                    <div class="col-lg-6 common_font_site">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-lg-4 col-form-label">{{ trans('staff_management.name_no_kana') }} <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" id="example-text-input" name="name" value="{{ old('name', isset($detail->name) ? $detail->name : null) }}" >
                                @if($errors->has('name'))
                                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-lg-4 col-form-label">{{ trans('staff_management.email') }} <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control" type="email" name="email" value="{{ old('email', isset($detail->email) ? $detail->email : null) }}" >
                                @if($errors->has('email'))
                                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-lg-4 col-form-label">{{ trans('staff_management.tel') }} <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" name="tel" value="{{ old('tel', isset($detail->tel) ? $detail->tel : null) }}" >
                                @if($errors->has('tel'))
                                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('tel') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8 mt-4 button-submit">
                                <a class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site" href="{{ route("admin.staffManagement") }}" type="button">
                                    {{ trans('staff_management.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary btn-rounded my-2 width-128 common_font_site mr-2">
                                    {{ request()->id ? trans('staff_management.update') : trans('staff_management.submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
