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
        $guards = ['merchant', 'seller', 'affiliate'];
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }
        return null;
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
