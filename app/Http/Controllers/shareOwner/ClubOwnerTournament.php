<?php

namespace App\Http\Controllers\ClubOwner;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Gameround;
use App\Models\Roundludoboard;
use App\Models\RoundSettings;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ClubOwnerTournament extends Controller
{


    public function __construct(){
        $this->middleware('owner');
    }
    public function index(){
       $user= auth()->guard('owner')->user();
        $tournaments=Tournament::latest()->where('tournament_owner',Tournament::TOURNAMENT_OWNER[1])
            ->where('club_owner_id',$user->id)
            ->get();
        return view('webend.club_owner.tournament.index',compact('tournaments'));
    }

    public function create(){

        return view('webend.club_owner.tournament.create');
    }

    public function get_game_sub_type($id){
        $value = (int)$id;
        if ($value == config('app.game_type.Regular')){
            $data = config('app.regular_sub_type');
            return response($data);
        }elseif($value == config('app.game_type.Campaign')){
            $data = config('app.campaign_sub_type');
            return response($data);
        }else{
            $data = 'null';
            return response($data);
        }
    }

    public function store(Request $request){

        $club_owner= auth()->guard('owner')->user();
        //return $club_owner;
        $request->validate([
            'tournament_name'=>'required',
            'game_type' =>'required',
            'player_type' =>'required',
            'player_limit' =>'required',
        ]);
        try {
            DB::beginTransaction();

            $tournament_limit=Tournament::latest()->where('tournament_owner',Tournament::TOURNAMENT_OWNER[1])
                ->where('club_owner_id',$club_owner->id)
                ->whereMonth('created_at',Carbon::now()->month)
                ->get();
          // return count($tournament_limit);


            if ($club_owner->origin->rank->priority==5 && count($tournament_limit)<club_setting()->controller_tournament_post_limit){

                $hour = $request->hour != null ? $request->hour * 60 : 0;
                $min = $request->minute != null ? $request->minute : 0;
                $total =  $hour + $min;

                $tournament = new Tournament();
                $tournament->tournament_name = $request->tournament_name;
                $tournament->game_type = $request->game_type;
                $tournament->player_type = $request->player_type;
                $tournament->player_limit = $request->player_limit;
                $tournament->registration_fee = $request->registration_fee;
                $tournament->registration_use = $request->registration_use;
                $tournament->game_start_delay_time = $total;
                $tournament->diamond_use = $request->diamond_use;
                $tournament->winning_prize = $request->winning_prize;
                $tournament->diamond_limit = $request->diamond_limit != null ?$request->diamond_limit: null;
                $tournament->game_sub_type = $request->game_sub_type != null ? $request->game_sub_type: null;
                $tournament->winner_price_detail = $request->prize_details;
                $tournament->club_owner_id = $club_owner->id;
                $tournament->tournament_owner = Tournament::TOURNAMENT_OWNER[1];
                $tournament->status = 2;

                if($request->game_type==2){
                    $tournament->registration_fee_gift_token = $request->registration_fee_token;
                }else if ($request->game_type==3){
                    $tournament->registration_fee_green_token = $request->registration_fee_token;
                }
                $tournament->save();
                if ($tournament){
                    create_round($request,$tournament);
                }
                DB::commit();
                Alert::success('Tournament Create Successfully.');
                return back();
            }elseif ($club_owner->origin->rank->priority==4 && count($tournament_limit)<club_setting()->sub_controller_tournament_post_limit){
                $hour = $request->hour != null ? $request->hour * 60 : 0;
                $min = $request->minute != null ? $request->minute : 0;
                $total =  $hour + $min;

                $tournament = new Tournament();
                $tournament->tournament_name = $request->tournament_name;
                $tournament->game_type = $request->game_type;
                $tournament->player_type = $request->player_type;
                $tournament->player_limit = $request->player_limit;
                $tournament->registration_fee = $request->registration_fee;
                $tournament->registration_use = $request->registration_use;
                $tournament->game_start_delay_time = $total;
                $tournament->diamond_use = $request->diamond_use;
                $tournament->winning_prize = $request->winning_prize;
                $tournament->diamond_limit = $request->diamond_limit != null ?$request->diamond_limit: null;
                $tournament->game_sub_type = $request->game_sub_type != null ? $request->game_sub_type: null;

                $tournament->winner_price_detail = $request->prize_details;
                $tournament->club_owner_id = $club_owner->id;
                $tournament->tournament_owner = Tournament::TOURNAMENT_OWNER[1];
                $tournament->status = 2;

                if($request->game_type==2){
                    $tournament->registration_fee_gift_token = $request->registration_fee_token;
                }else if ($request->game_type==3){
                    $tournament->registration_fee_green_token = $request->registration_fee_token;
                }
                $tournament->save();
                if ($tournament){
                    create_round($request,$tournament);
                }
                DB::commit();
                Alert::success('Tournament Create Successfully.');
                return back();
            }else{
                Alert::error('You  have exceeded you tournament limit.');
                return back();
            }

        } catch (\Exception $e) {
            DB::rollback();
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function tournament_round($id){
        $tournament = Tournament::find($id);
        $rounds_setting = RoundSettings::where('tournament_id',$id)->get();
        return view('webend.club_owner.tournament.round',compact('rounds_setting','tournament'));
    }
    public function update_game_round(Request $request){
        try {
            DB::beginTransaction();
            $round = RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','!=','final')->max('round_type');

            for ($i =1;$i<=$round; $i++){
                $hour= $request->input('hour'.$i);
                $hourmin = $hour * 60;
                $total = $hourmin + $request->input('min'.$i);
//                dd($total);
                $tournament = Tournament::find($request->tournament_id);
                if ($tournament->player_type == '2p'){
                    RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','!=','final')->where('round_type',$i)->update([
                        'time_gaping' => $total,
                        'fourth_bonus_point' =>$request->input('forth'.$i),
                        'updated_at' =>Carbon::now(),
                    ]);
                }else{
                    RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','!=','final')->where('round_type',$i)->update([
                        'time_gaping' => $total,
                        'third_bonus_point' =>$request->input('third'.$i),
                        'fourth_bonus_point' =>$request->input('fourth'.$i),
                        'updated_at' =>Carbon::now(),
                    ]);
                }

            }
            RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','final')->update([
//            'time_gaping' => $total,
                'first_bonus_point' =>$request->first_final,
                'second_bonus_point' =>$request->second_final,
                'third_bonus_point' =>$request->third_final,
                'fourth_bonus_point' =>$request->forth_final,
                'updated_at' =>Carbon::now(),
            ]);
            DB::commit();
            Alert::success('Round setting Update Successfully.');
            return back();

        } catch (\Exception $e) {
            DB::rollback();
            Alert::error($e->getMessage());
            return back();

        }
    }
    public function tournament_game($id){
        $tournament = Tournament::find($id);
        $games = Game::where('tournament_id',$id)->get();
        return view('webend.club_owner.tournament.game',compact('games','tournament'));
    }

    public function game_round($id){
        $game = Game::find($id);
        $rounds = Gameround::where('game_id',$id)->get();
        return view('webend.club_owner.tournament.game_round',compact('game','rounds'));
    }
    public function round_board($id){

        $round = Gameround::find($id);
        $boards = Roundludoboard::where('round_id',$id)->get();
        return view('webend.club_owner.tournament.board',compact('round','boards'));

    }
}
