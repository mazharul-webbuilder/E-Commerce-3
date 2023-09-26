<?php

namespace App\Http\Resources;

use App\Models\Playerenroll;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TournamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->game_type == config('app.game_type.Regular')){
            $type = "Regular";
            if($this->game_sub_type = config('app.regular_sub_type.General'))
            {
                $sub_type = "General";
            }elseif ($this->game_sub_type = config('app.regular_sub_type.Classic')){
                $sub_type = "Classic";
            }

        }elseif($this->game_type == config('app.game_type.League')){
            $type = "League";
            $sub_type = 'null';

        }elseif($this->game_type == config('app.game_type.Campaign')){
            $type = "Campaign";
            if($this->game_sub_type = config('app.campaign_sub_type.Educational'))
            {
                $sub_type = "Educational";
            }elseif ($this->game_sub_type = config('app.campaign_sub_type.Travelling')){
                $sub_type = "Travelling";
            }
            elseif ($this->game_sub_type = config('app.campaign_sub_type.GiftAndOthers')){
                $sub_type = "GiftAndOthers";
            }
        }elseif($this->game_type == config('app.game_type.Offer')){
            $type = "Offer";
            $sub_type = 'null';
        }
        return [
            'id'=>$this->id,
            'tournament_name'=>$this->tournament_name,
            'game_type'=>$type,
           // 'tournament_owner'=>$this->tournament_owner,
            'game_sub_type'=>$sub_type,
            'player_type'=>$this->player_type,
            'player_limit'=>$this->player_limit,
            'player_enroll'=>$this->player_enroll,
            'un_registration_option'=>$this->registration_use ==1? "Active":"Inactve",
            'diamond_use_option'=>$this->diamond_use == 1 ?"Active":"Inactve" ,
            "used_diamond"  => $this->used_diamond,
            'registration_fee'=>$this->registration_fee,
            'game_start_delay_time'=> $this->game_start_delay_time,
            'winning_prize'=>$this->winning_prize,
            'diamond_limit'=>$this->diamond_use == 1 ?$this->diamond_limit:"Not Available",
            'registered_player' => Playerenroll::where('user_id',Auth::user()->id)->where('tournament_id',$this->id)->first() != null ? "yes" :"no",
            'rounds'=>$this->rounds->map(function ($data){
                return [
                    "id"  => $data->id,
                    "tournament_id"  => $data->tournament_id,
                    "board_quantity"  => $data->board_quantity,
                    "round_type"  => $data->round_type,
                    "time_gaping"  => $data->time_gaping,
                    "diamond_limit"  => $data->diamond_limit,
                    "used_diamond"  => $data->used_diamond,
                    "first_bonus_point"  => $data->first_bonus_point,
                    "second_bonus_point"  => $data->second_bonus_point,
                    "third_bonus_point"  =>$data->third_bonus_point,
                    "fourth_bonus_point"  => $data->fourth_bonus_point,
                    'status' => $data->status ==0 ?"Incomplete":"Complete",
                ];
            }),
        ];
    }
}
