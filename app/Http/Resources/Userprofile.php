<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Userprofile extends JsonResource
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
            'country'=>$this->country,
            'paid_coin'=>$this->paid_coin,
            'win_balance'=>$this->win_balance,
            'parent_id'=>$this->parent_id != null ? player_id($this->parent_id) : '',
            'marketing_balance'=>$this->marketing_balance,
            'recovery_fund'=>$this->recovery_fund,
            'shareholder_fund'=>$this->shareholder_fund,
            'crypto_asset'=>$this->crypto_asset,
            'paid_diamond'=>$this->paid_diamond,
            'free_coin'=>$this->free_coin,
            'rank'=>$this->rank->rank_name,
            'last_rank_update_date'=>$this->last_rank_update_date? Carbon::parse($this->last_rank_update_date)->format('d-m-Y, g:i A'): '',
            'total_game_winners'=>total_game_win(),
            'total_tournament_win'=>totall_tournament_win(),
            'two_player_win'=>two_player_win(),
            'four_player_win'=>four_player_win(),
            'win_percentange'=>win_percentange(),
            'diamond_partner'=>$this->diamond_partner,
            'player_number'=>$this->playerid,
            'rank_update_coin'=>rank_update_coin($this->next_rank_id)->coin,
            'current_rank'=>$this->rank->rank_name,
            'next_rank'=>$this->next_rank->rank_name,
            'next_rank_status'=>$this->next_rank_status,
            'diamond_already_used'=>auth()->user()->vip_member,
            'data_apply_status'=>auth()->user()->apply_data,
            'club_member'=>$this->club_member,
            'my_joined_club'=>$this->club_join !=null ? $this->club_join->club_name : null,

        ];
    }
}
