<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title'=>'required|max:255|min:3',
            'description'=>'required|min:5',
            'price'=>'required|numeric',
            'inventory'=>'numeric',
            'image'=>'nullable|max:2024',
            'attributes'=>'array'
        ];
    }
}
