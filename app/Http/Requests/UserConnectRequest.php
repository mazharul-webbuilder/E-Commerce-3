<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserConnectRequest extends FormRequest
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
            'playerId' => 'required|exists:users,playerid'
        ];
    }

    public function messages()
    {
        return [
            'playerId.exists' => 'Player id not found'
        ];
    }
}
