<form action="{{ $routeAction ?? '' }}" method="POST" id="add-family-form" class="custom-col">
    @csrf
    @if (!empty($data['person']))
        <input type="hidden" id="remove_person_ids" name="remove_person_ids" value="">
    @endif

    @if (!empty($data['id']))
        <input type="hidden" name="id" value="{{ $data['id'] }}">
    @endif

    <div class="form-group row">
        <label for="date_picker" class="col-lg-2 col-md-3 col-sm-4 col-form-label font-weight-bold common_font_site">{{ trans('common.evacuation_day') }} <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <input type="text"
                            name="join_date"
                            id="date_picker"
                            class="form-control common_font_site @if ($errors->get('join_date')) is-invalid @endif"
                            placeholder="yyyy/mm/dd"
                            value="{{ oldDataCustom('join_date', $data) }}"
                            data-provide="datepicker"
                            data-date-autoclose="true"
                            required >
                    @if($errors->has('join_date'))
                        <span class="text-danger font-weight-bold text-center">{{ $errors->first('join_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label font-weight-bold common_font_site">{{ trans('staff_add_family.street_address') }} <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-12 col-lable-input">
                    <label class="col-form-label common_font_site">〒</label>
                    <input type="text"
                            class="form-control common_font_site check_postcode @if ($errors->get('postal_code_1')) is-invalid @endif"
                            value="{{ oldDataCustom('postal_code_1', $data) }}"
                            name="postal_code_1"
                            maxlength="3"
                            oninput="postalCode(this.id)"
                            id="postal_code_1"
                            required >
                    @if($errors->has('postal_code_1'))
                        <span class="text-danger font-weight-bold text-center">{{ $errors->first('postal_code_1') }}</span>
                    @endif
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-ct p-0 text-center">
                    <label class="col-form-label font-weight-bold">-</label>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                    <input type="text"
                            class="form-control common_font_site check_postcode @if ($errors->get('postal_code_2')) is-invalid @endif"
                            value="{{ oldDataCustom('postal_code_2', $data) }}"
                            name="postal_code_2"
                            maxlength="4"
                            oninput="postalCode(this.id)"
                            id="postal_code_2"
                            required >
                    @if($errors->has('postal_code_2'))
                        <span class="text-danger font-weight-bold text-center">{{ $errors->first('postal_code_2') }}</span>
                    @endif
                </div>
                <div class="col">
                    <p class="col-form-label common_font_site common_tablet_font">{{ trans('staff_add_family.auto_zip_and_address') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label font-weight-bold common_font_site"></label>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                    <select name="prefecture_id" class="form-control common_font_site" required>
                        <option value="">{{ trans('user_register.please_select') }}</option>
                        @foreach( get_prefecture_person_register() as $value => $type)
                            <option value="{{ $value }}" @if ($value == oldDataCustom('prefecture_id', $data)) selected @endif >{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-7 col-6">
                    <input type="text"
                            class="form-control common_font_site @if ($errors->get('address')) is-invalid @endif"
                            value="{{ oldDataCustom('address', $data) }}"
                            name="address" id="address"
                            required >
                    <input type="text" class="form-control common_font_site" value="" name="address_default" id="address_default" hidden>
                    <input type="text" class="form-control common_font_site" value="2" name="scan_image" id="scan_image" hidden>

                    @if($errors->has('address'))
                        <span class="text-danger font-weight-bold text-center">{{ $errors->first('address') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="tel" class="col-lg-2 col-md-3 col-sm-4 col-form-label font-weight-bold common_font_site">{{ trans('staff_add_family.phone_rep') }} <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div class="row">
                <div class="col-lg-7 col-md-9 col-sm-10">
                    <input type="text"
                            id="tel"
                            class="form-control common_font_site @if ($errors->get('tel')) is-invalid @endif"
                            name="tel"
                            value="{{ oldDataCustom('tel', $data) }}"
                            required >
                    @if($errors->has('tel'))
                        <span class="text-danger font-weight-bold text-center">{{ $errors->first('tel') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-lg-2 col-md-3 col-sm-4 col-form-label font-weight-bold common_font_site">{{ trans('common.password') }} @if (empty($data['id'])) <span class="text-danger">*</span> @endif
            <p class="font-weight-normal common_font_site common_tablet_font pt-0 mb-0">{{ trans('staff_add_family.4_digit_number') }}</p>
        </label>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div class="row">
                <div class="col-lg-7 col-md-9 col-sm-10">
                    <input id="password" class="form-control common_font_site @if ($errors->get('password')) is-invalid @endif" name="password" type="number" min="0" value="{{ oldDataCustom('password', $data) }}" >
                    @if($errors->has('password'))
                        <span class="text-danger font-weight-bold text-center">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="col">
                    <p class="col-form-label common_font_site common_tablet_font">{{ trans('staff_add_family.required_when_leaving') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row mb-0">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label font-weight-bold common_font_site">{{ trans('staff_add_family.household_list') }} <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-md-9">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 text-center tb-radio-ct size-14">
                    <thead class="table-head">
                        <tr class="row-header">
                            <th class="m-w-100 common_font_site">{{ trans('common.representative') }}</th>
                            <th class="m-w-290 common_font_site">{{ trans('staff_add_family.name_phonetic') }}</th>
                            <th class="m-w-100 common_font_site">{{ trans('staff_add_family.age') }}</th>
                            <th class="m-w-100 common_font_site">{{ trans('staff_add_family.sex') }}</th>
                            <th class="m-w-290 common_font_site">{{ trans('staff_add_family.person_number') }}</th>
                            <th class="m-w-200 common_font_site">{{ trans('staff_add_family.remarks') }}</th>
                        </tr>
                    </thead>
                    <tbody id="family_content">
                        @if (!empty($data['person']) && (strlen(strstr(url()->current(), 'staff/edit-family')) > 0))
                            @foreach ($data['person'] as $key => $person)
                                @include('staff.refuge.person_item', ['person' => $person, 'number' => ($key+1)])
                            @endforeach
                        @elseif (!empty($data['person']))
                            @foreach ($data['person'] as $key => $person)
                                @include('staff.refuge.person_item', ['person' => $person, 'number' => ($key)])
                            @endforeach
                        @else
                            @include('staff.refuge.person_item')
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="add_family" class="col-lg-2 col-md-3"></label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <p class="col-form-label common_font_site common_tablet_font">{{ trans('staff_add_family.representative_maybe_not_head') }}</p>
            <button type="button" class="btn btn-success waves-effect waves-light" id="add_family"><i class="fas fa-plus"></i></button>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-4"></div>
        <div class="col-6 text-left">
            <div class="checkbox checkbox-primary hidden-label-error">
                <input type="checkbox" name="is_public" class="custom-control-input @if ($errors->get('is_public')) is-invalid @endif" id="customCheckAgree"
                    @if (!empty($data['is_public']) && ($data['is_public'] == 1 || $data['is_public'] == 'on')) checked @endif >
                <label class="custom-control-label common_font_site" for="customCheckAgree">{{ trans('staff_add_family.agree') }} <span class="text-danger">*</span></label>
            </div>
            @if($errors->has('is_public'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('is_public') }}</span>
            @endif
        </div>
        <div class="col-2"></div>
    </div>

    <div class="form-group row">
        <div class="col-4"></div>
        <div class="col-6 text-left">
            <div class="checkbox checkbox-primary hidden-label-error">
                <input type="checkbox" name="public_info" class="custom-control-input @if ($errors->get('public_info')) is-invalid @endif" value="1" id="customCheckAgreePublicInfo"
                @if (!empty($data['public_info']) && ($data['public_info'] == 1)) checked @endif >
                <label class="custom-control-label common_font_site" for="customCheckAgreePublicInfo">{{ trans('staff_add_family.public_info') }} </label>
            </div>
            <p class="ml-2 mt-3 size-18" for="customCheckAgreePublicInfo">{{ getDisclosureInfo() }} </p>
            @if($errors->has('public_info'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('public_info') }}</span>
            @endif
        </div>
        <div class="col-2"></div>
    </div>

    <div class="form-group row">
        <div class="col-12 text-right">
            <button type="submit" class="btn btn-lg btn-primary my-2 mx-4 m-w-8 submit_btn">
                {{ trans('staff_add_family.btn_go') }}
            </button>
        </div>
    </div>

</form>
<div id="mes_remove_person" class="d-none">{{ trans('common.mes_remove_person') }}</div>
<div id="person_max" data-max="{{ config('constant.person_max') }}" class="d-none">{{ trans('common.person_max') }}</div>
