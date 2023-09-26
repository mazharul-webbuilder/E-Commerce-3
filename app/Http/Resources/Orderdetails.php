<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Orderdetails extends JsonResource
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
          //  'order'=>$this->order,
            'total_quantity'=>$this->product_quantity,
            'date'=>$this->created_at->format('d-m-Y, g:i A'),
            'status'=>$this->status,
            'product'=>[
                'id'=>$this->product->id,
                'title'=>$this->product->title,
                'product_code'=>$this->product->product_code,
                'previous_price'=>price_format($this->product->previous_price),
                'current_price'=>price_format($this->product->current_price),
                'previous_coin'=>$this->product->previous_coin,
                'current_coin'=>$this->product->current_coin,
                'price' =>price_format($this->product->price()),
                'thumbnail'=>asset('uploads/product/resize/'.$this->product->thumbnail),
            ],
            'size'=>[
                'id'=> $this->size != null ?  $this->size->id : '',
                'name'=> $this->size != null ?  $this->size->name: '',
            ],
            'quantity'=>$this->product_quantity,
            'review_status'=>$this->review_status
        ];
    }
}
