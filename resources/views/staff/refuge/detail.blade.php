@section('title', trans('staff_refuge_detail.page_title')." - ".getPlaceName()." - ".getSystemName())

@extends('common.layouts.staff.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body common_font_site">
                    <div class="clearfix">
                        <h5 class="text-uppercase mt-0 text-center font-weight-bold size-21">{{ trans('staff_refuge_detail.section_title') }}</h5>
                        <hr>

                        <h4 class="text-uppercase mt-0 text-right">
                            <ins>{{ trans('staff_refuge_detail.section_title_sub') }} {{ $data->family_code }}</ins>
                        </h4>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center dataTables_wrapper">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label class="col-lg-2 col-md-3 col-sm-3 font-weight-bold common_font_site">{{ trans('common.evacuation_day') }}</label>
                                        <div class="col-lg-10 col-md-9 col-sm-9">
{{--                                            @if($data->qr_code)--}}
{{--                                                <div class="visible-print-staff text-right">--}}
{{--                                                    <img src="{{ asset('storage/' . $data->qr_code) }}">--}}
{{--                                                </div>--}}
{{--                                            @endif--}}

                                            @php
                                                $joinDate = strtotime($data->join_date);
                                            @endphp
                                            {{ date('Y', $joinDate) }} {{ trans('common.year') }} {{ date('m', $joinDate) }} {{ trans('common.month') }} {{ date('d', $joinDate) }} {{ trans('common.day') }}
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <label class="col-lg-2 col-md-3 col-sm-3 font-weight-bold common_font_site">{{ trans('staff_refuge_detail.street_address') }}</label>
                                        <div class="col-lg-10 col-md-9 col-sm-9 mb-2">
                                            〒 {{ $data->zip_code }} <br>
                                            {{ $data->perfecture_name . ' ' .  $data->address}}
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <label class="col-lg-2 col-md-3 col-sm-3 font-weight-bold common_font_site">{{ trans('staff_refuge_detail.phone_rep') }}</label>
                                        <div class="col-lg-9 col-md-9 col-sm-9">
                                            {{ $data->tel }}
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <label class="col-lg-2 col-md-3 col-sm-3 font-weight-bold common_font_site">{{ trans('common.language_register') }}</label>
                                        <div class="col-lg-10 col-md-9 col-sm-9">
                                            {{ getTextLanguage($data->language_register) }}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-md-2 col-sm-3 font-weight-bold common_font_site">{{ trans('staff_refuge_detail.household_list') }}</label>
                                        <div class="col-lg-10 col-md-10 col-sm-9 px-0">
                                            <div class="col-sm-12 row d-block m-0">
                                                <div class="page-title-right float-right text-right mb-2">
                                                    <form action="{{ route('staff.familyCheckout',$id) }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-primary btn-rounded mb-2 px-5" type="submit">
                                                            {{ trans('common.exit')  }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="col-sm-12 row m-0">
                                                <div class="table-responsive mb-3">
                                                    <table id="admin_top_table" class="table table-bordered table-striped dt-responsive mb-0 text-center">
                                                        <thead class="table-head">
                                                        <tr class="row-header">
                                                            @for ($i = 1; $i <= 9; $i++)
                                                                 @php
                                                                     $classItemTh = '';
                                                                    if ($i == 1){
                                                                       $classItemTh = 'm-w-60';
                                                                    }
                                                                    else if ($i == 2){
                                                                       $classItemTh = 'm-w-100';
                                                                    }
                                                                    else if ($i == 3){
                                                                       $classItemTh = 'm-w-200';
                                                                    }
                                                                    else if ($i == 7) {
                                                                      $classItemTh = 'm-w-120';
                                                                    }
                                                                    else if ($i == 4 || $i == 5 ) {
                                                                        $classItemTh = 'm-w-90';
                                                                    }
                                                                    else if ($i== 8 || $i == 9 ) {
                                                                        $classItemTh = 'm-w-140';
                                                                    }
                                                                    else $classItemTh = 'm-w-240';
                                                                 @endphp
                                                                <th class="{{ $classItemTh }}">{{ trans('staff_refuge_detail.th_' . $i) }}</th>
                                                            @endfor
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data->person as $key => $person)
                                                                <tr>
                                                                    <td>{{ ($key + 1) }}</td>
                                                                    <td class="w-75-px">
                                                                        @if ($person->is_owner == 0)
                                                                            {!! trans('staff_refuge_index.representative') !!}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $person->name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $person->age }}
                                                                    </td>
                                                                    <td>
                                                                        {{ getGenderName($person->gender) }}
                                                                    </td>
                                                                    <td>
                                                                        {{ trans('common.person_requiring_option')[$person->option] ?? ''}}
                                                                    </td>
                                                                    <td>
                                                                        {{ $person->note }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $person->created_at->format('Y/m/d') }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $data->updated_at && $data->updated_at != $data->created_at ? date('Y/m/d', strtotime($data->updated_at)): '' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <!-- end table -->
                                                </div>
                                                <!-- end div-table -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-sm-12">
                                    <form action="" method="">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <button type="button" class="btn btn-lg btn-outline-secondary btn-rounded waves-effect my-2 mx-4 px-5 m-w-2 common_font_site" onclick="window.location='{{ routeByPlaceId('staff.familyIndex') }}'">{{ trans('common.cancel') }}</button>
                                                <button type="button" class="btn btn-lg btn-primary btn-rounded my-2 mx-4 px-5 m-w-2 common_font_site" onclick="window.location='{{ routeByPlaceId('staff.editFamily', ['id' => $data->id]) }}'">{{ trans('common.edit') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
{{--                                <div class="col-lg-10 col-md-9 col-sm-9 offset-2 pl-0 custom-offset">--}}
                                <div class="col-lg-2 col-md-2 col-sm-3"></div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    @include('staff.refuge.history_join_log')
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-2"></div>
                                <!-- end col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
