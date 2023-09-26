<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FriendlistResource extends JsonResource
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

            'id' =>$this->id,
            'created_at'=>$this->created_at,
            'requested_by'=>[
                'id'=>$this->user_one->id,
                'name'=>$this->user_one->name,
                'avatar'=>$this->user_one->avatar,
                'rank'=>$this->user_one->rank->rank_name,
                'player_number'=>$this->user_one->playerid
            ]

        ];
    }
}
