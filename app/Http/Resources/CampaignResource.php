<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
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
            'required_position_name'=>$this->constrain_title,
            'total_needed_position'=>$this->total_needed_position,
            'total_needed_referral'=>$this->total_needed_referral,
            'duration'=>$this->duration,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'tournament'=>[
                'id'=>$this->tournament->id,
                'tournament_name'=>$this->tournament->tournament_name,
                'player_limit'=>$this->tournament->player_limit,
                'winning_prize'=>$this->tournament->winning_prize,
                'winner_price_detail'=>$this->tournament->winner_price_detail
            ],

        ];
    }
}
