@section('title', trans('statistics.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('dist_admin/assets/libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/chart.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('dist_admin/assets/libs/d3/d3.min.js')}}"></script>
    <script src="{{ asset('dist_admin/assets/libs/c3/c3.min.js')}}"></script>
    <script src="{{ asset('dist_admin/assets/js/pages/c3.init.js')}}"></script>
    <script src="{{ asset('js/admin/statics.js')}}"></script>
    <script>
        let male = "{{ trans('common.male') }}"
        let female = "{{ trans('common.female') }}"
        let personSpecial = "{{ trans('common.person_special_percent') }}"
        let total_capacity = "{{ trans('statistics.total_capacity') }}"
        let current_capacity = "{{ trans('statistics.current_capacity') }}"
        var routeErr = "{{ route('admin.statistics') }}";
    </script>
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="tabs-container">
                <div class="tabs-content">
                    <div class="active">
                        <div class="card-box">
                            <div class="panel-body">

                                <div class="d-none loading text-primary" id="loading">Loading&#8230;</div>
                                <div class="clearfix">
                                    <div class="row mb-5">
                                        <div class="col-12">
                                            <h5 class="page-title mb-0">{{ trans('statistics.title') }}</h5>
                                        </div>
                                    </div>
                                </div>
                               <div class="row">
                                   <div class="col-4">

                                   </div>
                                   <div class="col-4">
                                       <div class="form-group my-4">
                                           <select class="form-control" id="exampleSelect1" onchange="changeStatus(this.value)">
                                               <?php $typeStatic  = config('constant.type_static'); ?>
                                               @foreach($typeStatic as $key => $value)
                                                   <option value="{{ $key }}">{{ $value }}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </div>
                               </div>

                                <div class="row row mb-4">
                                    <div>
                                        <input id="data" value="{{ $data['list_place'] }}" type="hidden">
                                        <input id="name-data" value="{{ trans('statistics.name_data') }}" type="hidden">
                                    </div>
                                    <div class="col-12" style="overflow-x: auto">
                                        <div id="chartPlace" style=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
