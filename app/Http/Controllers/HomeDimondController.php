<?php

namespace App\Http\Controllers;

use App\Models\DiamondUseHistory;
use App\Models\Free2pgame;
use App\Models\Free3pgame;
use App\Models\Free4playergame;
use App\Models\HomeDimond;
use App\Models\HomeDimondUseHistory;
use App\Models\HomeGame;
use App\Models\PlayerWiningPercentage;
use App\Models\Rank;
use App\Models\RankUpdateHistory;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeDimondController extends Controller
{

    public $checker = 1;
    public $coin = 0;
    public $child_parent = null;
    public $auth_user = null;
    public $winning_position = ['first_bonus_point', 'second_bonus_point', 'third_bonus_point', 'fourth_bonus_point'];

    function homedimondstore(Request $request)
    {
        try {

            $user = auth()->user();
            // check diamond

            if ($user->paid_diamond < 1) {
                return response()->json([
                    'message' => "You have no enought coin",
                    'type' => 'error',
                    'status' => 200,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            } else {

                $dimondusedbyuser = 2;

                $user_dimond_use = HomeDimond::where('player_id', $user->id)
                    ->where('room_code', $request->room_code)
                    ->count('dimond_usaged');
                $dimondtotal = $dimondusedbyuser - $user_dimond_use;


                if ($user_dimond_use <= 1) {

                    $dimondused = HomeDimond::create([
                        'room_code' => $request->input('room_code'),
                        'player_id' => $user->id,
                        'dimond_usaged' => 1,
                    ], Response::HTTP_OK);


                    $userdata = User::where('id', $user->id)->first();

                    $available = $userdata->paid_diamond;

                    $userdata->update([
                        'paid_diamond' => $available - 1,
                    ]);

                    if ($user->vip_member == 0) {

                        //  rank update
                        $userdata->update([
                            'rank_id' => Rank::where('priority', 1)->first()->id,
                            'next_rank_id' => Rank::where('priority', 2)->first()->id,
                            'vip_member' => 1,
                            'refer_code' => rand(10000, 99999)
                        ]);
                        // rank update history
                        RankUpdateHistory::create([
                            'user_id' => Auth::user()->id,
                            'previous_rank_id' => Rank::where('priority', 0)->first()->id,
                            'current_rank_id' => Rank::where('priority', 1)->first()->id,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                    // diamond use history
                    DiamondUseHistory::create([
                        'user_id' => Auth::user()->id,
                        'used_diamond' => 1,
                        'type' => 'home',
                    ]);
                    $this->coin = 1;
                    // $this->coin = 10;
                    //return $this->coin;

                    $type = RANK_COMMISSION_COLUMN[1];
                    $this->auth_user = auth()->user();
                    $this->rank_commission_distribution(auth()->user(), $type, COIN_EARNING_SOURCE['diamond_use']);
                    share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['diamond_use'], $this->coin);



                    return response()->json([
                        'dimonduse' => $dimondtotal - 1,
                        'type' => 'success',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'dimonduse' => $dimondtotal,
                        'type' => 'success',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                }
            }
        } catch (QueryException $e) {
            // Log the error or handle it as needed
            return response()->json([
                'error' => "An error occurred while processing the request"
            ], 500);
        } catch (Throwable $e) {
            // Handle any other unexpected exceptions
            return response()->json([
                'error' => $e
            ], 500);
        }
    }


    function homeIncompleteGame()
    {
        $user = auth()->user();
        try {

            $free_two_players = Free2pgame::where('status',0)->where(function($query) use($user){
                $query->where('player_one', $user->id)
                    ->orWhere('player_two', $user->id)->get();
            })
                ->leftJoin('player_wining_percentages', function ($join) {
                    $join->on('free2pgames.game_id', '=', 'player_wining_percentages.room_code');
                })
                ->select('free2pgames.game_id as game_id', 'free2pgames.*', 'player_wining_percentages.*')
                ->get()
                ->map(function ($item) {
                    $item['type'] = '2p';
                    return $item;
                });

            return response()->json([
                'data' => $free_two_players,
                'type' => 'success',
                'message' => 'You have an unfinished game',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    function homeIncompleteGame3p()
    {
        $user = auth()->user();
        try {

            $free_three_players = Free3pgame::where('status',0)->where(function ($query) use($user){
                $query->where('player_one',$user->id)
                    ->orWhere('player_two',$user->id)
                    ->orWhere('player_three',$user->id)->get();
            })
                ->leftJoin('player_wining_percentages', function ($join) {
                    $join->on('free3pgames.game_id', '=', 'player_wining_percentages.room_code');
                })
                ->select('free3pgames.game_id as game_id', 'free3pgames.*', 'player_wining_percentages.*')
                ->get()
                ->map(function ($item) {
                    $item['type'] = '3p';
                    return $item;
                });

            return response()->json([
                'data' => $free_three_players,
                'type' => 'success',
                'message' => 'You have an unfinished game',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }


    function homeIncompleteGame4p()
    {
        $user = auth()->user();
        try {
            $free_three_players = Free4playergame::where('status', 0)->where(function ($query) use($user){
                    $query->orWhere('player_one', $user->id)
                    ->orWhere('player_two', $user->id)
                        ->orWhere('player_three', $user->id)
                    ->orWhere('player_four', $user->id)->get();
            })
                ->leftJoin('player_wining_percentages', function ($join) {
                    $join->on('free4playergames.game_id', '=', 'player_wining_percentages.room_code');
                })
                ->select('free4playergames.game_id as game_id', 'free4playergames.*', 'player_wining_percentages.*')
                ->get()
                ->map(function ($item) {
                    $item['type'] = '4p';
                    return $item;
                });
            return response()->json([
                'data' => $free_three_players,
                'type' => 'success',
                'message' => 'You have an unfinished game',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

public function entry_fee_check(Request $request){

        if ($request->isMethod("POST")){
          //  $data=null;
            if ($request->game_type=='2p'){

                $data=Free2pgame::where('game_id',$request->room_number)->where('status',0)->first();

            }elseif ($request->game_type=='3p'){

                $data=Free3pgame::where('game_id',$request->room_number)->where('status',0)->first();

            }elseif ($request->game_type=='4p'){
                $data=Free4playergame::where('game_id',$request->room_number)->where('status',0)->first();
            }

            if (!is_null($data)){

                return response()->json([
                    'data' => $request->game_type=='2p' ? $data->entry_coin : $data->entry_fee,
                ]);
            }else{

                return response()->json([
                    'data' => null,
                ]);
            }
        }
}
    function entry_fee_checktest($entry_fee_check)
    {

        try {
            $result = Free2pgame::where('game_id', $entry_fee_check)->first();

            if (!$result) {
                $result = Free3pgame::where('game_id', $entry_fee_check)->first();
            }

            if (!$result) {
                $result = Free4playergame::where('game_id', $entry_fee_check)->first();
            }

            if (!$result) {
                return response()->json([
                    'data' => null,
                ]);
            }

            // return $result;

            if ($result->entry_coin) {
                return response()->json([
                    'data' => $result->entry_coin,
                ]);
            } else if ($result->entry_fee) {
                return response()->json([
                    'data' => $result->entry_fee,
                ]);
            } else {
                return response()->json([
                    'data' => null,
                ]);
            }
        } catch (\Exception $e) {
            // Handle the exception or log the error message
            // For example:
            // Log::error($e->getMessage());
            return null;
        }
    }





    public function rank_commission_distribution($user, $type, $coin_earning_source)
    {

        //$auth_user=$this->auth_user;
        if ($user->rank->priority !== 5) {
            if ($this->checker == 1) {
                $parent = User::where('id', $user->parent_id)->first();

                if (!empty($parent)) {

                    if ($parent->rank->priority >= $this->auth_user->rank->priority) {
                        if ($parent->rank->priority !== 1 || $parent->rank->priority !== 0) {

                            $commission = commission_by_column_name($type, $parent, $this->coin);


                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent->block_commission === 1) {
                                    //  return $commission;
                                    $current_game_asset = $parent->game_asset;
                                    $parent->game_asset = $current_game_asset + $commission;
                                    $parent->save();
                                    if ($commission > 0) {
                                        coin_earning_history($parent->id, $commission, $coin_earning_source);
                                    }
                                } else {

                                    $current_hold_coin = $parent->hold_coin;
                                    $parent->hold_coin = $current_hold_coin + $commission;
                                    $parent->save();
                                }
                            } else {

                                $current_coin = $parent->marketing_balance;
                                $parent->marketing_balance = $current_coin + $commission;
                                $parent->save();

                                if ($commission > 0) {
                                    coin_earning_history($parent->id, $commission, $coin_earning_source);
                                }
                            }
                        }
                    }
                    $this->child_parent = $parent;
                    $this->checker = 2;
                    $this->rank_commission_distribution($parent, $type, $coin_earning_source);
                } else {
                    //echo "no parent 1";
                }
            } else {
                //echo $this->child_parent->parent_id;
                $parent_one = User::where('id', $this->child_parent->parent_id)->first();
                if (!empty($parent_one)) {

                    if ($parent_one->rank->priority > $this->child_parent->rank->priority) {
                        if ($parent_one->rank->priority !== 1 || $parent_one->rank->priority !== 0) {

                            $commission = commission_by_column_name($type, $parent_one, $this->coin);

                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent_one->block_commission === 1) {
                                    $current_game_asset = $parent_one->game_asset;
                                    $parent_one->game_asset = $current_game_asset + $commission;
                                    $parent_one->save();
                                    if ($commission > 0) {
                                        coin_earning_history($parent_one->id, $commission, $coin_earning_source);
                                    }
                                } else {
                                    $current_hold_coin = $parent_one->hold_coin;
                                    $parent_one->hold_coin = $current_hold_coin + $commission;
                                    $parent_one->save();
                                }
                            } else {
                                $current_coin = $parent_one->marketing_balance;
                                $parent_one->marketing_balance = $current_coin + $commission;
                                $parent_one->save();

                                if ($commission > 0) {
                                    coin_earning_history($parent_one->id, $commission, $coin_earning_source);
                                }
                            }
                        }
                    }
                    $this->child_parent = $parent_one;
                    $this->rank_commission_distribution($parent_one, $type, $coin_earning_source);
                } else {
                    //echo "no parent 2";
                }
            }
        }
    }
}
