<?php

namespace App\Http\Requests\Staff;

use App\Repositories\Staff\Family\FamilyRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddFamilyRequest extends FormRequest
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
            'join_date' => 'required|date_format:"Y/m/d"',
            'address' => 'required',
            'postal_code_1' => 'required|numeric|digits:3',
            'postal_code_2' => 'required|numeric|digits:4',
            'prefecture_id' => 'required|numeric|min:1|max:47',
            'tel' => 'required|numeric|regex:/(0)[0-9]/|digits_between:10,11',
            'is_public' => 'required',
            'is_owner' => 'required',
        ];
        for($i=1; $i <= count($this->person); $i++) {
            $rules['person.'.$i.'.name'] = 'required_if:is_owner,==,'.$i;
            $rules['person.'.$i.'.age'] = 'integer|min:1|max:120|required_if:is_owner,==,'. $i;
            $rules['person.'.$i.'.gender'] = 'required_if:is_owner,==,'.$i;
            $rules['person.'.$i.'.note'] = 'max:200';
        }

        if (empty($this->get('id'))) {
            $rules['password'] = 'required|min:4|max:8';
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
       $message =  [
            'join_date.required' => trans('common.valid_required'),
            'join_date.date_format' => trans('common.evacuation_day_date'),
            'address.required' => trans('validation_form.validate.address.required'),
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
            'tel.numeric' => trans('common.valid_number'),
            'tel.regex' => trans('common.first_zero'),
            'tel.required' => trans('validation_form.validate.tel.required'),
            'tel.digits_between' => trans('validation_form.validate.tel.digits_between'),
            'password.required' => trans('common.valid_required'),
            'password.min' => trans('user_register.validate.register.password.min'),
            'password.max' => trans('user_register.validate.register.password.max'),
            'password.numeric' => trans('user_register.validate.register.password.digit'),
            'is_public.required' => trans('common.valid_required'),
            'is_owner.required' => trans('common.valid_required'),
       ];
        for($i=1; $i <= count($this->person); $i++) {
            $message['person.'.$i.'.name.required_if'] = trans('common.valid_required');
            $message['person.'.$i.'.age.required_if'] = trans('common.valid_required');
            $message['person.'.$i.'.age.integer'] = trans('common.valid_positive_number_age');
            $message['person.'.$i.'.age.min'] = trans('common.minlength_age');
            $message['person.'.$i.'.age.max'] = trans('common.maxlength_age');
            $message['person.'.$i.'.gender.required_if'] = trans('common.valid_required');
            $message['person.'.$i.'.note.max'] = trans('user_register.validate.register.note.max');
        }
        return $message;
    }

}
