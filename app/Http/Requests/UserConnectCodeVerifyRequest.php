<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserConnectCodeVerifyRequest extends FormRequest
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
            'verifyCode' => 'required|exists:verification_codes,verify_code',
            'playerId' => 'required|exists:users,playerid'
        ];
    }
}
