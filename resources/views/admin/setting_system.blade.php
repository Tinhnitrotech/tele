@section('title', trans('setting_system.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    @include('admin.validation.validate_setting_system')
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('setting_system.title') }}</h5>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.postSettingSystem') }}" method="POST" id="setting-form" enctype="multipart/form-data">
                    @csrf
                        @if ($message = Session::get('message'))
                            <div class="alert alert-success alert-block text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-warning alert-block text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.map_scale') }}</label>
                                    <div class="col-lg-9">
                                        <select name="map_scale" class="form-control" >
                                            <option value="">{{ trans('user_register.please_select') }}</option>
                                            @for($i = 1; $i <= 25 ; $i++)
                                                <option @if(isset($setting->map_scale) && $i == $setting->map_scale) selected @endif value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('map_scale')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.footer') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('footer', isset($setting->footer) ? $setting->footer : null) }}" name="footer">
                                        @error('footer')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3 setting">{{ trans('setting_system.setting_ja') }}</div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.type_name') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('type_name_ja', isset($setting->type_name_ja) ? $setting->type_name_ja : null) }}" name="type_name_ja">
                                        @error('type_name_ja')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.system_name') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('system_name_ja', isset($setting->system_name_ja) ? $setting->system_name_ja : null) }}" name="system_name_ja">
                                        @error('system_name_ja')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.disclosure_info') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('disclosure_info_ja', isset($setting->disclosure_info_ja) ? $setting->disclosure_info_ja : null) }}" name="disclosure_info_ja">
                                        @error('disclosure_info_ja')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3 setting">{{ trans('setting_system.setting_en') }}</div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.type_name') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('type_name_en', isset($setting->type_name_en) ? $setting->type_name_en : null) }}" name="type_name_en">
                                        @error('type_name_en')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.system_name') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('system_name_en', isset($setting->system_name_en) ? $setting->system_name_en : null) }}" name="system_name_en">
                                        @error('system_name_en')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('setting_system.disclosure_info') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" value="{{ old('disclosure_info_en', isset($setting->disclosure_info_en) ? $setting->disclosure_info_en : null) }}" name="disclosure_info_en">
                                        @error('disclosure_info_en')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-3 setting">{{ trans('setting_system.label_map') }}</div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans(('place.lat'))}}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control number_float" type="text" value="{{ old('latitude', isset($setting->latitude) ? $setting->latitude : null) }}" name="latitude">
                                        @error('latitude')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans(('place.lon'))}}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control number_float" type="text" value="{{ old('longitude', isset($setting->longitude) ? $setting->longitude : null) }}" name="longitude">
                                        @error('longitude')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-3 setting"></div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-3 col-form-label">{{ trans('common.logo_image') }}</label>
                                    <div class="col-lg-9">
                                        <input class="form-control input-file" type="file" name="image_logo"/>
                                        @error('image_logo')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mb-0 mt-4">
                            <button class="btn btn-lg btn-primary btn-rounded my-2 mx-4 px-5" type="submit">
                                {{ trans('setting_system.save') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
