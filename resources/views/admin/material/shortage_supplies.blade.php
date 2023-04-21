@section('title', trans('shortage-supplies.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/shortage_supply.js')}}"></script>
    <script src="{{ asset('js/admin/show_note.js') }}"></script>
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{ trans('shortage-supplies.title') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('admin.ShortageSupplyCsvExport') }}">
                            <button class="btn btn-primary btn-rounded my-2 px-4 common_font_site" type="button">
                                {{ trans('common.export') }}
                            </button>
                        </a>
                    </div>
                    <div class="row row mb-4">
                        <div class="col-12 table-responsive">
                            <table id="shortage-supply" class="table table-bordered mb-0 text-center">
                                <thead class="table-head">
                                <tr>
                                    <th>
                                        <div class="{{ (app()->getLocale() == 'ja') ? 'custom-name' :'' }}">
                                            {{ trans('shortage-supplies.place_name') }}
                                        </div>
                                    </th>
                                    @foreach($listMasterMaterial as $key => $item)
                                    <th>
                                        <div class="custom-item m-auto">{{ $item->name }} </div>
                                        @if($item->unit)
                                            <div>({{ $item->unit }})</div>
                                        @endif
                                    </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listShortageSuppliesByPlace as $place)
                                    <tr>
                                        <td>
                                            <span class="custom-text-long width-200">
                                            <a class="text-decoration-none cursor-hover @if($place['comment'] != '') text-primary @else text-dark @endif" data-toggle="modal" data-val="{{$place}}"  data-name="{{ getTextChangeLanguage($place['name'], $place['name_en']) }}" data-target="#modal_show_note">{{ getTextChangeLanguage($place['name'], $place['name_en']) }}</a>
                                            </span>
                                        </td>
                                        @foreach($place['supply'] as $key => $item)
                                            <td class="rowData{{ $key }}">{{ $item }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="totalColumn">
                                    <th>{{ trans('shortage-supplies.total_column') }}</th>
                                    @foreach($listMasterMaterial as $key => $item)
                                        <th id="{{ $item->id }}" class="total".{{ $item->id }}></th>
                                    @endforeach
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.material.modal_show_note')
@endsection
