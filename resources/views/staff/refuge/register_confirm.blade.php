@section('title', trans('user_register.title_register')." - ".getPlaceName()." - ".getSystemName())
@extends('common.layouts.user.main')
@push('head_css')
    <link rel="stylesheet" href="{{ asset('css/user/register.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/user/register.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="clearfix">
                                <h5 class="mt-0 text-center title_on_page">{{ trans('staff_refuge_detail.section_title') }}</h5>
                            </div>
                            <hr>
                            @if (!empty($data) && sizeof($data) > 0)
                                <form action="{{ route('staff.postAddFamily') }}" method="POST">
                                    @csrf
                                    @php
                                        $data['person'] = array_values($data['person']);
                                    @endphp
                                    <input type="hidden" name="user_register_family" value="1">

                                    <input type="hidden" name="join_date" value="{{ $data['join_date'] }}">
                                    <input type="hidden" name="postal_code_1" value="{{ $data['postal_code_1'] }}">
                                    <input type="hidden" name="postal_code_2" value="{{ $data['postal_code_2'] }}">
                                    <input type="hidden" name="prefecture_id" value="{{ $data['prefecture_id'] }}">
                                    <input type="hidden" name="address" value="{{ $data['address'] }}">
                                    <input type="hidden" name="address_default" value="{{ $data['address_default'] }}">
                                    <input type="hidden" name="tel" value="{{ $data['tel'] }}">
                                    <input type="hidden" name="password" value="{{ $data['password'] }}">

                                    @foreach ($data['person'] as $key => $person)
                                        <input type="hidden" name="person[{{$key+1}}][id]" value="{{ $person['id'] }}">
                                        <input type="hidden" name="person[{{$key+1}}][name]" value="{{ $person['name'] }}">
                                        <input type="hidden" name="person[{{$key+1}}][age]" value="{{ $person['age'] ?? '' }}">
                                        <input type="hidden" name="person[{{$key+1}}][gender]" value="{{ $person['gender'] ?? '' }}">
                                        <input type="hidden" name="person[{{$key+1}}][option]" value="{{ $person['option'] ?? '' }}">
                                        <input type="hidden" name="person[{{$key+1}}][note]" value="{{ $person['note'] ?? '' }}">
                                    @endforeach
                                    <input type="hidden" name="is_owner" value="{{ $data['is_owner'] }}">
                                    <input type="hidden" name="is_public" value="{{ $data['is_public'] }}">
                                    @if($data['public_info'])
                                        <input type="hidden" name="public_info" value="{{ ($data['public_info']) }}">
                                    @endif

                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label class="col-md-2 font-weight-bold common_font_site">{{ trans('common.evacuation_day') }}</label>
                                            <div class="col-md-10 mb-3 size-32">
                                                @php
                                                    $joinDate = strtotime($data['join_date']);
                                                @endphp
                                                {{ date('Y', $joinDate) }} {{ trans('common.year') }} {{ date('m', $joinDate) }} {{ trans('common.month') }} {{ date('d', $joinDate) }} {{ trans('common.day') }}
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <label class="col-md-2 font-weight-bold common_font_site">{{ trans('staff_refuge_detail.street_address') }}</label>
                                            <div class="col-md-10 mb-3 size-32">
                                                〒 {{ $data['postal_code_1'] }}-{{ $data['postal_code_2'] }} &emsp;
                                                {{ config('app.locale') == config('constant.language_ja') ? get_prefecture_name($data['prefecture_id']) : get_prefecture_name_en($data['prefecture_id']) }} {{ $data['address'] }}
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <label class="col-md-2 font-weight-bold common_font_site">{{ trans('staff_refuge_detail.phone_rep') }}</label>
                                            <div class="col-md-10 mb-3 size-32">
                                                {{ $data['tel'] }}
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <label class="col-md-2 font-weight-bold common_font_site">{{ trans('common.password') }}</label>
                                            <div class="col-md-10 mb-3 size-32">
                                                {{ $data['password'] }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 font-weight-bold common_font_site">{{ trans('staff_refuge_detail.household_list') }}</label>
                                            <div class="col-md-10 px-0">

                                                <div class="col-sm-12 row m-0">
                                                    <div class="table-responsive mb-3">
                                                        <table id="admin_top_table" class="table table-bordered table-striped dt-responsive mb-0 text-center">
                                                            <thead class="table-head">
                                                            <tr class="row-header">
                                                                @for ($i = 1; $i <= 8; $i++)
                                                                    <th class="common_font_site @if($i == 1) w-75-px @elseif($i == 2 || $i == 7) m-w-140 @elseif($i == 4 || $i == 5) m-w-90 @else m-w-240 @endif">{{ trans('staff_refuge_detail.th_' . $i) }}</th>
                                                                @endfor
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data['person'] as $key => $person)
                                                                    <tr>
                                                                        <td>{{ ($key + 1) }}</td>
                                                                        <td class="w-75-px common_font_site">
                                                                            @if ($person['id'] == $data['is_owner'])
                                                                                {!! trans('staff_refuge_index.representative') !!}
                                                                            @endif
                                                                        </td>
                                                                        <td class="common_font_site">
                                                                            {{ $person['name'] ?? '' }}
                                                                        </td>
                                                                        <td class="common_font_site">
                                                                            {{ $person['age'] ?? '' }}
                                                                        </td>
                                                                        <td class="common_font_site">
                                                                            {{ !empty($person['gender']) ? getGenderName($person['gender']) : '' }}
                                                                        </td>
                                                                        <td class="common_font_site">
                                                                            {{ !empty($person['option']) ? trans('common.person_requiring_option')[$person['option']] : '' }}
                                                                        </td>
                                                                        <td class="common_font_site">
                                                                            {{ $person['note'] ?? '' }}
                                                                        </td>
                                                                        <td class="common_font_site">
                                                                            {{ date('Y/m/d') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <!-- end table -->
                                                    </div>
                                                    <!-- end div-table -->
                                                </div>
                                                <!-- end col -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="form-group text-center">
                                        <a href="{{ routeByPlaceId('staff.addFamily') }}">
                                            <button type="button" class="btn btn-outline-primary waves-effect waves-light mr-0 mx-2 btn-bottom">
                                                {{ trans('user_register.cancel') }}
                                            </button>
                                        </a>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-0 mx-2 btn-bottom">
                                            {{ trans('user_register.submit') }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('staff.refuge.template_family')
@endsection

