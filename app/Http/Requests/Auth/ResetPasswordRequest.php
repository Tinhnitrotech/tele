<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|max:200',
            'password_confirm' => 'required|max:200|same:password',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => trans('login.pass_new'),
            'password_confirm' => trans('login.pass_new_confirm'),
        ];
    }
}
