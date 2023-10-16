<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
            'dealType' => [
                'required_if:flashDealStatus,1',
                'nullable',
                Rule::in(['flat', 'percent']),
            ],
            'amount' => [
                'required_if:flashDealStatus,1',
                'nullable',
                'min:1',
                'numeric',
                Rule::when(function ($attributes) {
                    return $attributes['dealType'] === 'percent';
                }, ['between:1,100']),
            ],
        ];
    }


}
