<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Ecommerce\Product;

class CartResource extends JsonResource
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
            'quantity'=>$this->quantity,
            'product_title'=>$this->product->title,
            'thumbnail'=>$this->product->thumbnail,
            'unit_price'=>$this->seller_id==null ? $this->product->price() : seller_price($this->seller_id,$this->product_id)->seller_price,
            'size'=>$this->size ? $this->size->name  : null,
        ];
    }
}
