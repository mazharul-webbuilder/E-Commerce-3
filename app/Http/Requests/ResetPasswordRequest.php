<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
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
            'verification_code' => ['required', 'exists:verification_codes,verify_code'],
            'userType' => ['required', 'string', Rule::in(['admin', 'merchant', 'seller', 'affiliator', 'shareOwner', 'clubOwner'])],
            'password' => ['required', 'min:3', 'confirmed'],
        ];
    }
}
