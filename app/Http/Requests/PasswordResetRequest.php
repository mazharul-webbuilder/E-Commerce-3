<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasswordResetRequest extends FormRequest
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
            'userType' => ['required', 'string', Rule::in(['admin', 'merchant', 'seller', 'affiliator', 'shareOwner', 'clubOwner'])],
            'email' => [
                'required',
                'email',
                Rule::when(function ($attributes){
                    return $attributes['userType'] === 'admin';
                }, ['exists:admins,email']),
                Rule::when(function ($attributes){
                    return $attributes['userType'] === 'merchant';
                }, ['exists:merchants,email']),
                Rule::when(function ($attributes){
                    return $attributes['userType'] === 'seller';
                }, ['exists:sellers,email']),
                Rule::when(function ($attributes){
                    return $attributes['userType'] === 'affiliator';
                }, ['exists:affiliators,email']),
            ]
        ];
    }
}
