<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Paymentresource extends JsonResource
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
            'name'=>$this->payment_name,
            'type'=>$this->type,
            'image'=>asset('uploads/payment/resize/'.$this->image),
            'account_detail'=>json_decode($this->account_detail),

        ];
    }
}
