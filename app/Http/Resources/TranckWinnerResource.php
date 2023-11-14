<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TranckWinnerResource extends JsonResource
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
            'room_code'=>$this->room_code,
            'winners'=>$this->track_winners ? $this->track_winners->map(function ($query){
               return [
                    'id'=>$query->id,
                    'user_id'=>$query->user_id,
                    'position'=>$query->position,
                ];

            }) : ''
        ];
    }
}
