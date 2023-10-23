<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopSettingRequest extends FormRequest
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
            'shop_name' => 'required|string',
            'legal_name' => 'required|string',
            'trade_licence' => 'nullable|string|min:3',
            'trade_licence_issued' => 'required_with:trade_licence',
            'trade_licence_expired' => 'required_with:trade_licence',
            'address' => 'nullable|string',
            'help_line' => 'nullable|digits_between:3,13',
            'available_time' => 'nullable|string|min:2',
            'detail' => 'nullable|string',
            'image' => 'nullable|image'

        ];
    }
}
