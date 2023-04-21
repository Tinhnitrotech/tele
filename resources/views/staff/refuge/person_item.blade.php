@php
    if (!isset($number)) {
        $number = 1;
    }
@endphp
<tr>
    <td class="w-75-px">
        @if($errors->has('is_owner'))
            <span class="text-danger font-weight-bold text-center">{{ $errors->first('is_owner') }}</span>
        @endif
        <div class="position-relative">
            <input type="radio"
                    id="owner_{{ $number }}"
                    class="radio_custom owner_radio @if ($errors->get('is_owner')) is-invalid @endif"
                    name="is_owner"
                    value="{{ $number }}"
                   @if ((!empty($person) && isset($person['is_owner']) && ($person['is_owner'] == 0))  ||(empty($person) && !isset($data['is_owner'])))
                   checked
                   @endif
                   @if(isset($data['is_owner']) && ($data['is_owner']) == $number)
                   checked
                   @endif
                    required >
            <label for="owner_{{ $number }}"></label>
            <input type="hidden"
                   class="form-control person-id @if ($errors->get('person.'.$number.'.id')) is-invalid @endif"
                   name="person[{{ $number }}][id]"
                   value="{{ old('person['. $number .'][id]', $person['id'] ?? $number)  }}">
        </div>
    </td>
    <td>
        <input type="text"
                class="form-control common_font_site person-name @if ($errors->get('person.'.$number.'.name')) is-invalid @endif"
                name="person[{{ $number }}][name]"
                value="{{ !empty($person['name']) ? $person['name'] : old('person['. $number .'][name]') }}"
                required >
        @if($errors->has('person.'.$number.'.name'))
            <span class="text-danger font-weight-bold text-center">{{ $errors->first('person.'.$number.'.name') }}</span>
        @endif
    </td>
    <td>
        <select class="custom-select common_font_site person-age @if ($errors->get('person.'.$number.'.age')) is-invalid @endif" name="person[{{ $number }}][age]">
            @for ($i = 1; $i <= 120; $i++)
            <option
                @if (!empty($person['age']) && $person['age'] == $i)
                    selected
                @elseif (!empty(old('person['. $number .'][age]')) && old('person['. $number .'][age]') == $i)
                    selected
                @endif

                @if (empty($person['age']) && empty(old('person['. $number .'][age]')) && $i == 30)
                    selected
                @endif
                value="{{ $i }}" >{{ $i }}</option>
            @endfor
        </select>
        @if($errors->has('person.'.$number.'.age'))
            <span class="text-danger font-weight-bold text-center">{{ $errors->first('person.'.$number.'.age') }}</span>
        @endif
    </td>
    <td class="btn-age">
        <select class="custom-select common_font_site person-gender @if ($errors->get('person.'.$number.'gender')) is-invalid @endif" name="person[{{ $number }}][gender]">
            <option
                selected
                @if (!empty($person['gender']))
                    @if ($person['gender'] == 1) selected @endif
                @else
                    @if (old('person['. $number .'][gender]') == "1") selected @endif
                @endif
                value="1" >{{ trans('common.male') }}</option>
            <option
                @if (!empty($person['gender']))
                    @if ($person['gender'] == 2) selected @endif
                @else
                    @if (old('person['. $number .'][gender]') == "2") selected @endif
                @endif
                value="2">{{ trans('common.female') }}</option>
        </select>
        @if($errors->has('person.'.$number.'.gender'))
            <span class="text-danger font-weight-bold text-center">{{ $errors->first('person.'.$number.'.gender') }}</span>
        @endif
    </td>
    <td>
        <select class="custom-select common_font_site person-option" name="person[{{ $number }}][option]">
            <option value="">{{ trans('user_register.please_select') }}</option>
            @foreach (trans('common.person_requiring_option') as $type => $name)
                <option
                    @if (!empty($person['option']))
                        @if ($person['option'] == $type) selected @endif
                    @else
                        @if (old('person['. $number .'][option]') == $type) selected @endif
                    @endif
                    value="{{ $type }}">{{ $name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input class="form-control common_font_site person-note" name="person[{{ $number }}][note]" type="text" value="{{ !empty($person['note']) ? $person['note'] : old('person['. $number .'][note]') }}" >
    </td>
</tr>
