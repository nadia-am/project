<?php

namespace Modules\Discount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createDiscountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'=> 'required|min:2|unique:discounts,code',
            'percent'=> 'required',
            'user'=> 'nullable',
            'expired_d'=> 'nullable',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
