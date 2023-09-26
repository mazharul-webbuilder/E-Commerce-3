<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Greentoken extends JsonResource
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
            "id" => $this->id,
            "user_id" => $this->user_id,
            "token_number" => $this->token_number,
            "getting_source" => $this->getting_source,
            "type" => $this->type,
            "status" => $this->status,
            "created_at" => $this->created_at->format('d-m-Y, g:i A'),
            "updated_at" => $this->updated_at->format('d-m-Y, g:i A')
        ];
    }
}
