<?php

namespace App\Http\Requests\MasterMaterial;

use Illuminate\Foundation\Http\FormRequest;

class AddMasterMaterialRequest extends FormRequest
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
            'name' => 'required|max:100',
            'unit' => 'max:100'
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('material.supply_name'),
            'unit' => trans('material.unit'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('material.validate.name.required'),
            'name.max' => trans('material.validate.name.max'),
            'unit.max' => trans('material.validate.unit.max'),
        ];
    }
}
