<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'email|required|max:100',
            'password' => 'required|max:200'
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => trans('common.email_address'),
            'password' => trans('common.password'),
        ];
    }
}
