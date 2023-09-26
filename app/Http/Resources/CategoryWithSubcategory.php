<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithSubcategory extends JsonResource
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
            'name'=>$this->name,
            'image'=>asset($this->image != null ? $this->image: 'webend/placeholder.jpg'),
            'slug'=>$this->slug,
            'priority'=>$this->priority,
            'digital_asset'=>$this->digital_asset == 1? "Yes":"No",
            'sub_categorys'=>$this->subCategories->map(function ($data){
                return [
                    "id"  => $data->id,
                    "category_id"  => $data->category_id,
                    'name' => $data->name,
                    'slug' => $data->slug,
                    'priority' => $data->priority,
                ];
            }),
        ];
    }
}
