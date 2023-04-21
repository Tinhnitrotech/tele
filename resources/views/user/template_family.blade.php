<script type="text/x-custom-template" id="input_template_family">
    <tr>
        <th scope="row">
            <p>
                <input type="radio" id="owner___number__"  name="is_owner">
                <label for="owner___number__"></label>
            </p>
        </th>
        <td>
            <input class="form-control" name="name" type="text">
        </td>
        <td>
            <input class="form-control" name="age" type="text">
        </td>
        <td>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender___number__" checked>
                <label class="form-check-label" >
                    {{ trans('user_register.gender_men') }}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender___number__">
                <label class="form-check-label">
                    {{ trans('user_register.gender_woman') }}
                </label>
            </div>
        </td>
        <td>
            <select class="custom-select mb-3" id="select_option_support">
                <option value="">{{ trans('user_register.please_select') }}</option>
                @foreach (trans('common.person_requiring_option') as $value => $type)
                    <option @if (old('person_requiring_option') == $value) selected @endif value="{{ $value }}">{{ $type }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input class="form-control" name="note" type="text">
        </td>
    </tr>
</script>
