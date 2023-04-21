<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class SuppliesRequest extends FormRequest
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
            'place_id' => 'required',
            'supply.*.m_supply_id' => 'required|numeric|min:0',
            'supply.*.number' => 'required|numeric|min:0',
            'comment' => 'max:200',
            'note' => 'max:200',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
       return [
            'place_id.required' => trans('common.valid_required'),
            'supply.*.m_supply_id.required' => trans('common.valid_required'),
            'supply.*.m_supply_id.numeric' => trans('common.valid_number'),
            'supply.*.m_supply_id.min' => trans('common.min_0_mes'),
            'supply.*.number.required' => trans('common.valid_required'),
            'supply.*.number.numeric' => trans('common.valid_number'),
            'supply.*.number.min' => trans('common.min_0_mes'),
            'comment.max' => trans('common.maxlength_valid_200'),
            'note.max' => trans('common.maxlength_valid_200'),
       ];
    }
}
