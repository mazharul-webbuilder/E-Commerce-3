<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Gameround;
use App\Models\Playerenroll;
use App\Models\TokenUseHistory;
use App\Models\Tournament;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CampaignTournamentController extends Controller
{

    public function join_campaign_tournament(Request $request){
       // return auth()->user()->id;
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
                    $user_tokens=UserToken::where(['user_id'=>$user->id,'type'=>'green','status'=>1])->get();

                    if (count($user_tokens)>=$tournament->registration_fee_green_token){

                  //  if ($tournament->status==0)
                        $game=Game::where(['tournament_id'=>$tournament->id,'status'=>0])->first();
                        $last_game_no=Game::where('tournament_id',$tournament->id)->max('game_no');
                        if (empty($game)){
                            //return "nai";
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
                                $user_first_token=UserToken::where(['user_id'=>$user->id,'type'=>'green','status'=>1])->first();
                                $user_first_token->update(['status'=>0]);

                                TokenUseHistory::create([
                                    'user_id'=>$user->id,
                                    'user_token_id'=>$user_first_token->id,
                                    'purpose'=>'campaign_tournament',
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
                           // return "oka";
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
                                        $user_first_token=UserToken::where(['user_id'=>$user->id,'type'=>'green','status'=>1])->first();
                                        $user_first_token->update(['status'=>0]);

                                        TokenUseHistory::create([
                                            'user_id'=>$user->id,
                                            'user_token_id'=>$user_first_token->id,
                                            'purpose'=>'campaign_tournament',
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
                            'message'=>'Your have no enough green token',
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

    public function tournament_game_round_start(Request $request){

        $validator=Validator::make($request->all(),[
            'tournament_id'=>'required',
            'game_id'=>'required',
            'round_no'=>'required',
        ]);
        if ($request->isMethod("POST")){
            if ($validator->fails()){
                return response()->json([
                    'message'=>$validator->getMessageBag()->first(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_OK);
            }else{
                try {
                    DB::beginTransaction();
                    $game_round=Gameround::where(['tournament_id'=>$request->tournament_id,'game_id'=>$request->game_id,'round_no'=>$request->round_no])->first();
                    $game_round->status=1;
                    $game_round->save();
                    Game::find($request->game_id)->update(['status'=>1]);
                    DB::commit();

                    return response()->json([
                        'message'=>"Successfully updated",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);

                }catch (QueryException $e){
                    DB::rollBack();
                    return response()->json([
                        'message'=>$e->getMessage(),
                        'type'=>'error',
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        }
    }

    // This api will call when last ludo board last member will provide wining result
    public function tournament_game_round_end(Request $request){
        $validator=Validator::make($request->all(),[
            'tournament_id'=>'required',
            'game_id'=>'required',
            'round_no'=>'required',
        ]);
        if ($request->isMethod("POST")){
            if ($validator->fails()){
                return response()->json([
                    'message'=>$validator->getMessageBag()->first(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_OK);
            }else{
                try {
                    DB::beginTransaction();
                    $game_round=Gameround::where(['tournament_id'=>$request->tournament_id,'game_id'=>$request->game_id,'round_no'=>$request->round_no])->first();
                    $game_round->status=2;
                    $game_round->save();

                    if ($game_round->round_no==='final'){
                        Game::find($request->game_id)->update(['status'=>2]);
                    }else{
                        Game::find($request->game_id)->update(['status'=>1]);
                    }
                    DB::commit();

                    return response()->json([
                        'message'=>"Successfully updated",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);

                }catch (QueryException $e){
                    DB::rollBack();
                    return response()->json([
                        'message'=>$e->getMessage(),
                        'type'=>'error',
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

        }
    }

    public function unregister_from_tournament(Request $request){

        $validator=Validator::make($request->all(),[
            'tournament_id'=>'required',
            'game_id'=>'required',
        ]);
        if ($request->isMethod("post")){
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
                    if ($tournament->registration_use==1){
                        $game=Game::find($request->game_id);
                        if ($game->status==0){

                           $player_enroll= Playerenroll::where(['tournament_id'=>$request->tournament_id,'game_id'=>$request->game_id,'user_id'=>auth()->user()->id])->first();

                        if (!empty($player_enroll)){
                           $tournament=Tournament::find($request->tournament_id);
                           if ($tournament->game_type==1){

                               $registration_fee=$tournament->registration_fee;
                               $detuch_commission=calculate_commission(setting()->tournament_unregistation_commission,$registration_fee);
                               $refund_balance=$registration_fee-$detuch_commission;
                               $user=Auth::user();
                               $user->paid_coin=$user->paid_coin+$refund_balance;
                               $user->save();
                           }

                            $player_enroll->delete();
                            DB::commit();
                            return response()->json([
                                'message'=>"Successfully unregistered",
                                'type'=>'success',
                                'status'=>Response::HTTP_OK
                            ],Response::HTTP_OK);
                        }else{
                            return response()->json([
                                'message'=>"Data not found",
                                'type'=>'success',
                                'status'=>Response::HTTP_FORBIDDEN
                            ],Response::HTTP_OK);
                        }

                        }else{
                            return response()->json([
                                'message'=>"You can't cancel your registration",
                                'type'=>'warning',
                                'status'=>Response::HTTP_BAD_REQUEST
                            ],Response::HTTP_OK);
                        }
                    }else{
                        return response()->json([
                            'message'=>"Un registration not allow for this tournament",
                            'type'=>'warning',
                            'status'=>Response::HTTP_LOCKED
                        ],Response::HTTP_OK);
                    }

                }catch (QueryException $e){
                    DB::rollBack();
                    return response()->json([
                        'message'=>$e->getMessage(),
                        'type'=>'error',
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

        }
    }

}
