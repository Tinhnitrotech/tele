<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditAdminRequest extends FormRequest
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
            'name_kana' => 'nullable|max:100',
            'email' => 'required|email|max:100|unique:admins',
            'birthday' => 'nullable|date|before:tomorrow',
            'gender' => 'nullable|numeric'
        ];
        if ($this->id) {
	        $rules['email'] = Rule::unique('admins')->ignore($this->id);
        } else {
	        $rules['email'] = Rule::unique('admins')->whereNull('deleted_at');
        }
        return $rules;
    }


    public function messages()
    {
        return [
            'name_kana.max' => trans('common.name_maxlength_valid'),
            'name.required' => trans('validation_form.validate.name_admin.required'),
            'name.max' => trans('common.name_maxlength_valid'),
            'email.required' => trans('validation_form.validate.email.required'),
            'email.max' => trans('validation_form.validate.email.max'),
            'email.email' => trans('validation_form.validate.email.email'),
            'email.unique' => trans('common.email_unique_valid'),
            'birthday.before' => trans('common.birthday_before_valid'),
            'gender.numeric' => trans('validation_form.validate.gender.digits')
        ];
    }
}
