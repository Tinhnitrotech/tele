<script type="text/x-custom-template" id="button_add_family_template">
    <tr>
        <td>
            <div class="position-relative">
                <input type="radio"
                        id="owner___number__"
                        class="radio_custom owner_radio @if ($errors->get('is_owner')) is-invalid @endif"
                        name="is_owner"
                        value="__number__"
                        required >
                <label for="owner___number__"></label>
            </div>
            @if($errors->has('is_owner'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('is_owner') }}</span>
            @endif
            <input type="hidden"
                   class="form-control person-id @if ($errors->get('person.__number__.id')) is-invalid @endif"
                   name="person[__number__][id]"
                   value="__number__">
        </td>
        <td>
            <input type="text"
                    class="form-control common_font_site person-name @if ($errors->get('person.__number__.name')) is-invalid @endif"
                    name="person[__number__][name]"
                    value="{{ old('person[__number__][name]') }}"
                    required >
            @if($errors->has('person.__number__.name'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('person.__number__.name') }}</span>
            @endif
        </td>
        <td>
            <select class="custom-select common_font_site person-age @if ($errors->get('person.__number__.age')) is-invalid @endif" name="person[__number__][age]" >
                @for ($i = 1; $i <= 120; $i++)
                <option
                    @if (!empty(old('person[__number__][age]')) && old('person[__number__][age]') == $i)
                        selected
                    @elseif ($i == 30)
                        selected
                    @endif
                    value="{{ $i }}" >{{ $i }}</option>
                @endfor
            </select>
            @if($errors->has('person.__number__.age'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('person.__number__.age') }}</span>
            @endif
        </td>
        <td class="btn-age">
            <select class="custom-select common_font_site person-gender" name="person[__number__][gender]">
                <option
                    selected
                    @if (old('person[__number__][gender]') == "1") selected @endif
                    value="1" >{{ trans('common.male') }}</option>
                <option
                    @if (old('person[__number__][gender]') == "2") selected @endif
                    value="2">{{ trans('common.female') }}</option>
            </select>
            @if($errors->has('person.__number__.gender'))
                <span class="text-danger font-weight-bold text-center">{{ $errors->first('person.__number__.gender') }}</span>
            @endif
        </td>
        <td>
            <select class="custom-select common_font_site person-option" name="person[__number__][option]">
                <option value="">{{ trans('user_register.please_select') }}</option>
                @foreach (trans('common.person_requiring_option') as $type => $name)
                    <option @if (old('person[__number__][option]') == $type) selected @endif value="{{ $type }}">{{ $name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input class="form-control common_font_site person-note" type="text" name="person[__number__][note]" value="{{ old('person[__number__][note]') }}" >
        </td>
    </tr>
</script>
