<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        return [
            'family_code' => 'required',
            'password' => 'required'
        ];
    }
     public function messages()
     {
         return [
             'family_code.required' => trans('user_register.validate.member.family_code.required'),
             'password.required' => trans('user_register.validate.member.family_password.required')
         ];
     }
}
