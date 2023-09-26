<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaveWithdrawPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'withdraw_payment_id'=>$this->withdraw_payment_id,
            'account_number'=>$this->account_number,
            'is_verify'=>$this->is_verify,
            'withdraw_payment'=>[
                 'name'=>$this->withdraw_payment->name ?? '',
                 'image'=>$this->withdraw_payment->image ?? '',
            ]
        ];
    }
}
