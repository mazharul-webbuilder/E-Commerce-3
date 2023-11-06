<?php

namespace App\Http\Controllers;

use App\Models\CoinEarningHistory;
use App\Models\CoinUseHistory;
use App\Models\Free3pgame;
use App\Models\Free3pgamesettings;
use App\Models\Free4playergame;
use App\Models\Free4playergamesettings;
use App\Models\HomeCoinUseHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Free4playerController extends Controller
{
    public $checker = 1;
    public $coin = 0;
    public $child_parent = null;
    public $auth_user = null;

    public function game_join(Request $request)
    {
       // return auth()->user();
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            try {
                DB::beginTransaction();
                $existing_game = Free4playergame::where('game_id', $request->game_id)->where('status', 0)->first();
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
                            share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);

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
                                'paid_coin' =>  Auth::user()->paid_coin -  $existing_game->entry_fee,
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
                        } elseif (($existing_game->player_two != Auth::user()->id) && ($existing_game->player_three ==  Auth::user()->id)) {
                            $success = Auth::user();
                            $success['game_data'] =  $existing_game;
                            return api_response('success', 'You already Join this game!', $success, 200);
                        } elseif (($existing_game->player_three != Auth::user()->id) && ($existing_game->player_four == null)) {
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
                                'player_four' => Auth::user()->id,
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
                        } elseif ($existing_game->player_four ==  Auth::user()->id) {
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

    public function create_four_player_game(Request $request)
    {
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
                        $max = Free4playergame::max('game_no');
                        $existing_game = Free4playergame::where('player_one', Auth::user()->id)->where('status', 0)->first();
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

                            $new_game = Free4playergame::create([
                                'first_winner_coin' => $request->entry_fee * Free4playergamesettings::first()->first_winner_multiply,
                                'second_winner_coin' => $request->entry_fee * Free4playergamesettings::first()->second_winner_multiply,
                                'third_winner_coin' => $request->entry_fee * Free4playergamesettings::first()->third_winner_multiply,
                                'loser_coin' => $request->entry_fee * Free4playergamesettings::first()->looser_multiply,
                                'first_winner_multiply' => Free4playergamesettings::first()->first_winner_multiply,
                                'second_winner_multiply' => Free4playergamesettings::first()->second_winner_multiply,
                                'third_winner_multiply' => Free4playergamesettings::first()->third_winner_multiply,
                                'looser_multiply' => Free4playergamesettings::first()->looser_multiply,
                                'entry_fee' => $request->entry_fee,
                                'game_no' => $max + 1,
                                'player_one' => Auth::user()->id,
                                'game_id' => $request->game_id,
                            ]);
                            // commission
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
            } catch (\Exception $ex) {
                Db::rollBack();
                return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
            }
        }
    }

    public function game_complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
            'first_winner' => 'nullable|numeric',
            'second_winner' => 'nullable|numeric',
            'third_winner' => 'nullable|numeric',
            'loser' => 'nullable|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $game = Free4playergame::where('game_id', $request->game_id)->first();
        if ($game != null) {

            $check_first_winner = Free4playergame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->first_winner)
                    ->orWhere('player_two', $request->first_winner)
                    ->orWhere('player_three', $request->first_winner)
                    ->orWhere('player_four', $request->first_winner)
                    ->get();
            })->first();

            //  return $check_first_winner;

            $check_second_winner = Free4playergame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->second_winner)
                    ->orWhere('player_two', $request->second_winner)
                    ->orWhere('player_three', $request->second_winner)
                    ->orWhere('player_four', $request->second_winner)
                    ->get();
            })->first();

            $check_third_winner = Free4playergame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->third_winner)
                    ->orWhere('player_two', $request->third_winner)
                    ->orWhere('player_three', $request->third_winner)
                    ->orWhere('player_four', $request->third_winner)
                    ->get();
            })->first();

            $check_looser = Free4playergame::where('game_id', $request->game_id)->where(function ($query) use ($request) {
                $query->where('player_one', $request->loser)
                    ->orWhere('player_two', $request->loser)
                    ->orWhere('player_three', $request->loser)
                    ->orWhere('player_four', $request->loser)
                    ->get();
            })->first();

            if (is_null($check_first_winner) || is_null($check_second_winner) || is_null($check_third_winner) || is_null($check_looser)){
                $game->status=1;
                $game->save();

                return api_response('success', 'Game Completed', $game, 200);
            }else {
                   // return "ase";
                if ($game->status == 0) {
                    DB::beginTransaction();
                    if ($request->first_winner != null) {

                        $game->first_winner = $request->first_winner;
                        $game->save();
                        $first_winner = User::find($request->first_winner);
                        $first_winner->update([
                            'win_balance' => $first_winner->win_balance + $game->first_winner_coin,
                        ]);

                        $this->coin = $game->entry_fee;
                        $types = RANK_COMMISSION_COLUMN[4];
                        $user=User::find($request->first_winner);
                        $this->auth_user = $user;
                        $this->rank_commission_distribution($user, $types, COIN_EARNING_SOURCE['home_game_asset']);

                        coin_earning_history($request->first_winner,$game->first_winner_coin,'Home Game Win',BALANCE_TYPE['win_balance']);


                    }
                    if ($request->second_winner != null) {
                        // if (($game->player_one == $request->second_winner) || ($game->player_two == $request->second_winner) || ($game->player_three == $request->second_winner) || ($game->player_four == $request->second_winner)) {
                        $game->second_winner = $request->second_winner;
                        $game->save();
                        $second_winner = User::find($request->second_winner);
                        $second_winner->update([
                            'win_balance' => $second_winner->win_balance + $game->second_winner_coin,
                        ]);
                        coin_earning_history($request->second_winner,$game->second_winner_coin,'Home Game Win',BALANCE_TYPE['win_balance']);


                    }
                    if ($request->third_winner != null) {
                        if (($game->first_winner != null) && ($game->second_winner != null)) {
                            // if (($game->player_one == $request->third_winner) || ($game->player_two == $request->third_winner) || ($game->player_three == $request->third_winner) || ($game->player_four == $request->third_winner)) {
                            $game->third_winner = $request->third_winner;
                            $game->loser = $request->loser;
                            $game->status = 1;
                            $game->save();
                            $third_winner = User::find($request->third_winner);
                            $third_winner->update([
                                'win_balance' => $third_winner->win_balance + $game->third_winner_coin,
                            ]);

                            coin_earning_history($request->third_winner,$game->third_winner,'Home Game Win',BALANCE_TYPE['win_balance']);

                            // loser define
                            $looser = User::find($request->loser);
                            $looser->update([
                                'win_balance' => $looser->win_balance + $game->loser_coin,
                            ]);



                        } else {
                            return api_response('warning', 'Firstly We need to declare first &  second winner.', 200);
                        }
                    }
                    DB::commit();
                    if (($game->first_winner != null) && ($game->second_winner == null)) {
                        $datas = [
                            'user_id' => $request->first_winner,
                            'title' => "You have won this game",
                            'type' => 'win',
                            'status' => 0
                        ];
                        notification($datas);
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
                                    //  return $commission;
                                    $current_game_asset = $parent->game_asset;
                                    $parent->game_asset = $current_game_asset + $commission;
                                    $parent->save();
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
                                    $parent_one->save();
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
}
