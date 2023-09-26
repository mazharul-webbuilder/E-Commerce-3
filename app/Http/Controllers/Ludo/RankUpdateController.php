<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Models\CoinUseHistory;
use App\Models\Rank;
use App\Models\RankUpdateHistory;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class RankUpdateController extends Controller
{

    public $checker = 1;
    public $coin = 0;
    public $child_parent = null;
    public $rank_commission = null;

    public function rank_update_coin(Request $request)
    {
        // return auth()->user()->id;
        if ($request->isMethod("post")) {
            try {
                DB::beginTransaction();
                $user = auth()->user();
                if ($user->rank->priority != 5) {

                    $rank_update_coin = rank_update_coin($user->next_rank_id)->coin;

                    if ($user->paid_coin >= $rank_update_coin) {

                        // store campaign history
                        // save update rank history
                        // save update rank history
                        $rank_update_history = RankUpdateHistory::create([
                            'user_id' => $user->id,
                            'previous_rank_id' => $user->rank_id,
                            'current_rank_id' => $user->next_rank_id,
                            'type' => 'coin_update'
                        ]);

                        // provide gift token
                        $token = rank_update_token($user->next_rank_id);

                        for ($i = 1; $i <= $token->gift_token; $i++) {
                            UserToken::create([
                                'user_id' => $user->id,
                                'previous_rank_id' => $user->rank_id,
                                'current_rank_id' => $user->next_rank_id,
                                'token_number' => strtoupper(uniqid("GT")),
                                'getting_source' => UserToken::getting_source[0],
                                'type' => UserToken::token_type[0]
                            ]);
                        }

                        // save coin uses history
                        CoinUseHistory::create([
                            'user_id' => $user->id,
                            'user_coin' => $rank_update_coin,
                            'type' => 'paid_coin',
                            'purpose' => CoinUseHistory::balance_uses_purpose[2]
                        ]);

                        $current_coin = $user->paid_coin;
                        $remain_coin = $current_coin - $rank_update_coin;
                        $user->paid_coin = $remain_coin + $user->hold_coin;
                        $user->game_asset = $user->game_asset + $user->hold_coin;
                        $user->hold_coin = 0;
                        $user->block_commission = 1;
                        $user->rank_id = $user->next_rank_id;
                        $user->last_rank_update_date = Carbon::now()->format('Y-m-d h:i:s');
                        $next_rank = Rank::where('priority', $user->next_rank->priority + 1)->first();

                        if (!empty($next_rank)) {
                            $user->next_rank_id = $next_rank->id;
                        } else {
                            $user->next_rank_status = "stop";
                        }
                        $rank_updated = $user->save();
                        DB::commit();

                        // provide commission
                        if ($rank_updated) {
                          //  return $rank_update_coin;

                            provide_generation_commission($user, $rank_update_coin, COIN_EARNING_SOURCE['rank_updating']);
                            rank_update_admin_store($rank_update_history, $rank_update_coin);
                            campaign_history(User::find($user->id), CAMPAIGN_TYPE[0]);
                            share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['rank_update'], $rank_update_coin);
                        }

                        return response()->json([
                            'message' => "You rank updated successfully",
                            'type' => 'success',
                            'status' => Response::HTTP_OK
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'message' => "You have no enough balance",
                            'type' => 'error',
                            'status' => Response::HTTP_ACCEPTED
                        ], Response::HTTP_OK);
                    }
                } else {
                    return response()->json([
                        'message' => "You cannot update your rank.You already reached supreme rank.",
                        'type' => 'error',
                        'status' => Response::HTTP_ALREADY_REPORTED
                    ], Response::HTTP_OK);
                }
            } catch (QueryException $e) {
                DB::rollBack();
                $error = $e->getMessage();
                return response()->json([
                    'message' => $error,
                    'type' => 'error',
                    'status' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }


    public function test_rank()
    {
        //1=VIP,2=partner,3=star,4=sub controller,5=controller
        $user = auth()->user();
        $this->coin = 200;
        $type = RANK_COMMISSION_COLUMN[2];
        $this->rank($user, $type);
    }

    public function rank($user, $type)
    {

        $auth_user = auth()->user();
        if ($user->rank->priority !== 5) {
            if ($this->checker == 1) {
                $parent = User::where('id', $user->parent_id)->first();
                if (!empty($parent)) {
                    if ($parent->rank->priority >= $auth_user->rank->priority) {
                        if ($parent->rank->priority !== 1) {

                            $commission = commission_by_column_name($type, $parent, $this->coin);

                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent->block_commission === 1) {
                                    $current_game_asset = $parent->game_asset;
                                    $parent->game_asset = $current_game_asset + $commission;
                                    $parent->save();
                                } else {
                                    $current_hold_coin = $parent->hold_coin;
                                    $parent->hold_coin = $current_hold_coin + $commission;
                                    $parent->save();
                                }
                            } else {
                                $current_coin = $parent->paid_coin;
                                $parent->paid_coin = $current_coin + $commission;
                                $parent->save();
                            }
                        }
                    }
                    $this->child_parent = $parent;
                    $this->checker = 2;
                    $this->rank($parent, $type);
                }
            } else {
                //echo $this->child_parent->parent_id;
                $parent_one = User::where('id', $this->child_parent->parent_id)->first();
                if (!empty($parent_one)) {

                    if ($parent_one->rank->priority > $this->child_parent->rank->priority) {
                        if ($parent_one->rank->priority != 1) {

                            $commission = commission_by_column_name($type, $parent_one, $this->coin);

                            if ($type === RANK_COMMISSION_COLUMN[4]) {
                                if ($parent_one->block_commission === 1) {
                                    $current_game_asset = $parent_one->game_asset;
                                    $parent_one->game_asset = $current_game_asset + $commission;
                                    $parent_one->save();
                                } else {
                                    $current_hold_coin = $parent_one->hold_coin;
                                    $parent_one->hold_coin = $current_hold_coin + $commission;
                                    $parent_one->save();
                                }
                            } else {
                                $current_coin = $parent_one->paid_coin;
                                $parent_one->paid_coin = $current_coin + $commission;
                                $parent_one->save();
                            }
                        }
                    }
                    $this->child_parent = $parent_one;
                    $this->rank($parent_one, $type);
                }
            }
        }
    }
}
