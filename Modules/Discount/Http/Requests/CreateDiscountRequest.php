<?php

namespace Modules\Discount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountRequest extends FormRequest
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
            'percent'=> 'required|between:1,99',
            'users'=> 'nullable|array|exists:users,id',
            'products'=> 'nullable|array|exists:products,id',
            'categories'=> 'nullable|array|exists:categories,id',
            'expired_at'=> 'required',
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
