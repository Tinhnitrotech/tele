<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SettingRequest extends FormRequest
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
            'map_scale' => 'required|numeric|min:1|max:25',
            'footer' => 'required|max:200',
            'type_name_ja' => 'required|max:200',
            'type_name_en' => 'required|max:200',
            'system_name_ja' => 'required|max:200',
            'system_name_en' => 'required|max:200',
            'disclosure_info_ja' => 'required|max:255',
            'disclosure_info_en' => 'required|max:255',
            'latitude' => ['required', 'max:30','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required','max:30','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'image_logo' => 'mimes:jpeg,png,jpg|max:3072',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'map_scale.required' => trans('setting_system.validate.map_scale.required'),
            'map_scale.numeric' => trans('setting_system.validate.map_scale.digits'),
            'map_scale.min' => trans('setting_system.validate.map_scale.minlength'),
            'footer.required' => trans('setting_system.validate.map_scale.required'),
            'type_name_ja.required' => trans('setting_system.validate.map_scale.required'),
            'type_name_en.required' => trans('setting_system.validate.map_scale.required'),
            'system_name_ja.required' => trans('setting_system.validate.map_scale.required'),
            'system_name_en.required' => trans('setting_system.validate.map_scale.required'),
            'disclosure_info_ja.required' => trans('setting_system.validate.map_scale.required'),
            'disclosure_info_en.required' => trans('setting_system.validate.map_scale.required'),
            'footer.max' => trans('common.maxlength_valid_200'),
            'type_name_ja.max' => trans('common.maxlength_valid_200'),
            'type_name_en.max' => trans('common.maxlength_valid_200'),
            'system_name_ja.max' => trans('common.maxlength_valid_200'),
            'system_name_en.max' => trans('common.maxlength_valid_200'),
            'disclosure_info_ja.max' => trans('common.maxlength_valid_255'),
            'disclosure_info_en.max' => trans('common.maxlength_valid_255'),
            'latitude.required' => trans('validation_form.validate.latitude.required'),
            'latitude.max' => trans('common.maxlength_valid_30'),
            'longitude.required' => trans('validation_form.validate.longitude.required'),
            'longitude.max' => trans('common.maxlength_valid_30'),
            'latitude.regex' => trans('validation_form.validate.latitude.regex'),
            'longitude.regex' => trans('validation_form.validate.longitude.regex'),
            'image_logo.mimes' => trans('setting_system.validate.image_logo.mines'),
            'image_logo.max' => trans('setting_system.validate.image_logo.max'),
        ];
    }

}
