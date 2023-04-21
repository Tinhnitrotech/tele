@section('title',trans('admin_top.title'))
@extends('common.layouts.app')
@push('head_css')
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/admin_top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/switcher.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/admin_top.js')}}"></script>
    <script src="{{ asset('js/change_status_full_modal.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.switcher.js') }}"></script>
    <script>$.switcher();</script>
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="page-title mb-0">{{trans('admin_top.title')}}</h5>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('message'))
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="alert alert-success alert-block text-center">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-4 mt-5">
                        <div class="col-12">
                            <div class="row justify-content-center dataTables_wrapper">
                                <div class="col-sm-12">
                                    <div class="table-responsive mb-3">
                                        <table id="admin_top_table"
                                               class="table table-striped table-bordered dt-responsive mb-0">
                                            <thead class="table-head">
                                                <tr>
                                                    <th>{{trans('admin_top.place_name')}}</th>
                                                    <th class="width-column-three-letter">{{trans('admin_top.capacity')}}</th>
                                                    <th class="width-column-three-letter">{{trans('admin_top.number_of_evacuees')}}</th>
                                                    <th class="width-column">{{trans('admin_top.accommodation_rate')}}</th>
                                                    <th class="width-column-two-letter">{{trans('admin_top.household')}}</th>
                                                    <th class="width-column-two-letter">{{trans('admin_top.count_person')}}</th>
                                                    <th class="width-column-one-letter">{{trans('common.male')}}</th>
                                                    <th class="width-column-one-letter">{{trans('common.female')}}</th>
                                                    @foreach(trans('common.person_requiring_option') as $valueTrans)
                                                        <th class="width-column-two-letter">{{$valueTrans}}</th>
                                                    @endforeach
                                                    <th class="width-column-two-letter">{{trans('admin_top.remaining_number_people')}}</th>
                                                    <th class="width-column-three-letter">{{trans('admin_top.full_status')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $value)
                                                <tr>
                                                    <td><span class="custom-text-long width-200">{{ getTextChangeLanguage($value->name, $value->name_en) }}</span></td>
                                                    <td class="rowDataSd1"><span class="custom-text-long width-128">{{ $value->total_place }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd2"><span class="custom-text-long width-128">{{ $value->totalPerson + $value->countPerson }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSdAvg1">
                                                        <span class="custom-text-long width-100">
                                                        @if ($value->full_status == config('constant.place_is_full'))
                                                            100%
                                                        @else
                                                            {{ $value->rateSheltered }}{{config('constant.rate')}}
                                                            @endif
                                                        </span>
                                                       </td>
                                                    <td class="rowDataSd3"><span class="custom-text-long width-100">{{ $value->countFamily }}{{trans('admin_top.household')}}</span></td>
                                                    <td class="rowDataSd4"><span class="custom-text-long width-128">{{ $value->countPerson }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd5"><span class="custom-text-long width-40">{{ $value->countMale }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd6"><span class="custom-text-long width-40">{{ $value->countFemale }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd7"><span class="custom-text-long width-100">{{ $value->countPregnantWoman }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd8"><span class="custom-text-long width-100">{{ $value->countInfant }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd9"><span class="custom-text-long width-100">{{ $value->countPersonsWithDisabilities }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd10"><span class="custom-text-long width-100">{{ $value->countNursingCareRecipient }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd11"><span class="custom-text-long width-128">{{ $value->countMedicalDeviceUsers }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd12"><span class="custom-text-long width-128">{{ $value->countAllergies }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd13"><span class="custom-text-long width-60">{{ $value->countForeignNationality }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd14"><span class="custom-text-long width-60">{{ $value->countNewbornBaby }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd15"><span class="custom-text-long width-60">{{ $value->countOther }}{{trans('admin_top.people')}}</span></td>
                                                    <td class="rowDataSd16"><span class="custom-text-long width-128">
                                                        @if ($value->full_status == config('constant.place_is_full'))
                                                                0{{trans('admin_top.people')}}
                                                        @else
                                                            {{ $value->restSheltered }}{{trans('admin_top.people')}}
                                                        @endif
                                                        </span>
                                                       </td>
                                                    <td data-toggle="modal" class="rowDataSd17 align-middle" data-target="#modal_confirm_change_status_full" data-url="{{ route('admin.changeFullStatus',['id'=> $value->id] ) }}">
                                                        <span class="custom-text-long width-60">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="{{ $value->id }}"  @if($value->full_status) checked @endif >
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                                <tr class="totalColumn">
                                                    <th width="20%"> {{trans('admin_top.total')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="average">{{config('constant.rate')}}</th>
                                                    <th class="total">{{trans('admin_top.household')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th class="total">{{trans('admin_top.people')}}</th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- pagination -->
                                {{ $data->render('common.layouts.pagination') }}
                                <!-- end pagination -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.layouts.confirm_change_full_status_modal')
@endsection
