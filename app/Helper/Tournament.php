<?php

use App\Models\Gameround;
use App\Models\Playerenroll;
use App\Models\Playerinboard;
use App\Models\Roundludoboard;
use App\Models\RoundSettings;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Tournament;

function board_create($game,$tournament)
{
    $round_number = Gameround::where('game_id',$game->id)->count();
    if($round_number>1){
        $round = Gameround::where('game_id',$game->id)->where('round_no',1)->first();
    }else{
        $round = Gameround::where('game_id',$game->id)->first();
    }
    //return $round."dsds";
    $board_limit = 0;
    $player_board = 0;

    if($tournament->player_type =='4p'){
        $board_limit = $tournament->player_limit / 4;
        $player_board = 4;
    }else{
        $board_limit = $tournament->player_limit / 2;
        $player_board = 2;
    }
    for($i = 0; $i < $board_limit; $i++){
        $new_board = Roundludoboard::create([
            'tournament_id' =>$tournament->id,
            'game_id' =>$game->id,
            'round_id' =>  $round->id,
            'board_number' =>strtoupper(Str::random(6)),
            'status' => 0,
        ]);
        $player_in_board = Playerenroll::where('tournament_id',$tournament->id)->where('game_id',$game->id)->skip($i==0?0:$i*$player_board)->take($player_board)->get();
        foreach ($player_in_board as $key => $data)
        {
            if($key==0){
                $player = Playerinboard::create([
                    'tournament_id' =>$tournament->id,
                    'game_id' => $game->id,
                    'round_id' =>  $round->id,
                    'board_id' =>  $new_board->id,
                    'player_one' => $data->user_id,
                    'status' => 0,
                ]);
            }elseif($key==1){
                $playerbaord = Playerinboard::where('board_id',$new_board->id)->update([
                    'player_two' => $data->user_id,
                ]);
            }elseif($key==2){
                $playerbaord = Playerinboard::where('board_id',$new_board->id)->update([
                    'player_three' => $data->user_id,
                ]);
            }
            elseif($key==3){
                $playerbaord = Playerinboard::where('board_id',$new_board->id)->update([
                    'player_four' => $data->user_id,
                ]);
            }
        }
    }
    $round_settings = RoundSettings::where(['tournament_id'=>$round->tournament_id,'round_type'=>$round->round_no])->first();
    $round->round_start_time = Carbon::now()->addMinute($round_settings['time_gaping']);
    $round->count_down =1;
    $round->save();
}

function create_round($request,$tournament){
    $type = 1;
    if ($request->player_type == '2p'){
        for ($i = $tournament->player_limit;$i>=4 ; $i /= 2 ){

            if ($i / 4 == 1){
                $round_setting = new RoundSettings();
                $round_setting->tournament_id =$tournament->id;
                $round_setting->round_type ='final';
                $round_setting->board_quantity =1;
                $round_setting->diamond_limit =$request->diamond_limit_round;
                $round_setting->time_gaping =$tournament->game_start_delay_time;
                $round_setting->save();
            }else if($i / 4 >= 2){
                $round_setting = new RoundSettings();
                $round_setting->tournament_id =$tournament->id;
                $round_setting->round_type =$type++;
                $round_setting->board_quantity = $i /2;
                $round_setting->diamond_limit =$request->diamond_limit_round;
                $round_setting->time_gaping = $tournament->game_start_delay_time;
                $round_setting->save();
            }
        }

    }else{
        for ($i = $tournament->player_limit;$i>=4 ; $i /= 2 ){
            if ($i / 4 == 1){
                $round_setting = new RoundSettings();
                $round_setting->tournament_id =$tournament->id;
                $round_setting->round_type ='final';
                $round_setting->board_quantity = 1;
                $round_setting->diamond_limit =$request->diamond_limit_round;
                $round_setting->time_gaping =$tournament->game_start_delay_time;
                $round_setting->save();
            }else if($i / 4 >=2 ){
                $round_setting = new RoundSettings();
                $round_setting->tournament_id =$tournament->id;
                $round_setting->round_type =$type++;
                $round_setting->board_quantity = $i /4;
                $round_setting->diamond_limit =$request->diamond_limit_round;
                $round_setting->time_gaping =$tournament->game_start_delay_time;
                $round_setting->save();
            }
        }
    }
}

function club_tournament_registration_commission_distribution($tournament){
    if ($tournament->tournament_owner==Tournament::TOURNAMENT_OWNER[1]){
        $club_owner=$tournament->club_owner;
        $club_owner_origin=$club_owner->origin;
        $origin_commission=(club_setting()->club_join_club_owner_commission*$tournament->registration_fee)/100;
        $club_owner_origin->paid_coin=$club_owner_origin->paid_coin+$origin_commission;
        $club_owner_origin->save();
        coin_earning_history($club_owner_origin->id,$origin_commission,COIN_EARNING_SOURCE['club_tournament_registration_owner_commission']);

    }

}
