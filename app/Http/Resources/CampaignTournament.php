<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignTournament extends JsonResource
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
            'tournament_name'=>$this->tournament_name,
            'player_limit'=>$this->player_limit,
            'winning_prize'=>$this->winning_prize,
            'player_type'=>$this->player_type,
            'diamond_use'=>$this->diamond_use,
            'diamond_limit'=>$this->diamond_limit,
            //'campaign_status'=>
        ];
    }
}
