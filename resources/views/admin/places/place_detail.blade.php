<?php
use Illuminate\Support\Facades\App;
?>

@section('title', trans('place.title_detail_page'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/place.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/place.js')}}"></script>
    <script src="{{ asset('js/admin/map.js')}}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&region=en&language=en&callback=initMap" type="text/javascript"></script>
    <script>
        var place_name = "{{ trans('common.place_name') }}";
        var place_address = "{{ trans('common.place_address') }}";
        var place_capacity = "{{ trans('common.place_capacity') }}";
        var place_people = "{{ trans('common.place_people') }}";
        var setting_scale = "{{ getScaleMap() }}";
        var place_percent = "{{ trans('common.place_percent') }}";
    </script>
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('place.title_detail_page') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="25%">{{ trans('place.place_name') }}</th>
                                    <td id="placeName"><span class="custom-text-long width-350">{{ getTextChangeLanguage($detail->name, $detail->name_en) }}</span></td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.zipcode') }}</th>
                                    <td id="address_1">{{ $detail->zip_code }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.address') }}</th>
                                    <td id="address_2"><span class="custom-text-long width-350">{{ getChangeAddressName($detail->prefecture_id, $detail->address, $detail->prefecture_en_id, $detail->address_en ) }}</span></td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.zipcode_default') }}</th>
                                    <td id="address_default_1">{{ $detail->zip_code_default }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.address_default') }}</th>
                                    <td id="address_2"><span class="custom-text-long width-350">{{ getChangeAddressName($detail->prefecture_id_default, $detail->address_default, $detail->prefecture_default_en_id, $detail->address_default_en ) }}</span></td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.capacity') }}</th>
                                    <td>{{ $detail->total_place }}{{ trans('place.people') }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.phone_number') }}</th>
                                    <td>{{ $detail->tel }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.lat') }} / {{ trans('place.lon') }}</th>
                                    <td>{{ $detail->map && $detail->map->latitude ? $detail->map->latitude :'' }} /
                                        {{ $detail->map && $detail->map->latitude ?  $detail->map->longitude : '' }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">URL</th>
                                    <td><a href="{{ route('userDashboard'). '?hinan=' . $detail->id  }}" target="_blank">{{ route('userDashboard'). '?hinan=' . $detail->id  }}</a></td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.altitude') }}</th>
                                    <td>{{ !empty($detail->altitude) ? $detail->altitude . 'm' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">{{ trans('place.status') }}</th>
                                    <td>{{ !empty($detail->active_flg) ? trans(('place.active')) : trans(('place.inActive')) }}</td>
                                </tr>
                            </table>
                        </div>
                        <input hidden value="{{ $placesResult }}" id="placeValue">
                        <div class="col-5">
                            <div id="map"></div>
                        </div>
                        <div class="col-3"></div>
                        <div class="col-6">
                            <div class="form-group button-submit">
                                <a href="{{ route("admin.adminPlaceList") }}"><button class="btn btn-rounded btn-outline-secondary my-2 width-128 common_font_site">{{ trans('common.back') }} </button></a>
                                <a href="{{ route("admin.adminEditPlace", ['id'=> request('id')]) }}">
                                    <button class="btn btn-primary btn-rounded my-2 width-128 common_font_site mr-2" type="submit">
                                        {{ trans('common.edit') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection
