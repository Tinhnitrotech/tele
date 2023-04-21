@section('title',request() ->id ? trans('place.title_edit_page'): trans('place.title_create_page') )
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/place.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dist_admin/assets/libs/switchery/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/map.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/check_postal_code.js') }}"></script>
    <script src="{{ asset('js/admin/place.js') }}"></script>
    <script src="{{ asset('js/admin/place_register.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('dist_admin/assets/libs/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('js/admin/button.js')}}"></script>
    <script src="{{ asset('js/admin/map.js')}}"></script>
    <script src="{{ asset('js/delete_modal.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&region=en&language=en&callback=loadMap" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).on("input", ".check_postcode", function() {
            AjaxZip3.zip2addr('postal_code_1', 'postal_code_2', 'prefecture_id', 'address');
        });

        $(document).on("input", ".check_postcode_default", function() {
            AjaxZip3.zip2addr('postal_code_default_1', 'postal_code_default_2', 'prefecture_id_default', 'address_default');
        });
    </script>
    <script>
        var setting_scale = "{{ getScaleMap() }}";
    </script>
    @include('admin.places.validate_place')
@endpush

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                @if($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0"> {{ request()->id ? trans('place.title_edit_page') : trans('place.title_create_page') }}</h5>
                            </div>
                        </div>
                    </div>
                    <form action="{{request()->id ? route('admin.adminEdit',['id'=>request()->id]) : route('admin.adminCreate') }}" method="post" id="placeForm">
                        @csrf
                        @if(request()->id)
                            @method('put')
                        @endif
                        <div class="row mb-4">
                            <div class="col-lg-7">
                                <div class="form-group row">
                                    <label class="col-lg-4">{{ trans('place.place_name') }}<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="name" value="{{ old('name', isset($detail->name) ? $detail->name : null) }}">
                                        @error('name')
                                            <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">{{ trans('place.place_name_en') }}</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="name_en" value="{{ old('name_en', isset($detail->name_en) ? $detail->name_en : null) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.street_address') }}<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <div class="row" id="auto_next">
                                            <div class="col-lg-1 col-md-1">
                                                <label class="col-form-label">〒</label>
                                            </div>
                                            <div class="col-lg-5 col-md-5">
                                                <input class="form-control check_postcode" type="text" maxlength="3" oninput="postalCode(this.id)" value="{{ old('postal_code_1', isset($detail->postal_code_1) ? $detail->postal_code_1 : null) }}"  name="postal_code_1" id="postal_code_1">
                                                @error('postal_code_1')
                                                    <span class="text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-1 col-md-1 space-input">-</div>
                                            <div class="col-lg-5 col-md-5">
                                                <input class="form-control check_postcode" type="text" maxlength="4" oninput="postalCode(this.id)" value="{{ old('postal_code_2', isset($detail->postal_code_2) ? $detail->postal_code_2 : null) }}" name="postal_code_2" id="postal_code_2">
                                                @error('postal_code_2')
                                                    <span class="text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label"></label>
                                    <div class="col-lg-3">
                                        <select name="prefecture_id" class="form-control" >
                                            @if(request()->id)
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture() as $value => $type)
                                                    <option @if ($detail->prefecture_id == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @else
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture() as $value => $type)
                                                    <option @if (old('prefecture_id') == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                        @error('prefecture_id')
                                            <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="text" name="address" value="{{ old('address', isset($detail->address) ? $detail->address : null) }}">
                                        @error('address')
                                            <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.address_en') }}</label>
                                    <div class="col-lg-3">
                                        <select name="prefecture_en_id" class="form-control" >
                                            @if(request()->id)
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture_en() as $value => $type)
                                                    <option @if ($detail->prefecture_en_id == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @else
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture_en() as $value => $type)
                                                    <option @if (old('prefecture_id') == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="text" name="address_en" value="{{ old('address_en', isset($detail->address_en) ? $detail->address_en : null) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.street_address_default') }}<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <div class="row" id="auto_next">
                                            <div class="col-lg-1 col-md-1">
                                                <label class="col-form-label">〒</label>
                                            </div>
                                            <div class="col-lg-5 col-md-5">
                                                <input class="form-control check_postcode_default" type="text" maxlength="3" oninput="postalCode(this.id)" value="{{ old('postal_code_default_1', isset($detail->postal_code_default_1) ? $detail->postal_code_default_1 : null) }}"  name="postal_code_default_1" id="postal_code_default_1" >
                                                @error('postal_code_default_1')
                                                <span class="text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-1 col-md-1 space-input">-</div>
                                            <div class="col-lg-5 col-md-5">
                                                <input class="form-control check_postcode_default" type="text" maxlength="4" oninput="postalCode(this.id)" value="{{ old('postal_code_default_2', isset($detail->postal_code_default_2) ? $detail->postal_code_default_2 : null) }}" name="postal_code_default_2" id="postal_code_default_2" >
                                                @error('postal_code_default_2')
                                                <span class="text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label"></label>
                                    <div class="col-lg-3">
                                        <select name="prefecture_id_default" class="form-control" >
                                            @if(request()->id)
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture() as $value => $type)
                                                    <option @if ($detail->prefecture_id_default == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @else
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture() as $value => $type)
                                                    <option @if (old('prefecture_id_default') == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                        @error('prefecture_id_default')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="text" name="address_default" value="{{ old('address_default', isset($detail->address_default) ? $detail->address_default : null) }}">
                                        @error('address_default')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.address_default_en') }}</label>
                                    <div class="col-lg-3">
                                        <select name="prefecture_default_en_id" class="form-control" >
                                            @if(request()->id)
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture_en() as $value => $type)
                                                    <option @if ($detail->prefecture_default_en_id == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @else
                                                <option value="">{{ trans('user_register.please_select') }}</option>
                                                @foreach(get_prefecture_en() as $value => $type)
                                                    <option @if (old('prefecture_id') == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="text" name="address_default_en" value="{{ old('address_default_en', isset($detail->address_default_en) ? $detail->address_default_en : null) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.capacity') }}<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="total_place" value="{{ old('total_place', isset($detail->total_place) ? $detail->total_place : null) }}" >
                                        @error('total_place')
                                            <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.phone_number') }}<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="tel" value="{{ old('tel', isset($detail->tel) ? $detail->tel : null) }}" >
                                        @error('tel')
                                            <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans(('place.lat'))}}
                                        - {{trans(('place.lon')) }} <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <input class="form-control number_float" name="latitude" id="latitude" value="{{ old('latitude', isset($detail->map->latitude) ? $detail->map->latitude : null)  }}" >
                                        @error('latitude')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <input class="form-control number_float" name="longitude" id="longitude" value="{{ old('longitude', isset($detail->map->longitude) ? $detail->map->longitude : null) }}" >
                                        @error('longitude')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans('place.altitude') }}<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="altitude" value="{{ old('altitude', isset($detail->altitude) ? $detail->altitude : null) }}" >
                                        @error('altitude')
                                        <span class="text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label ">{{ trans(('place.status')) }}</label>
                                    <div class="col-lg-8">
                                        @if(request()->id)
                                            <input class="js-switch-status" name="active_flag" type="checkbox"
                                                       data-plugin="switchery" @if(!empty($detail->active_flg)) checked @endif>
                                        @else
                                            <input class="js-switch-status" name="active_flag" type="checkbox"
                                                   data-plugin="switchery">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input hidden value="[]" id="placeValue">
                            <input hidden id="placeLat" value="{{ isset($detail->map->latitude) ? $detail->map->latitude : getLatitudeDefault() }}">
                            <input hidden id="placeLng" value="{{ isset($detail->map->longitude) ? $detail->map->longitude : getLongitudeDefault() }}">
                            <div class="col-lg-5">
                                <div id="map"></div>
                                <input id="address" type="text" placeholder="{{ trans('place.search_address') }}"  />
                                <button type="button" id="submit">{{ trans('place.search') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <div class="form-group button-submit ">
                                    <a href="{{ request() ->id ? route('admin.adminDetail',['id'=>request() ->id]) : route("admin.adminPlaceList") }}">
                                        <button class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site" type="button">
                                            {{ trans('place.cancel') }}
                                        </button>
                                    </a>

                                    <button class="btn btn-primary btn-rounded my-2 width-128 common_font_site mr-2" type="submit">
                                        {{ request() ->id ? trans('place.update'):trans('place.submit') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-3 text-right">
                                @if(request()->id)
                                    <div class="form-group button-delete">
                                        <div data-toggle="modal" class=" align-middle @if($detail->is_active) dClick @endif" data-target="#modal_confirm_delete" data-url="{{ route('admin.placeDelete',['id'=> $detail->id ,'name'=>$detail->name] ) }}">
                                            <button class="btn my-2 width-128 @if($detail->is_active) btn-secondary btn-rounded @else btn-danger button-register @endif" type="button">{{ trans('place.action_column') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('common.layouts.confirm_delete_modal')
@endsection
