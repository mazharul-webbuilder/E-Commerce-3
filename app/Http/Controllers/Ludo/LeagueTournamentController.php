<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;

use App\Http\Resources\TournamentHistoryResource;
use App\Http\Resources\TournamentResource;
use App\Models\Game;
use App\Models\Playerenroll;
use App\Models\Playerinboard;
use App\Models\RoundSettings;
use App\Models\TokenUseHistory;
use App\Models\Tournament;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LeagueTournamentController extends Controller
{


    public function join_league_tournament(Request $request){
       //return auth()->user()->id;
        $validator=Validator::make($request->all(),[
            'tournament_id'=>'required'
        ]);
        if ($request->isMethod('post')){
            if ($validator->fails()){
                return response()->json([
                    'message'=>$validator->getMessageBag()->first(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_OK);
            }else{
                try {
                    DB::beginTransaction();
                    $tournament=Tournament::find($request->tournament_id);
                    $user=auth()->user();
                    $user_tokens=UserToken::where(['user_id'=>$user->id,'type'=>'gift','status'=>1])->get();

                    if (count($user_tokens)>=$tournament->registration_fee_gift_token){

                        $game=Game::where(['tournament_id'=>$tournament->id,'status'=>0])->first();
                        $last_game_no=Game::where('tournament_id',$tournament->id)->max('game_no');
                        if (empty($game)){
                            // create game
                           $game=new Game();
                           $game->tournament_id=$tournament->id;
                           $game->game_no=$last_game_no+1;
                           $game->status=0;
                           $game->save();

                           // round create
                           if (count($game->allrounds)<=0){
                               tournament_round($tournament->id,$game->id);
                           }
                           // enrollment player
                           $player_enroll=Playerenroll::create([
                               'tournament_id'=>$tournament->id,
                               'user_id'=>$user->id,
                               'game_id'=>$game->id,
                           ]);
                           $game_info=Game::with('allrounds:id,tournament_id,game_id,round_no,status')->where(['tournament_id'=>$tournament->id,'status'=>0])->first();

                           // consume user token
                           if ($player_enroll){
                               $user_first_token=UserToken::where(['user_id'=>$user->id,'type'=>'gift','status'=>1])->first();
                               $user_first_token->update(['status'=>0]);

                               TokenUseHistory::create([
                                   'user_id'=>$user->id,
                                   'user_token_id'=>$user_first_token->id,
                                   'purpose'=>'league_tournament',
                                   'tournament_id'=>$tournament->id
                               ]);
                           }
                            DB::commit();
                            return response()->json([
                                'message'=>'You have joined successfully',
                                'game_info'=>$game_info,
                                'type'=>'success',
                                'status'=>Response::HTTP_OK
                            ],Response::HTTP_OK);

                        }else{
                            if (count($game->game_players)<$tournament->player_limit){
                                $exist_user=Playerenroll::where(['user_id'=>$user->id,'tournament_id'=>$tournament->id,'game_id'=>$game->id])->first();
                                if (empty($exist_user)){
                                    //player enrollment
                                    $player_enroll=Playerenroll::create([
                                        'user_id'=>$user->id,
                                        'tournament_id'=>$tournament->id,
                                        'game_id'=>$game->id
                                    ]);

                                    if ($player_enroll){
                                        // update user gift token
                                        $user_first_token=UserToken::where(['user_id'=>$user->id,'type'=>'gift','status'=>1])->first();
                                        $user_first_token->update(['status'=>0]);

                                        TokenUseHistory::create([
                                            'user_id'=>$user->id,
                                            'user_token_id'=>$user_first_token->id,
                                            'purpose'=>'league_tournament',
                                            'tournament_id'=>$tournament->id
                                        ]);

                                        $all_enrollments=Playerenroll::where(['tournament_id'=>$tournament->id,'game_id'=>$game->id])->get();
                                        // close enrollment on game
                                        if (count($all_enrollments)>=$tournament->player_limit){
                                            $game->update(['status'=>3]);
                                            //board create helper function
                                            board_create($game,$tournament);
                                        }
                                    }

                                    $game_info=Game::with('allrounds:id,tournament_id,game_id,round_no,status')->where(['tournament_id'=>$tournament->id,'status'=>0])->first();
                                    DB::commit();
                                    return response()->json([
                                        'message'=>'You have joined successfully',
                                        'game_info'=>$game_info,
                                        'type'=>'success',
                                        'status'=>Response::HTTP_OK
                                    ],Response::HTTP_OK);

                                }else{
                                    return response()->json([
                                        'message'=>'Your are already registered on this tournament',
                                        'game_info'=>null,
                                        'type'=>'success',
                                        'status'=>Response::HTTP_OK
                                    ],Response::HTTP_OK);
                                }
                            }else{
                                return "new game";
                            }
                        }
                    }else{
                        return response()->json([
                            'message'=>'Your have no enough gift token',
                            'type'=>'insufficient',
                            'game_info'=>null,
                            'status'=>Response::HTTP_FORBIDDEN
                        ],Response::HTTP_OK);
                    }

                }catch (QueryException $e){
                    DB::rollBack();
                    return response()->json([
                        'message'=>$e->getMessage(),
                        'type'=>'error',
                        'game_info'=>null,
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                    ],Response::HTTP_OK);
                }
            }
        }

    }

    public function complete_game_list(){

         $user=auth()->user();

        $player_in_board_lists=Playerinboard::where('player_one',$user->id)
            ->orWhere('player_two',$user->id)
            ->orWhere('player_three',$user->id)
            ->orWhere('player_four',$user->id)
            ->get();
        $gameIDs=[];

        foreach ($player_in_board_lists as $data){
            array_push($gameIDs,$data->game_id);
        }

      $unique_gameIDS=(array_unique($gameIDs));

        $games=Game::whereIn('id',$unique_gameIDS)->where('status',2)->get();

        $my_last_boards=[];
        foreach ($games as $game){
            $p_board = Playerinboard::where('game_id',$game->id)
                ->where(function ($query) use ($user) {
                    $query->where('player_one', $user->id)
                        ->orWhere('player_two',$user->id)
                        ->orWhere('player_three',$user->id)
                        ->orWhere('player_four',$user->id);
                })
                ->orderBy('id','DESC')
                ->first();
            array_push($my_last_boards,$p_board);
        }

        $data=TournamentHistoryResource::collection($my_last_boards);

        return response()->json([
            'data'=>$data,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);

    }

    public function running_game_list(){

        $user=auth()->user();
        $game_lists=Playerinboard::where('player_one',$user->id)
            ->orWhere('player_two',$user->id)
            ->orWhere('player_three',$user->id)
            ->orWhere('player_four',$user->id)
            ->groupBy('game_id')
            ->get();
        $my_data=[];
        foreach ($game_lists as $data){
            if ($data->game->status==1){
                array_push($my_data,$data);
            }
        }
        $data=TournamentHistoryResource::collection($my_data);

        return response()->json([
            'data'=>$data,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);

    }

    public function tournament_prize_detail($tournament_id){

        $prize=RoundSettings::where(['tournament_id'=>$tournament_id,'round_type'=>'final'])
            ->with('tournament',function ($query){
                $query->select('id', 'winner_price_detail','game_type');
            })
            ->first(['id','tournament_id','first_bonus_point','second_bonus_point','third_bonus_point','fourth_bonus_point']);
        return response()->json([
            'prize'=>$prize,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ]);

    }

    public function filter_tournament($game_type){
        if ($game_type==0){
            $tournaments=Tournament::latest()->get();
        }else{
            $tournaments=Tournament::where('game_type',$game_type)->latest()->get();
        }
        $tournaments=TournamentResource::collection($tournaments);

        return response()->json([
            'tournaments'=>$tournaments,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }



}
