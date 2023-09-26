<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataApplyUserResource extends JsonResource
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
            'avatar'=>$this->avatar,
            'player_number'=>$this->playerid,
            'phone'=>$this->mobile,
            'country'=>$this->country,
            'send_referral_code_status'=>$this->send_referral_code
        ];
    }
}
