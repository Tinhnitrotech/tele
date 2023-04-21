@section('title', trans('staff_supplies_index.page_title')." - ".getPlaceName()." - ".getSystemName())

@extends('common.layouts.staff.app')

@push('head_css')
    <link href="{{ asset('css/staff/supplies_index.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('js/staff/supplies_index.js') }}"></script>
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    @include('staff.supplies.validate.supplies_validate')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel-body common_font_site">
                    <div class="clearfix">
                        <h5 class="text-uppercase mt-0 text-center font-weight-bold size-32">{{ trans('staff_supplies_index.section_title') }}</h5>
                        <hr>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-12 text-center">
                                    <h5 class="mb-4 size-21">{{ trans('staff_supplies_index.sub_title') }}</h5>
                                </div>
                                <!-- end col -->
                                <form action="{{ route('staff.postSupplies') }}" method="POST" id="supply-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-xl-8 col-lg-12 text-center">
                                            @if ($message = Session::get('message'))
                                                <div class="alert alert-success alert-block text-center">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @endif
                                            @if ($error = Session::get('error'))
                                                <div class="alert alert-danger alert-block text-center">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <strong>{{ $error }}</strong>
                                                </div>
                                            @endif

                                            <input type="hidden" name="place_id" value="{{ $placeId }}">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped dt-responsive mb-0">
                                                    <thead>
                                                    <tr class="text-center row-header">
                                                        <th>No.</th>
                                                        <th class="m-w-140">{{ trans('staff_supplies_index.substance') }}</th>
                                                        <th class="m-w-140">{{ trans('staff_supplies_index.quantity') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="family_content">
                                                    @if ($listMasterMaterial->isNotEmpty())
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($listMasterMaterial as $material)
                                                            <tr>
                                                                <td class="text-center">
                                                                    {{ $i }}
                                                                </td>
                                                                <td>
                                                                    {{ $material->name ?? '' }}
                                                                    <span>
                                                                        <input type="hidden" name="supply[{{$i}}][m_supply_id]" value="{{ $material->id }}" required >
                                                                    </span>
                                                                    <div class="info_error"></div>
                                                                    @if($errors->has('supply.'.$i.'.m_supply_id'))
                                                                        <div class="text-danger font-weight-bold mt-1">{{ $errors->first('supply.'.$i.'.m_supply_id') }}</div>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="buttons_added">
                                                                        <input class="minus is-form" type="button" value="-">
                                                                        <input aria-label="quantity" class="form-control input-qty" name="supply[{{$i}}][number]" type="text" value="{{ !empty($material->number) ? $material->number : 0 }}" >
                                                                        <input class="plus is-form" type="button" value="+">
                                                                    </div>
                                                                    <div class="info_error"></div>
                                                                    @if($errors->has('supply.'.$i.'.number'))
                                                                        <div class="text-danger font-weight-bold mt-1">{{ $errors->first('supply.'.$i.'.number') }}</div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                                <!-- end table -->
                                            </div>

                                            <div class="mt-4">
                                                <h5 class="text-muted">{{ trans('staff_supplies_index.textarea_title_1') }}</h5>
                                                <span>
                                                <textarea
                                                    class="form-control @if($errors->get('comment')) is-invalid @endif"
                                                    rows="3"
                                                    name="comment"
                                                    placeholder="" >{{ oldDataCustom('comment', $data['supplyNotes']) }}</textarea>
                                            </span>
                                                <div class="info_error"></div>
                                                @if($errors->has('comment'))
                                                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('comment') }}</span>
                                                @endif
                                            </div>

                                            <div class="mt-4">
                                                <h5 class="text-muted">{{ trans('staff_supplies_index.textarea_title_2') }}</h5>
                                                <span>
                                                <textarea
                                                    class="form-control @if($errors->get('note')) is-invalid @endif"
                                                    rows="3"
                                                    name="note"
                                                    placeholder="" >{{ oldDataCustom('note', $data['supplyNotes']) }}</textarea>
                                            </span>
                                                <div class="info_error"></div>
                                                @if($errors->has('note'))
                                                    <span class="text-danger font-weight-bold text-center">{{ $errors->first('note') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-2"></div>
                                    </div>
                                    <div class="form-group text-center mb-0 mt-4">
                                        <button type="reset" class="btn btn-outline-secondary waves-effect waves-light mt-4 mr-1 mx-5 font-size-btn-supply btn-bottom " onclick="window.location='{{ routeByPlaceId('staff.staffDashboard') }}'">
                                            {{ trans('staff_supplies_index.back_to_top') }}
                                        </button>
                                        <button class="btn btn-primary mt-4 mr-1 mx-5 btn-bottom font-size-btn-supply" type="submit">
                                            {{ trans('staff_supplies_index.register') }}
                                        </button>
                                    </div>
                                </form>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
