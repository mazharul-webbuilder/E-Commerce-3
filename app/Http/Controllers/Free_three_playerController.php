<?php

namespace App\Http\Controllers;


use App\Models\CoinEarningHistory;
use App\Models\CoinUseHistory;
use App\Models\Free2pgame;
use App\Models\Free3pgame;
use App\Models\Free3pgamesettings;
use App\Models\HomeCoinUseHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Free_three_playerController extends Controller
{

    public $checker = 1;
    public $checker2 = 1;
    public $coin = 0;
    public $coin2 = 0;
    public $child_parent = null;
    public $child_parent2 = null;
    public $auth_user = null;
    public $auth_user2 = null;



    public function game_create_threeplayer(Request $request)
    {
        // return auth()->user();

        $validator = Validator::make($request->all(), [
            'entry_fee' => 'required|numeric',
            'game_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (Auth::check()) {
            try {
                DB::beginTransaction();

                if ($request->entry_fee >= 100) {
                    if (Auth::user()->paid_coin >= $request->entry_fee) {
                        $max = Free3pgame::max('game_no');
                        $existing_game = Free3pgame::where('player_one', Auth::user()->id)->where('status', 0)->first();
                        if ($existing_game ==  null) {
                            Auth::user()->update([
                                'paid_coin' =>  Auth::user()->paid_coin -  $request->entry_fee,
                            ]);

                            CoinUseHistory::create([
                                'user_id' => Auth::user()->id,
                                'user_coin' => $request->entry_fee,
                                'type' => 'paid_coin',
                                'purpose' => 'home_game',
                            ]);

                            $new_game = Free3pgame::create([
                                'first_winner_coin' => $request->entry_fee * Free3pgamesettings::first()->first_winner_multiply,
                                'second_winner_coin' => $request->entry_fee * Free3pgamesettings::first()->second_winner_multiply,
                                'third_winner_coin' => $request->entry_fee * Free3pgamesettings::first()->third_winner_multiply,
                                'first_winner_multiply' => Free3pgamesettings::first()->first_winner_multiply,
                                'second_winner_multiply' => Free3pgamesettings::first()->second_winner_multiply,
                                'third_winner_multiply' => Free3pgamesettings::first()->third_winner_multiply,
                                'entry_fee' => $request->entry_fee,
                                'game_no' => $max + 1,
                                'player_one' => Auth::user()->id,
                                'game_id' => $request->game_id,
                            ]);

                            $this->coin = $request->entry_fee;
                            $types = RANK_COMMISSION_COLUMN[0];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $types, COIN_EARNING_SOURCE['home_game_registration']);


                            if ($new_game) {
                                DB::commit();
                                $success = Auth::user();

                                $success['game_data'] =  $new_game;
                                return api_response('success', 'New Game Created', $success, 200);
                            } else {
                                Db::rollBack();
                                return api_response('warning', 'Something went a wrong!', 200);
                            }
                        } else {
                            $success = Auth::user();
                            $success['game_data'] =  $existing_game;
                            return api_response('success', 'Game Already Exist', $success, 200);
                        }
                    } else {
                        return response()->json(['type' => "error", 'message' => " You dont have enough coin to play."]);
                    }
                } else {
                    return response()->json(['type' => "error", 'message' => "You have the required minimum of 100 paid coins to play."]);
                }
                return \auth()->user()->id;
            } catch (\Exception $ex) {
                Db::rollBack();
                return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
            }
        }
    }


    public function game_join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            try {
                DB::beginTransaction();
                $existing_game = Free3pgame::where('game_id', $request->game_id)->where('status', 0)->first();

                if ($existing_game !=  null) {
                    if (Auth::user()->paid_coin >= $existing_game->entry_fee) {

                        if ($existing_game->player_two == null) {
                            Auth::user()->update([
                                'paid_coin' =>  Auth::user()->paid_coin -  $existing_game->entry_fee,
                            ]);

                            CoinUseHistory::create([
                                'user_id' => Auth::user()->id,
                                'user_coin' => $existing_game->entry_fee,
                                'type' => 'paid_coin',
                                'purpose' => 'home_game',
                            ]);

                            $game = $existing_game->update([
                                'player_two' => Auth::user()->id,
                            ]);

                            $this->coin = $existing_game->entry_fee;
                            $types = RANK_COMMISSION_COLUMN[0];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $types, COIN_EARNING_SOURCE['home_game_registration']);

                            if ($game) {
                                DB::commit();
                                $success = Auth::user();
                                $success['game_data'] =  $existing_game;
                                return api_response('success', 'Game join', $success, 200);
                            } else {
                                DB::rollback();
                                return api_response('warning', 'Something went a wrong!', 200);
                            }
                        } elseif ($existing_game->player_two == Auth::user()->id) {
                            $success = Auth::user();
                            $success['game_data'] =  $existing_game;
                            return api_response('success', 'You already Join this game!', $success, 200);
                        } elseif (($existing_game->player_two != Auth::user()->id) && ($existing_game->player_three == null)) {
                            Auth::user()->update([
                                'paid_coin' =>  Auth::user()->paid_coin - $existing_game->entry_fee,
                            ]);

                            CoinUseHistory::create([
                                'user_id' => Auth::user()->id,
                                'user_coin' => $existing_game->entry_fee,
                                'type' => 'paid_coin',
                                'purpose' => 'home_game',
                            ]);

                            $game = $existing_game->update([
                                'player_three' => Auth::user()->id,
                            ]);
                            if ($game) {
                                DB::commit();
                                $success = Auth::user();
                                $success['game_data'] =  $existing_game;
                                return api_response('success', 'Game join', $success, 200);
                            } else {
                                DB::rollback();
                                return api_response('warning', 'Something went a wrong!', 200);
                            }
                        } elseif (($existing_game->player_two != Auth::user()->id) && ($existing_game->player_three ==  Auth::user()->id)) {
                            $success = Auth::user();
                            $success['game_data'] =  $existing_game;
                            return api_response('success', 'You already Join this game!', $success, 200);
                        } else {
                            DB::rollback();
                            return api_response('warning', 'Player Full filed..', 200);
                        }
                    } else {
                        return api_response('warning', 'You dont have enough coin to play this game..!', $existing_game, 200);
                    }
                } else {
                    return api_response('warning', 'Game not found!', 200);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response($e->getMessage());
            }
        }
    }
    public function three_player_game_complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
            'first_winner' => 'nullable|numeric',
            'second_winner' => 'nullable|numeric',
            'looser' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $game = Free3pgame::where('game_id', $request->game_id)->first();

        if ($game != null) {

            $check_first_winner = Free3pgame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->first_winner)
                    ->orWhere('player_two', $request->first_winner)
                    ->orWhere('player_three', $request->first_winner)
                    ->get();
            })->first();

          //  return $check_first_winner;

            $check_second_winner = Free3pgame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->second_winner)
                    ->orWhere('player_two', $request->second_winner)
                    ->orWhere('player_three', $request->second_winner)
                    ->get();
            })->first();

            $check_looser = Free3pgame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->looser)
                    ->orWhere('player_two', $request->looser)
                    ->orWhere('player_three', $request->looser)->get();
            })->first();

            if (is_null($check_first_winner) || is_null($check_second_winner) || is_null($check_looser)) {
                $game->status=1;
                $game->save();

                return api_response('success', 'Game Completed', $game, 200);
            } else {


            if ($game->status == 0) {
                DB::beginTransaction();
                if ($request->first_winner != null) {

                    $first_winner = User::find($request->first_winner);

                    $first_winner->update([
                        'win_balance' => $first_winner->win_balance + $game->first_winner_coin,
                    ]);

                    CoinEarningHistory::create([
                        'user_id'=>$request->first_winner,
                        'earning_coin'=>$game->first_winner_coin,
                        'earning_source'=>'Home Game Win',
                        'balance_type'=>'win_balance'
                    ]);

                    $this->coin = $game->entry_fee;
                    $types = RANK_COMMISSION_COLUMN[4];
                    $user=User::find($request->first_winner);
                    $this->auth_user = $user;
                    $this->rank_commission_distribution($user, $types, COIN_EARNING_SOURCE['home_game_asset']);

                    $datas = [
                        'user_id' => $request->first_winner,
                        'title' => "You have won this game",
                        'type' => 'win',
                        'status' => 0
                    ];
                    $game->first_winner = $request->first_winner;
                    $game->save();
                    notification($datas);
                    DB::commit();
                }

                    if ($request->second_winner != null) {

                        $game->second_winner = $request->second_winner;
                        $game->third_winner = $request->looser;
                        $game->status = 0;
                        $game->save();
                        $second_winner = User::find($request->second_winner);
                        $second_winner->update([
                            'win_balance' => $second_winner->win_balance + $game->second_winner_coin,
                        ]);

                        CoinEarningHistory::create([
                            'user_id'=>$request->second_winner,
                            'earning_coin'=>$game->second_winner_coin,
                            'earning_source'=>'Home Game Win',
                            'balance_type'=>'win_balance'
                        ]);

                       /* $this->coin2 = $game->entry_fee;
                        $types = RANK_COMMISSION_COLUMN[4];
                        $user2=User::find($request->second_winner);
                        $this->auth_user2 = $user2;;
                        $this->rank_commission_distribution2($user2, $types, COIN_EARNING_SOURCE['home_game_asset']);
                      */
                        $third_winner = User::find($request->looser);
                        $third_winner->update([
                            'win_balance' => $third_winner->win_balance + $game->third_winner_coin,
                        ]);
                        DB::commit();
                    }



                if (($game->first_winner != null) && ($game->second_winner == null)) {
                    return api_response('success', 'first winner win', $game, 200);
                } elseif (($game->first_winner != null) && ($game->second_winner != null)) {
                    return api_response('success', 'Game Completed', $game, 200);
                }



            } else {
                return api_response('warning', 'Game Already Completed', $game, 200);
            }
        }
        } else {
            return api_response('warning', 'Game Not Found', 200);
        }
    }


    public function rank_commission_distribution($user, $type, $coin_earning_source)
    {
        if ($user->rank->priority !== 5) {
            if ($this->checker == 1) {
                $parent = User::where('id', $user->parent_id)->first();

                if (!empty($parent)) {

                    if ($parent->rank->priority >= $this->auth_user->rank->priority) {
                        if ($parent->rank->priority !== 1 || $parent->rank->priority !== 0) {

                            $commission = commission_by_column_name($type, $parent, $this->coin);


                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent->block_commission === 1) {
                                     //return $parent;
                                    $current_game_asset = $parent->game_asset;
                                    $parent->game_asset = $current_game_asset + $commission;
                                   // return  $parent;
                                    $d=$parent->save();

                                    if ($commission > 0) {
                                        coin_earning_history($parent->id, $commission, $coin_earning_source,BALANCE_TYPE['game_asset']);
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
                                    coin_earning_history($parent->id, $commission, $coin_earning_source,BALANCE_TYPE['marketing']);
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
                                    $pd=$parent_one->save();

                                    if ($commission > 0) {
                                        coin_earning_history($parent_one->id, $commission, $coin_earning_source,BALANCE_TYPE['game_asset']);
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
                                    coin_earning_history($parent_one->id, $commission, $coin_earning_source,BALANCE_TYPE['marketing']);
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


    public function rank_commission_distribution2($user, $type, $coin_earning_source)
    {
        if ($user->rank->priority !== 5) {
            if ($this->checker2 == 1) {
                $parent2 = User::where('id', $user->parent_id)->first();

                if (!empty($parent2)) {

                    if ($parent2->rank->priority >= $this->auth_user2->rank->priority) {
                        if ($parent2->rank->priority !== 1 || $parent2->rank->priority !== 0) {

                            $commission = commission_by_column_name($type, $parent2, $this->coin2);

                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent2->block_commission === 1) {
                                    //return $parent;
                                    $current_game_asset = $parent2->game_asset;
                                    $parent2->game_asset = $current_game_asset + $commission;
                                    // return  $parent;
                                    $parent2->save();

                                    if ($commission > 0) {
                                        coin_earning_history($parent2->id, $commission, $coin_earning_source,BALANCE_TYPE['game_asset']);
                                    }
                                } else {

                                    $current_hold_coin = $parent2->hold_coin;
                                    $parent2->hold_coin = $current_hold_coin + $commission;
                                    $parent2->save();
                                }
                            } else {

                                $current_coin = $parent2->marketing_balance;
                                $parent2->marketing_balance = $current_coin + $commission;
                                $parent2->save();

                                if ($commission > 0) {
                                    coin_earning_history($parent2->id, $commission, $coin_earning_source,BALANCE_TYPE['marketing']);
                                }
                            }
                        }
                    }
                    $this->child_parent2 = $parent2;
                    $this->checker2 = 2;
                    $this->rank_commission_distribution2($parent2, $type, $coin_earning_source);
                } else {
                    //echo "no parent 1";
                }
            } else {
                //echo $this->child_parent->parent_id;
                $parent_one2 = User::where('id', $this->child_parent2->parent_id)->first();
                if (!empty($parent_one2)) {

                    if ($parent_one2->rank->priority > $this->child_parent2->rank->priority) {
                        if ($parent_one2->rank->priority !== 1 || $parent_one2->rank->priority !== 0) {

                            $commission = commission_by_column_name($type, $parent_one2, $this->coin2);

                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent_one2->block_commission === 1) {
                                    $current_game_asset = $parent_one2->game_asset;
                                    $parent_one2->game_asset = $current_game_asset + $commission;
                                    $parent_one2->save();

                                    if ($commission > 0) {
                                        coin_earning_history($parent_one2->id, $commission, $coin_earning_source,BALANCE_TYPE['game_asset']);
                                    }
                                } else {
                                    $current_hold_coin = $parent_one2->hold_coin;
                                    $parent_one2->hold_coin = $current_hold_coin + $commission;
                                    $parent_one2->save();
                                }
                            } else {
                                $current_coin = $parent_one2->marketing_balance;
                                $parent_one2->marketing_balance = $current_coin + $commission;
                                $parent_one2->save();

                                if ($commission > 0) {
                                    coin_earning_history($parent_one2->id, $commission, $coin_earning_source,BALANCE_TYPE['marketing']);
                                }
                            }
                        }
                    }
                    $this->child_parent2 = $parent_one2;
                    $this->rank_commission_distribution2($parent_one2, $type, $coin_earning_source);
                } else {
                    //echo "no parent 2";
                }
            }
        }
    }

}
