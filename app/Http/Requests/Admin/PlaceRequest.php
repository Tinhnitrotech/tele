<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class PlaceRequest extends FormRequest
{
    /**
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
            'name' => 'required|max:200',
            'tel' => 'required|regex:/^[0-9]+$/|digits_between:10,11',
            'postal_code_1' => 'required|numeric|digits:3',
            'postal_code_2' => 'required|numeric|digits:4',
            'prefecture_id' => 'required|numeric|min:1|max:47',
            'address' => 'required',
            'postal_code_default_1' => 'required|numeric|digits:3',
            'postal_code_default_2' => 'required|numeric|digits:4',
            'prefecture_id_default' => 'required|numeric|min:1|max:47',
            'address_default' => 'required',
            'total_place' => 'required|numeric',
            'altitude' => 'numeric|nullable',
            'latitude' => ['required', 'max:30','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required','max:30','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('validation_form.validate.name_place.required'),
            'name.max' => trans('validation_form.validate.name_place.required'),
            'tel.required' => trans('validation_form.validate.tel.required'),
            'tel.regex' => trans('validation_form.validate.tel.regex'),
            'tel.digits_between' => trans('validation_form.validate.tel.digits_between'),
            'postal_code_1.required' => trans('validation_form.validate.postal_code_1.required'),
            'postal_code_1.numeric' => trans('validation_form.validate.postal_code_1.numeric'),
            'postal_code_1.digits' => trans('validation_form.validate.postal_code_1.digits'),
            'postal_code_2.required' => trans('validation_form.validate.postal_code_2.required'),
            'postal_code_2.numeric' => trans('validation_form.validate.postal_code_2.numeric'),
            'postal_code_2.digits' => trans('validation_form.validate.postal_code_2.digits'),
            'prefecture_id.required' => trans('validation_form.validate.prefecture_id.required'),
            'prefecture_id.numeric' => trans('validation_form.validate.prefecture_id.numeric'),
            'prefecture_id.min' => trans('validation_form.validate.prefecture_id.min'),
            'prefecture_id.max' => trans('validation_form.validate.prefecture_id.max'),
            'address.required' => trans('validation_form.validate.address.required'),
            'postal_code_default_1.required' => trans('validation_form.validate.postal_code_default_1.required'),
            'postal_code_default_1.numeric' => trans('validation_form.validate.postal_code_default_1.numeric'),
            'postal_code_default_1.digits' => trans('validation_form.validate.postal_code_default_1.digits'),
            'postal_code_default_2.required' => trans('validation_form.validate.postal_code_default_2.required'),
            'postal_code_default_2.numeric' => trans('validation_form.validate.postal_code_default_2.numeric'),
            'postal_code_default_2.digits' => trans('validation_form.validate.postal_code_default_2.digits'),
            'prefecture_id_default.required' => trans('validation_form.validate.prefecture_id_default.required'),
            'prefecture_id_default.numeric' => trans('validation_form.validate.prefecture_id_default.numeric'),
            'prefecture_id_default.min' => trans('validation_form.validate.prefecture_id_default.min'),
            'prefecture_id_default.max' => trans('validation_form.validate.prefecture_id_default.max'),
            'address_default.required' => trans('validation_form.validate.address_default.required'),
            'total_place.required' => trans('validation_form.validate.total_place.required'),
            'total_place.numeric' => trans('validation_form.validate.total_place.numeric'),
            'altitude.numeric' => trans('validation_form.validate.altitude.numeric'),
            'latitude.required' => trans('validation_form.validate.latitude.required'),
            'latitude.regex' => trans('validation_form.validate.latitude.regex'),
            'latitude.max' => trans('common.maxlength_valid_30'),
            'longitude.required' => trans('validation_form.validate.longitude.required'),
            'longitude.max' => trans('common.maxlength_valid_30'),
            'longitude.regex' => trans('validation_form.validate.longitude.regex'),
        ];
    }

}
