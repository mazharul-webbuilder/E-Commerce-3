<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'title'=>$this->title,
            'previous_price'=>$this->previous_price,
            'current_price'=>$this->current_price,
            'previous_coin'=>$this->previous_coin,
            'current_coin'=>$this->current_coin,
            'thumbnail'=>$this->thumbnail,
        ];
    }
}
