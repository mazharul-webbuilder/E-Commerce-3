<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchentProductFlashDealRequest extends FormRequest
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
            'product_id' => 'required|integer',
            'flashDealStatus' => 'required|integer',
            'startDate' => 'required|date|after_or_equal:today', // Start date must be today or a future date
            'endDate' => 'required|date|after:start_date', // End date must be greater than the start date
            'amount' => 'required|numeric',
            'dealType' => 'required|in:flat,percent', // Validate that dealType is either 'flat' or 'percent'
        ];
    }
}
