<?php

namespace App\Http\Resources;

use App\Models\Playerenroll;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        $position=null;
        $user=auth()->user();
        if ($this->first_winner==$user->id){
            $position="First Position";
        }elseif ($this->second_winner==$user->id){
            $position="Second Position";
        }elseif ($this->third_winner==$user->id){
            $position="Third Position";
        }elseif ($this->fourth_winner==$user->id){
            $position="Fourth Position";
        }
        return [
            'id'=>$this->id,
            'game_id'=>$this->game_id,
            'board_status'=>$this->status,
            'game_status'=>$this->game->status,
            'position'=>$position,
            'round_number'=>$this->round->round_no,
            'tournament_detail'=>[
                'id'=>$this->tournament_id,
                'game_type'=>$this->tournament->game_type,
                'tournament_name'=>$this->tournament->tournament_name,
                'tournament_type'=>$this->tournament_type($this->tournament->game_type),
                'player_limit'=>$this->tournament->player_limit,
                'registration_cost'=>$this->tournament->registration_fee,
                'player_type'=>$this->tournament->player_type,
            ]
        ];
    }

    public  function tournament_type($type){
        switch ($type){
            case 1:
                return "Regular Tournament";
            case 2:
                return "League Tournament";
            case 3:
                return "Campaign Tournament";
            case 4:
                return "Offer Tournament";
        }
    }

}
