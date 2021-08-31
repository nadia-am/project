<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class createRoleRequest extends FormRequest
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
            'name'=>'required|unique:permissions|max:255',
            'label'=>'required|max:255',
            'permissions'=>'required|array'
        ];
    }
}
