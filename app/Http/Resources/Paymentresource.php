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
            'name'=>$this->payment_method_name,
            'payments'=>$this->payments->map(function ($data){
                return[
                    'id'=>$data->id,
                    'name'=>$data->payment_name,
                    'type'=>$data->type,
                    'image'=>asset('uploads/payment/resize/'.$data->image),
                    'account_detail'=>json_decode($data->account_detail),
                    'status'=>$data->status,
                ];
            }),



        ];
    }
}

