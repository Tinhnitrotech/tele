<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users',
            'postal_code_1' => 'nullable|numeric|digits:3',
            'postal_code_2' => 'nullable|numeric|digits:4',
            'prefecture_id' => 'nullable|numeric|min:1|max:47',
            'tel' => 'required|numeric|regex:/(0)[0-9]/|digits_between:10,11',
            'birthday' => 'nullable|date|before:tomorrow',
            'address' => 'nullable'
        ];
        if ($this->id) {
	        $rules['email'] = Rule::unique('users')->ignore($this->id);
        } else {
	        $rules['email'] = Rule::unique('users')->whereNull('deleted_at');
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => trans('staff_management.name'),
            'email' => trans('staff_management.email'),
            'tel' => trans('staff_management.tel'),
            'birthday' => trans('staff_management.birthday'),
            'address' => trans('staff_management.address'),
        ];
    }

    public function messages()
    {
        return [
            'postal_code_1.numeric' => trans('validation_form.validate.postal_code_1.numeric'),
            'postal_code_1.digits' => trans('validation_form.validate.postal_code_1.digits'),
            'postal_code_2.numeric' => trans('validation_form.validate.postal_code_2.numeric'),
            'postal_code_2.digits' => trans('validation_form.validate.postal_code_2.digits'),
            'prefecture_id.numeric' => trans('validation_form.validate.prefecture_id.numeric'),
            'prefecture_id.min' => trans('validation_form.validate.prefecture_id.min'),
            'prefecture_id.max' => trans('validation_form.validate.prefecture_id.max'),
            'tel.numeric' => trans('common.valid_number'),
            'tel.regex' => trans('common.first_zero'),
            'tel.required' => trans('validation_form.validate.tel.required'),
            'tel.digits_between' => trans('validation_form.validate.tel.digits_between'),
            'email.required' => trans('validation_form.validate.email.required'),
            'email.email' => trans('validation_form.validate.email.email'),
            'name.required' => trans('validation_form.validate.name_staff.required'),
            'name.max' => trans('validation_form.validate.name_staff.max'),
            'email.max' => trans('validation_form.validate.email.max'),
            'email.unique' => trans('common.email_unique_valid'),
            'birthday.before' => trans('common.birthday_before_valid')
        ];
    }
}
