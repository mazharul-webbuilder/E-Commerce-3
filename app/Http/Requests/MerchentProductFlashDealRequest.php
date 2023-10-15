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
            'startDate' => 'required_if:flashDealStatus,1|nullable|date|after_or_equal:today',
            'endDate' => 'required_if:flashDealStatus,1|nullable|date|after:startDate',
            'amount' => 'required_if:flashDealStatus,1|nullable|numeric',
            'dealType' => 'required_if:flashDealStatus,1|nullable|in:flat,percent',
        ];
    }


}
