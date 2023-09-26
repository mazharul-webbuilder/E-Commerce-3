<?php

namespace App\Http\Controllers;

use App\Models\CoinEarningHistory;
use App\Models\CoinUseHistory;
use App\Models\Free2pgame;
use App\Models\Free2pgamesettings;
use App\Models\HomeCoinUseHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class Free_two_playerController extends Controller
{
    public $checker = 1;
    public $coin = 0;
    public $child_parent = null;
    public $auth_user = null;
    public function twoplayer_play(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'entry_coin' => 'required|numeric',
            'game_id' => 'required',
        ]);

     //   return Auth::user();

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if (Auth::check()) {
            try {
                DB::beginTransaction();
                if ($request->entry_coin >= 100) {
                    if (Auth::user()->paid_coin >= $request->entry_coin) {

                        $max = Free2pgame::max('game_no');
                        $existing_game = Free2pgame::where('player_one', Auth::user()->id)->where('status', 0)->first();
                        if ($existing_game ==  null) {
                            Auth::user()->update([
                                'paid_coin' =>  Auth::user()->paid_coin -  $request->entry_coin,
                            ]);

                            CoinUseHistory::create([
                                'user_id' => Auth::user()->id,
                                'user_coin' => $request->entry_coin,
                                'type' => 'paid_coin',
                                'purpose' => 'home_game',
                            ]);

                            $new_game = Free2pgame::create([
                                'winner_coin' => $request->entry_coin * Free2pgamesettings::first()->winner_coin_multiply_value,
                                'multiply_by' => Free2pgamesettings::first()->winner_coin_multiply_value,
                                'entry_coin' => $request->entry_coin,
                                'game_no' => $max + 1,
                                'player_one' => Auth::user()->id,
                                'game_id' => $request->game_id,
                            ]);

                            $this->coin = $request->entry_coin;
                            $types = RANK_COMMISSION_COLUMN[0];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $types, COIN_EARNING_SOURCE['home_game_registration']);

                            if ($new_game) {
                                DB::commit();
                                $success = Auth::user();
                                $success['winner_coin'] =  $request->entry_coin * Free2pgamesettings::first()->winner_coin_multiply_value;
                                $success['game_data'] =  $new_game;
                                return api_response('success', 'New Game Created', $success, 200);
                            } else {
                                Db::rollBack();
                                return api_response('warning', 'Something went a wrong!', 200);
                            }
                        } else {
                            $success = Auth::user();
                            $success['winner_coin'] =  $request->entry_coin * Free2pgamesettings::first()->winner_coin_multiply_value;
                            $success['game_data'] =  $existing_game;
                            return api_response('success', 'Game Already Exist', $success, 200);
                        }
                    } else {
                        return response()->json(['type' => "error", 'message' => "You dont have enough coin to play."]);
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
                $existing_game = Free2pgame::where('game_id', $request->game_id)->where('status', 0)->first();
                //return  $existing_game;
                if ($existing_game !=  null) {
                    if (Auth::user()->paid_coin >= $existing_game->entry_coin && Auth::user()->paid_coin >= $request->entry_coin) {
                        if ($existing_game->player_two == null) {
                            Auth::user()->update([
                                'paid_coin' =>  Auth::user()->paid_coin -  $existing_game->entry_coin,
                            ]);

                            CoinUseHistory::create([
                                'user_id' => Auth::user()->id,
                                'user_coin' => $existing_game->entry_coin,
                                'type' => 'paid_coin',
                                'purpose' => 'home_game',
                            ]);


                            $game = $existing_game->update([
                                'player_two' => Auth::user()->id,
                            ]);

                            $this->coin = $existing_game->entry_coin;
                            $types = RANK_COMMISSION_COLUMN[0];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $types, COIN_EARNING_SOURCE['home_game_registration']);

                            if ($game) {
                                DB::commit();
                                $success = Auth::user();
                                $success['winner_coin'] =  $existing_game->entry_coin * Free2pgamesettings::first()->winner_coin_multiply_value;
                                $success['game_data'] =  $existing_game;
                                return api_response('success', 'Game join', $success, 200);
                            } else {
                                DB::rollback();
                                return api_response('warning', 'Something went a wrong!', 200);
                            }
                        } elseif ($existing_game->player_two == Auth::user()->id) {
                            $success = Auth::user();
                            $success['winner_coin'] =  $existing_game->entry_coin * Free2pgamesettings::first()->winner_coin_multiply_value;
                            $success['game_data'] =  $existing_game;
                            return api_response('success', 'You already Join this game!', $success, 200);
                        } else {
                            return api_response('warning', 'Game Already Full filed', 200);
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

    public function two_player_game_complete(Request $request)
    {


        $game = Free2pgame::where('game_id', $request->game_id)->first();

                if ($game != null) {
                    $check_winner=Free2pgame::where('game_id',$request->game_id)->where(function ($query) use($request){
                        $query->where('player_one',$request->winner_id)
                            ->orWhere('player_two',$request->winner_id)->get();
                    })->first();

                    $check_looser=Free2pgame::where('game_id',$request->game_id)->where(function ($query) use($request){
                        $query->where('player_one',$request->looser_id)
                            ->orWhere('player_two',$request->looser_id)->get();
                    })->first();

                    if (is_null($check_winner) || is_null($check_looser)){

                        $game->status=1;
                        $game->save();

                        return api_response('success', 'Game Completed', $game, 200);

                    }else {

                        if ($game->status == 0) {

                            $validator = Validator::make($request->all(), [
                                'winner_id' => 'required|numeric',
                                'looser_id' => 'required|numeric',
                                'game_id' => 'required',
                            ]);

                            if ($validator->fails()) {
                                return response()->json(['error' => $validator->errors()->all()]);
                            } else {
                                DB::beginTransaction();
                                $game = Free2pgame::where('game_id', $request->game_id)->first();

                                $game->winner = $request->winner_id;
                                $game->looser = $request->looser_id;

                                $game->status = 1;
                                $game->save();
                                $user = User::find($request->winner_id);
                                $user->update([
                                    'win_balance' => $user->win_balance + $game->winner_coin,
                                ]);

                                CoinEarningHistory::create([
                                    'user_id'=>$request->winner_id,
                                    'earning_coin'=>$game->winner_coin,
                                    'earning_source'=>'Home Game Win',
                                    'balance_type'=>BALANCE_TYPE['win_balance']
                                ]);

                                $this->coin = $game->entry_coin;
                                $types = RANK_COMMISSION_COLUMN[4];
                                $user=User::find($request->winner_id);
                                $this->auth_user = $user;
                                $this->rank_commission_distribution($user, $types, COIN_EARNING_SOURCE['home_game_asset']);


                                $datas = [
                                    'user_id' => $request->winner_id,
                                    'title' => "You have won this game",
                                    'type' => 'win',
                                    'status' => 0
                                ];
                                notification($datas);
                                DB::commit();
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
       // return $user;
        if ($user->rank->priority !== 5) {
            if ($this->checker == 1) {
                $parent = User::where('id', $user->parent_id)->first();

                if (!empty($parent)) {

                    if ($parent->rank->priority >= $this->auth_user->rank->priority) {
                        if ($parent->rank->priority !== 1 || $parent->rank->priority !== 0) {

                            $commission = commission_by_column_name($type, $parent, $this->coin);


                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent->block_commission == 1) {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
