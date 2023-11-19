<?php

namespace App\Http\Resources;

use App\Models\Playerinboard;
use App\Models\Roundludoboard;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GamedataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $board = Playerinboard::where('status','!=',2)->where('player_one',Auth::user()->id)
            ->orWhere('player_two',Auth::user()->id)->orWhere('player_three',Auth::user()->id)
            ->orWhere('player_four',Auth::user()->id)->first();

        $user=auth()->user();

       return [

        'id'=>$this->id,
        'tournament_id'=>$this->tournament_id,
        'game_no'=>$this->game_no,
        'game_status'=>$this->status,
        'board_number'=>$board != null ? Roundludoboard::find($board->board_id)->board_number : '',
        'player_limit'=>$this->tournament->player_limit,
        'total_enroll'=>count($this->game_players),
        'tournament'=>$this->tournament,
           'all_rounds'=>$this->allrounds->map(function ($data) use($user,$board){
               return [
                   "id"  => $data->id,
                   'tournament_id'=>$data->tournament_id,
                   'game_id'=>$data->game_id,
                   'round_no'=>$data->round_no,
                   'round_start_time'=> $data->round_start_time != 0 ? Carbon::parse($data->round_start_time)->addSeconds(1): Carbon::parse('2021-06-08 02:00:00')->addSeconds(1),
                   'round_start_time_foramt'=> $data->round_start_time != 0 ? Carbon::parse($data->round_start_time)->addSeconds(1)->format('d-m-Y,g:i A'): Carbon::parse('2021-06-08 02:00:00')->addSeconds(1),
                   'round_end_time'=> $data->round_end_time != null ?  $data->round_end_time : null,
                   'round_status'=>$data->status,
                   'created_at'=>$data->created_at,
                   'updated_at'=>$data->updated_at,
                   'count_down'=>$data->count_down,
                   'my_board_group_id'=>$this->get_auth_user_board($user,$data->id) !=null ? $this->get_auth_user_board($user,$data->id)->id : null,

                   'my_board_group_members'=>$this->get_auth_user_board($user,$data->id) !=null ? [
                       'player_one'=>$this->get_auth_user_board($user,$data->id)->player_one,
                       'player_two'=>$this->get_auth_user_board($user,$data->id)->player_two,
                       'player_three'=>$this->get_auth_user_board($user,$data->id)->player_three,
                       'player_four'=>$this->get_auth_user_board($user,$data->id)->player_four,
                   ] : null,

                   'board_status'=>$this->get_auth_user_board($user,$data->id)  !=null ? $this->get_auth_user_board($user,$data->id)->board_name->status : null,
                   'result_status'=>$this->get_auth_user_win($user,$data->id)  !=null ? 1 : 0,
                   'remain_board'=>$board !=null ? remain_running_board($board->board_id,$data->id)  : "", // current round board,
               ];
           }),


       ];
    }

    public function get_auth_user_board($user,$round_id){
        $playerinboard = Playerinboard::where('round_id',$round_id)
            ->where(function ($query) use ($user) {
                $query->where('player_one', $user->id)
                    ->orWhere('player_two',$user->id)
                    ->orWhere('player_three',$user->id)
                    ->orWhere('player_four',$user->id);
            })
            ->first();
        return $playerinboard;
    }

    public function get_auth_user_win($user,$round_id){
        $playerinboard = Playerinboard::where('round_id',$round_id)
            ->where(function ($query) use ($user) {
                $query->where('first_winner', $user->id)
                    ->orWhere('second_winner',$user->id)
                    ->orWhere('third_winner',$user->id)
                    ->orWhere('fourth_winner',$user->id);
            })
            ->first();
        return $playerinboard;
    }

}
