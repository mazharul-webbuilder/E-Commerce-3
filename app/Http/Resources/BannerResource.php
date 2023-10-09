<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'title_1'=>$this->title_1,
            'title_2'=>$this->title_2,
            'button_title'=>$this->button_title,
            'button_link'=>$this->button_link,
            'image'=>asset('/uploads/banner/resize/'.$this->image),
        ];
    }
}
