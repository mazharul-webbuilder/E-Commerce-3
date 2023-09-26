<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\Http\Resources\Tournament;
use App\Http\Resources\GamedataResource;
use App\Http\Resources\TournamentResource;
use App\Models\BidderCommissionHistory;
use App\Models\Biding_details;
use App\Models\Diamond_uses;
use App\Models\DiamondUseHistory;
use App\Models\Free4playergame;
use App\Models\Friendlist;
use App\Models\Game;
use App\Models\Gameround;
use App\Models\Playerenroll;
use App\Models\Playerinboard;
use App\Models\RegisterToOfferTournament;
use App\Models\Roundludoboard;
use App\Models\RoundSettings;
use App\Models\Settings;
use App\Models\Tournament;
use App\Models\User;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Rank;
use App\Models\RankUpdateHistory;
use App\Http\Resources\Roundjoindeatils;

class TournamentController extends Controller
{

    public function index()
    {
        $admin= auth()->guard('admin')->user();
        $tournaments = Tournament::latest()
            ->where('tournament_owner',Tournament::TOURNAMENT_OWNER[0])
            ->get();
        return  view('webend.tournament',compact('tournaments'));
    }

    public function club_owner_tournament(){
        $tournaments = Tournament::latest()
            ->where('tournament_owner',Tournament::TOURNAMENT_OWNER[1])
            ->get();
        return  view('webend.club_owner_tournament',compact('tournaments'));
    }

    public function approve_club_owner_tournament(Request $request){
        $tournament=Tournament::find($request->tournament_id);
      //  return $tournament;

        if ($tournament->status==1){
           $tournament->status=2;
        }elseif ($tournament->status==2){
            $tournament->status=1;
        }
        $tournament->note=$request->note;
        $tournament->save();

        return response()->json([
            'message'=>'Successful updated',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function game_sub_type($id)
    {
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

    public function game_type($id)
    {
        $value = (int)$id;

        if ($value == config('app.game_type')){
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

    public function store(Request $request)
    {
        $admin= auth()->guard('admin')->user();
      // dd($request->all());
        $request->validate([
            'tournament_name'=>'required',
            'game_type' =>'required',
            'player_type' =>'required',
            'player_limit' =>'required',
//            'registration_fee' =>'required',
//            'winning_prize' =>'required',
//            'diamond_limit' =>'required',
            'status' =>'required',
        ]);
        try {
            DB::beginTransaction();
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
            $tournament->diamond_limit = $request->diamond_limit != null ? $request->diamond_limit: null;
            $tournament->game_sub_type = $request->game_sub_type != null ? $request->game_sub_type: null;
            $tournament->status = $request->status;
            $tournament->winner_price_detail = $request->prize_details;
            $tournament->admin_id = $admin->id;
            $tournament->tournament_owner = Tournament::TOURNAMENT_OWNER[0];

            if($request->game_type==2){
                $tournament->registration_fee_gift_token = $request->registration_fee_token;
            }else if ($request->game_type==3){
                $tournament->registration_fee_green_token = $request->registration_fee_token;
            }
            $tournament->save();
            if ($tournament){
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
            DB::commit();
            Alert::success('Tournament Create Successfully.');
            return back();

        } catch (\Exception $e) {
            DB::rollback();
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function bidding_list($id)
    {
        $board_data = Roundludoboard::find($id);
        $bidding_lists = Biding_details::where('board_id',$id)->latest()->get();
        return view('webend.bidding_list',compact('bidding_lists','board_data'));
    }

    public function offer_tournament_register($id){

        $offer_tournament_registers=RegisterToOfferTournament::where('tournament_id',$id)
            ->get();
        $tournament=Tournament::find($id);
        $valid_register=RegisterToOfferTournament::where('tournament_id',$id)
            ->where('status',1)
            ->count();
        $player_enrolls=Playerenroll::where('tournament_id',$id)
            ->count();
        $tournament_game_board=Playerinboard::where('tournament_id',$id)->get();
        return view('webend.tournament.offer_tournament_register',compact('offer_tournament_registers','tournament','valid_register','player_enrolls','tournament_game_board'));

    }
    public function offer_tournament_manage_game(Request $request){
        if ($request->isMethod('POST')){
            try {
                $tournament_registers=RegisterToOfferTournament::where('tournament_id',$request->tournament_id)->get();
                $tournament=Tournament::find($request->tournament_id);
                if (count($tournament_registers)>=$tournament->player_limit){
                    $game=Game::create([
                        'game_no' =>1,
                        'tournament_id' => $request->tournament_id,
                        'status' => 0,
                    ]);
                    tournament_round($request->tournament_id,$game->id);
                    foreach ($tournament_registers as $tournament_register){
                        Playerenroll::create([
                            'tournament_id' => $request->tournament_id,
                            'game_id' => $game->id,
                            'user_id' =>$tournament_register->user_id
                        ]);
                        $tournament_register->update(['status'=>0]);
                    }
                    $tournament->update(['status'=>2]);

                    DB::commit();
                    return response()->json([
                        'message'=>"Tournament set up successfully done",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);

                }else{
                    //'player limit issue'
                }
            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }


    public function offer_tournament_start_game(Request  $request){
      if ($request->isMethod('post')){
          $tournament=Tournament::find($request->tournament_id);
          $game=Game::where('tournament_id',$request->tournament_id)->first();
         // return $game;
          board_create($game,$tournament);
          return response()->json([
              'message'=>"Game Start Successfully",
              'type'=>'success',
              'status'=>Response::HTTP_OK
          ],Response::HTTP_OK);
      }
    }

    public function club_owner_tournament_round_price($id){


        $tournament = Tournament::find($id);
        $rounds_setting = RoundSettings::where('tournament_id',$id)->get();
        return view('webend.club_owner_tournament_price',compact('tournament','rounds_setting'));
    }
}
