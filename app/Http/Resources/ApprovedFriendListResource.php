<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovedFriendListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $auth_user=auth()->user();
    // $data->requested_by==$auth_user->id ? $data->user_two->id : $data->user_one->id,
        return [

            'id' =>$this->id,
            'created_at'=>$this->created_at->format('d-m-Y, g:i A'),
            'friend_detail'=>$this->requested_by==$auth_user->id ? [
                'id'=>$this->user_two->id,
                'name'=>$this->user_two->name,
                'country'=>$this->user_two->country,
                'avatar'=>$this->user_two->avatar,
                'player_number'=>$this->user_two->playerid,
                'rank'=>$this->user_two->rank->rank_name,
            ] : [
                'id'=>$this->user_one->id,
                'name'=>$this->user_one->name,
                'country'=>$this->user_one->country,
                'avatar'=>$this->user_one->avatar,
                'player_number'=>$this->user_one->playerid,
                'rank'=>$this->user_one->rank->rank_name,
            ]

        ];
    }
}
