<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'product_code'=>$this->product_code,
            'previous_price'=>$this->previous_price,
            'current_price'=>$this->current_price,
            'previous_coin'=>$this->previous_coin,
            'current_coin'=>$this->current_coin,
            'thumbnail'=>$this->thumbnail,
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'galleries'=>$this->galleries->map(function ($data){
                return [
                    "id"  => $data->id,
                    'image'=>$data->image
                ];
            }),
            'sizes'=>$this->stocks->map(function ($data){
                return [
                    "id"  => $data->size_id,
                    "size_name"  => $data->size->name,
                ];
            }),
        ];
    }
}
