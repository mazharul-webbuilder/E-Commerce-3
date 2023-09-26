<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Mytransferlist extends JsonResource
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
          'id' => $this->id,
          'share_to'=>player_name($this->share_to),
           'share_holder_number' => $this->share_holder->share_number,
           'created_at' => $this->created_at->format('d-m-Y, g:i A'),
        ];
    }
}
