<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Myorderhistory extends JsonResource
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
            'order_id'=>$this->id,
            'order_number'=>$this->order_number,
            'grand_total'=>default_currency()->currency_code." ".$this->grand_total,
            'grand_total_in_bdt'=>currency_code('BDT')->currency_code." ".currency_convertor($this->grand_total,'convert_to_bdt'),
            'grand_total_in_inr'=>currency_code('INR')->currency_code." ".currency_convertor($this->grand_total,'convert_to_inr'),
            'quantity'=>$this->quantity,
            'date'=>$this->created_at->format('d-m-Y, g:i A'),
            'status'=>$this->status,
        ];


    }
}
