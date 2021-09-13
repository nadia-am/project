<?php

namespace App\Http\Requests\profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManageTwoFactorPostRequest extends FormRequest
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
            'type'=>'required|in:sms,off',
            'phone'=>['required_unless:type,off' , Rule::unique('users','phone_number')->ignore($this->user()->id)]
        ];
    }
}
