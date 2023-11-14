<?php

namespace App\Http\Requests;

use App\Rules\UserConnectRule;
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
     * Get Request User
    */
    private function getRequestUserType(): ?string
    {
        if (auth()->guard('merchant')->check()){
            return 'merchant';
        } elseif (auth()->guard('seller')->check()){
            return 'seller';
        } elseif (auth()->guard('affiliate')->check()){
            return 'affiliate';
        } else {
            return null;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'playerId' => ['required', 'exists:users,playerid', new UserConnectRule($this->getRequestUserType())]
        ];
    }

    public function messages()
    {
        return [
            'playerId.exists' => 'Player id not found'
        ];
    }
}
