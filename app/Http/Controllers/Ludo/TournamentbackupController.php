<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\GamedataResource;
use App\Http\Resources\Roundjoindeatils;
use App\Http\Resources\TournamentResource;
use App\Models\Biding_details;
use App\Models\Diamond_uses;
use App\Models\DiamondUseHistory;
use App\Models\Game;
use App\Models\Gameround;
use App\Models\Playerenroll;
use App\Models\Playerinboard;
use App\Models\Rank;
use App\Models\RankUpdateHistory;
use App\Models\RegisterToOfferTournament;
use App\Models\Roundludoboard;
use App\Models\RoundSettings;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\TournamentApiTraits;

class TournamentbackupController extends Controller
{
    use TournamentApiTraits;

    public $checker = 1;
    public $coin = 0;
    public $child_parent = null;
    public $auth_user = null;

    public function index()
    {
        $tournaments = Tournament::latest()->get();
        return view('webend.tournament', compact('tournaments'));
    }

    public function game_sub_type($id)
    {
        $value = (int)$id;
        if ($value == config('app.game_type.Regular')) {
            $data = config('app.regular_sub_type');
            return response($data);
        } elseif ($value == config('app.game_type.Campaign')) {
            $data = config('app.campaign_sub_type');
            return response($data);
        } else {
            $data = 'null';

            return response($data);
        }
    }

    public function campaign_sub_game_type()
    {
        $gametypes = config('app.campaign_sub_type');
        return api_response('success', 'Campaign Sub Game Type', $gametypes, 200);
    }


    public function game_type()
    {
        $gametypes = config('app.game_type');
        return api_response('success', 'All Game Type', $gametypes, 200);
    }

    public function regular_sub_game_type()
    {
        $gametypes = config('app.regular_sub_type');
        return api_response('success', 'Regular Sub Game Type', $gametypes, 200);
    }

    public function tournament_join_old(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required'
        ]);
        $tournament = Tournament::find($request->tournament_id);
        $this->coin = $tournament->registration_fee;
        // return $this->coin;
        try {
            DB::beginTransaction();
            if ($tournament != null) {
                if (Auth::check()) {
                    $game = Game::where('tournament_id', $request->tournament_id)->where('status', 0)->first();
                    $game_max = Game::where('tournament_id', $request->tournament_id)->max('game_no');

                    if ($game != null) {
                        if (count($game->game_players) < $tournament->player_limit) {
                            if ($tournament->registration_fee <= Auth::user()->paid_coin) {
                                // here is the commission functionality start

                                $types = RANK_COMMISSION_COLUMN[0];
                                $this->auth_user = auth()->user();
                                $this->rank_commission_distribution(auth()->user(), $types);
                                share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);
                                // here is the commission functionality end

                                $player_enroll = Playerenroll::where('user_id', Auth::user()->id)->where('tournament_id', $request->tournament_id)->where('game_id', $game->id)->first();
                                if ($player_enroll == null) {
                                    $tournament_enroll = Playerenroll::create([
                                        'tournament_id' => $request->tournament_id,
                                        'user_id' => Auth::user()->id,
                                        'game_id' => $game->id,
                                    ]);

                                    if ($tournament_enroll) {
                                        $players = Playerenroll::where('tournament_id', $request->tournament_id)->where('game_id', $game->id)->get();
                                        if (count($players) == $tournament->player_limit) {
                                            $game->update(['status' => 3]);

                                        }

                                        Auth::user()->update(['paid_coin' => Auth::user()->paid_coin - $tournament->registration_fee]);
                                        DB::commit();
                                        return api_response('success', 'Player enroll successfully done0.', $game, 200);
                                    }

                                } else {
                                    return api_response('warning', 'Player already enrolled.', 200);
                                }
                            } else {
                                DB::rollBack();
                                return api_response('insufficient', 'You dont have enough coin to play this game.', 200);
                            }
                        } else {
                            if ($tournament->registration_fee <= Auth::user()->paid_coin) {
                                $game2 = Game::create([
                                    'game_no' => $game_max + 1,
                                    'tournament_id' => $request->tournament_id,
                                    'status' => 0,
                                ]);
                                // here is the commission functionality start

                                $types = RANK_COMMISSION_COLUMN[0];
                                $this->auth_user = auth()->user();
                                $this->rank_commission_distribution(auth()->user(), $types);
                                share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);
                                // here is the commission functionality end
                                if (count($game2->allrounds) < 1) {
                                    $type = 1;
                                    for ($i = $tournament->player_limit; $i >= 4; $i /= 2) {
                                        if ($i / 4 == 1) {
                                            $game_round = new Gameround();
                                            $game_round->tournament_id = $tournament->id;
                                            $game_round->game_id = $game2->id;
                                            $game_round->round_no = 'final';
                                            $game_round->status = 0;
                                            $game_round->save();

                                        } else if ($i / 4 >= 2) {
                                            $game_round = new Gameround();
                                            $game_round->tournament_id = $tournament->id;
                                            $game_round->round_no = $type++;
                                            $game_round->status = 0;
                                            $game_round->game_id = $game2->id;
                                            $game_round->save();
                                        }
                                    }
                                }
                                $tournament_enroll = Playerenroll::create([
                                    'tournament_id' => $request->tournament_id,
                                    'game_id' => $game2->id,
                                    'user_id' => Auth::user()->id,
                                ]);

                                if ($tournament_enroll) {
                                    Auth::user()->update(['paid_coin' => Auth::user()->paid_coin - $tournament->registration_fee]);
                                    DB::commit();
                                    return api_response('success', 'Player enroll successfully done1.', $game2, 200);
                                }

                            } else {
                                DB::rollBack();
                                return api_response('insufficient', 'You dont have enough coin to play this game.', 200);
                            }
                        }

                    } else {//=======================================

                        if ($tournament->registration_fee <= Auth::user()->paid_coin) {
                            Game::create([
                                'game_no' => $game_max + 1,
                                'tournament_id' => $request->tournament_id,
                                'status' => 0,
                            ]);
                            // here is the commission functionality start

                            $types = RANK_COMMISSION_COLUMN[0];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $types);
                            share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);
                            // here is the commission functionality end
                            $game = Game::where('tournament_id', $request->tournament_id)->where('status', 0)->with('allrounds')->first();


                            if (count($game->allrounds) < 1) {
                                $type = 1;
                                for ($i = $tournament->player_limit; $i >= 4; $i /= 2) {
                                    if ($i / 4 == 1) {
                                        $game_round = new Gameround();
                                        $game_round->tournament_id = $tournament->id;
                                        $game_round->game_id = $game->id;
                                        $game_round->round_no = 'final';
                                        $game_round->status = 0;
                                        $game_round->save();
                                    } else if ($i / 4 >= 2) {
                                        $game_round = new Gameround();
                                        $game_round->tournament_id = $tournament->id;
                                        $game_round->round_no = $type++;
                                        $game_round->status = 0;
                                        $game_round->game_id = $game->id;
                                        $game_round->save();
                                    }
                                }
                            }

                            $tournament_enroll = Playerenroll::create([
                                'tournament_id' => $request->tournament_id,
                                'game_id' => $game->id,
                                'user_id' => Auth::user()->id,
                            ]);
                            $gamedata = Game::where('tournament_id', $request->tournament_id)->where('status', 0)->with('allrounds')->first();

                            if ($tournament_enroll) {
                                Auth::user()->update(['paid_coin' => Auth::user()->paid_coin - $tournament->registration_fee]);
                                DB::commit();
                                return api_response('success', 'Player enroll successfully dones2.', $gamedata, 200);
                            }

                        } else {
                            DB::rollBack();
                            return api_response('insufficient', 'You dont have enough coin to play this game.', 200);
                        }
                    }
                }
            } else {
                return api_response('error', 'No Tournament Found', 200);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }

    public function tournament_join(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required'
        ]);
        $tournament = Tournament::find($request->tournament_id);
        $this->coin = $tournament->registration_fee;
        // return $this->coin;
        try {
            DB::beginTransaction();
            if ($tournament != null) {
                if (Auth::check()) {
                    $game = Game::where('tournament_id', $request->tournament_id)->where('status', 0)->first();
                    $game_max = Game::where('tournament_id', $request->tournament_id)->max('game_no');

                    if ($game != null) {
                        if (count($game->game_players) < $tournament->player_limit) {
                            if ($tournament->registration_fee <= Auth::user()->paid_coin) {
                                // here is the commission functionality start

                                $types = RANK_COMMISSION_COLUMN[0];
                                $this->auth_user = auth()->user();
                                $this->rank_commission_distribution(auth()->user(), $types);
                                share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);
                                // here is the commission functionality end

                                $player_enroll = Playerenroll::where('user_id', Auth::user()->id)->where('tournament_id', $request->tournament_id)->where('game_id', $game->id)->first();
                                if ($player_enroll == null) {
                                    $tournament_enroll = Playerenroll::create([
                                        'tournament_id' => $request->tournament_id,
                                        'user_id' => Auth::user()->id,
                                        'game_id' => $game->id,
                                    ]);
                                    if ($tournament_enroll) {
                                        $players = Playerenroll::where('tournament_id', $request->tournament_id)->where('game_id', $game->id)->get();
                                        if (count($players) == $tournament->player_limit) {
                                            $game->update(['status' => 3]);
                                            $round_number = Gameround::where('game_id', $game->id)->count();
                                            if ($round_number > 1) {
                                                $round = Gameround::where('game_id', $game->id)->where('round_no', 1)->first();
                                            } else {
                                                $round = Gameround::where('game_id', $game->id)->first();
                                            }
                                            $board_limit = 0;
                                            $player_board = 0;
                                            if ($tournament->player_type == '4p') {
                                                $board_limit = $tournament->player_limit / 4;
                                                $player_board = 4;
                                            } else {
                                                $board_limit = $tournament->player_limit / 2;
                                                $player_board = 2;
                                            }
                                            for ($i = 0; $i < $board_limit; $i++) {
                                                $new_board = Roundludoboard::create([
                                                    'tournament_id' => $request->tournament_id,
                                                    'game_id' => $game->id,
                                                    'round_id' => $round->id,
                                                    'board_number' => strtoupper(Str::random(6)),
                                                    'status' => 0,
                                                ]);
                                                $player_in_board = Playerenroll::skip($i == 0 ? 0 : $i * $player_board)->take($player_board)->get();
                                                foreach ($player_in_board as $key => $data) {
//                                                    print_r($data).',';
                                                    if ($key == 0) {
                                                        $player = Playerinboard::create([
                                                            'tournament_id' => $request->tournament_id,
                                                            'game_id' => $game->id,
                                                            'round_id' => $round->id,
                                                            'board_id' => $new_board->id,
                                                            'player_one' => $data->user_id,
                                                            'status' => 0,
                                                        ]);
                                                    } elseif ($key == 1) {
                                                        $playerbaord = Playerinboard::where('board_id', $new_board->id)->update([
                                                            'player_two' => $data->user_id,
                                                        ]);
                                                    } elseif ($key == 2) {
                                                        $playerbaord = Playerinboard::where('board_id', $new_board->id)->update([
                                                            'player_three' => $data->user_id,
                                                        ]);
                                                    } elseif ($key == 3) {
                                                        $playerbaord = Playerinboard::where('board_id', $new_board->id)->update([
                                                            'player_four' => $data->user_id,
                                                        ]);
                                                    }
                                                }
                                            }
                                            $round_settings = RoundSettings::where(['tournament_id' => $round->tournament_id, 'round_type' => $round->round_no])->first();
                                            $round->round_start_time = Carbon::now()->addMinute($round_settings->time_gapping);
                                            $round->count_down = 1;
                                            $round->save();
                                        }
                                        Auth::user()->update(['paid_coin' => Auth::user()->paid_coin - $tournament->registration_fee]);
                                        DB::commit();
                                        return api_response('success', 'Player enroll successfully done0.', $game, 200);
                                    }

                                } else {
                                    return api_response('warning', 'Player already enrolled.', 200);
                                }
                            } else {
                                DB::rollBack();
                                return api_response('insufficient', 'You dont have enough coin to play this game.', 200);
                            }
                        } else {
                            if ($tournament->registration_fee <= Auth::user()->paid_coin) {
                                $game2 = Game::create([
                                    'game_no' => $game_max + 1,
                                    'tournament_id' => $request->tournament_id,
                                    'status' => 0,
                                ]);
                                // here is the commission functionality start

                                $types = RANK_COMMISSION_COLUMN[0];
                                $this->auth_user = auth()->user();
                                $this->rank_commission_distribution(auth()->user(), $types);
                                share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);
                                // here is the commission functionality end
                                if (count($game2->allrounds) < 1) {
                                    $type = 1;
                                    for ($i = $tournament->player_limit; $i >= 4; $i /= 2) {
                                        if ($i / 4 == 1) {
                                            $game_round = new Gameround();
                                            $game_round->tournament_id = $tournament->id;
                                            $game_round->game_id = $game2->id;
                                            $game_round->round_no = 'final';
                                            $game_round->status = 0;
                                            $game_round->save();

                                        } else if ($i / 4 >= 2) {
                                            $game_round = new Gameround();
                                            $game_round->tournament_id = $tournament->id;
                                            $game_round->round_no = $type++;
                                            $game_round->status = 0;
                                            $game_round->game_id = $game2->id;
                                            $game_round->save();
                                        }
                                    }
                                }
                                $tournament_enroll = Playerenroll::create([
                                    'tournament_id' => $request->tournament_id,
                                    'game_id' => $game2->id,
                                    'user_id' => Auth::user()->id,
                                ]);

                                if ($tournament_enroll) {
                                    Auth::user()->update(['paid_coin' => Auth::user()->paid_coin - $tournament->registration_fee]);
                                    DB::commit();
                                    return api_response('success', 'Player enroll successfully done1.', $game2, 200);
                                }

                            } else {
                                DB::rollBack();
                                return api_response('insufficient', 'You dont have enough coin to play this game.', 200);
                            }
                        }

                    } else {//=======================================
                        if ($tournament->registration_fee <= Auth::user()->paid_coin) {
                            Game::create([
                                'game_no' => $game_max + 1,
                                'tournament_id' => $request->tournament_id,
                                'status' => 0,
                            ]);
                            // here is the commission functionality start

                            $types = RANK_COMMISSION_COLUMN[0];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $types);
                            share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['tournament_registration'], $this->coin);
                            // here is the commission functionality end
                            $game = Game::where('tournament_id', $request->tournament_id)->where('status', 0)->with('allrounds')->first();
                            if (count($game->allrounds) < 1) {
                                $type = 1;
                                for ($i = $tournament->player_limit; $i >= 4; $i /= 2) {
                                    if ($i / 4 == 1) {
                                        $game_round = new Gameround();
                                        $game_round->tournament_id = $tournament->id;
                                        $game_round->game_id = $game->id;
                                        $game_round->round_no = 'final';
                                        $game_round->status = 0;
                                        $game_round->save();
                                    } else if ($i / 4 >= 2) {
                                        $game_round = new Gameround();
                                        $game_round->tournament_id = $tournament->id;
                                        $game_round->round_no = $type++;
                                        $game_round->status = 0;
                                        $game_round->game_id = $game->id;
                                        $game_round->save();
                                    }
                                }
                            }

                            $tournament_enroll = Playerenroll::create([
                                'tournament_id' => $request->tournament_id,
                                'game_id' => $game->id,
                                'user_id' => Auth::user()->id,
                            ]);
                            $gamedata = Game::where('tournament_id', $request->tournament_id)->where('status', 0)->with('allrounds')->first();

                            if ($tournament_enroll) {
                                Auth::user()->update(['paid_coin' => Auth::user()->paid_coin - $tournament->registration_fee]);
                                DB::commit();
                                return api_response('success', 'Player enroll successfully dones2.', $gamedata, 200);
                            }

                        } else {
                            DB::rollBack();
                            return api_response('insufficient', 'You dont have enough coin to play this game.', 200);
                        }
                    }
                }
            } else {
                return api_response('error', 'No Tournament Found', 200);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }

    }

    //    This function for join round of game start
    public function round_join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'game_id' => 'required|numeric',
            'round_id' => 'required|numeric',
            'room_id' => 'required',
//            'board_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            $round = Gameround::find($request->round_id);
            if (!empty($round)) {
                if ($round->round_no == 'final') {
                    $user = Auth::user()->id;
                    $player = Playerinboard::where('status', '!=', 2)->where('round_id', $request->round_id)
                        ->where(function ($query) use ($user) {
                            $query->where('player_one', $user)
                                ->orWhere('player_two', $user)
                                ->orWhere('player_three', $user)
                                ->orWhere('player_four', $user);
                        })
                        ->first();
                    if (!empty($player)) {
                        $board_data = Roundludoboard::find($player->board_id);
                        if ($board_data->board == null) {
                            $new_board = $board_data->update([
                                'board' => $request->room_id,
                            ]);
                        }
                        $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                        DB::commit();
                        $player = new Roundjoindeatils($player);
                        return api_response('success', 'Player Join Succesfuly dones', $player, 200);
                    } else {
                        return api_response('warning', 'You not registerd yet!!', null, 200);
                    }
                } else {
                    $tournament = Tournament::find($round->tournament_id);
                    if ($tournament->player_type == '4p') {
                        $user = Auth::user()->id;
                        $player = Playerinboard::where('status', '!=', 2)->where('round_id', $request->round_id)
                            ->where(function ($query) use ($user) {
                                $query->where('player_one', $user)
                                    ->orWhere('player_two', $user)
                                    ->orWhere('player_three', $user)
                                    ->orWhere('player_four', $user);
                            })
                            ->first();
                        if (!empty($player)) {
                            $board_data = Roundludoboard::find($player->board_id);
                            if ($board_data->board == null) {
                                $new_board = $board_data->update([
                                    'board' => $request->room_id,
                                ]);
                            }
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Player Join Succesfuly dones', $player, 200);
                        } else {
                            return api_response('warning', 'You not registerd yet!!', null, 200);
                        }

                    } elseif ($tournament->player_type == '2p') {
                        $user = Auth::user()->id;

                        $player = Playerinboard::where('status', '!=', 2)->where('round_id', $request->round_id)
                            ->where(function ($query) use ($user) {
                                $query->where('player_one', $user)
                                    ->orWhere('player_two', $user);
                            })
                            ->first();

                        if (!empty($player)) {
                            $board_data = Roundludoboard::find($player->board_id);
                            if ($board_data->board == null) {
                                $new_board = $board_data->update([
                                    'board' => $request->room_id,
                                ]);
                            }

                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Player Join Succesfuly dones', $player, 200);
                        } else {
                            return api_response('warning', 'You not registerd yet!!', null, 200);
                        }
                    }
                }
            } else {
                DB::commit();
                return api_response('success', 'No Round Found of this game', 200);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }
//    This function for join round of game end

//    This function for join round of game start
    public function round_join_old(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'game_id' => 'required|numeric',
            'round_id' => 'required|numeric',
            'room_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            $round = Gameround::find($request->round_id);
            if (!empty($round)) {
                if ($round->round_no == 'final') {
                    $board = Roundludoboard::where('round_id', $round->id)->where('status', 0)->first();
                    if (empty($board)) {
                        $new_board = Roundludoboard::create([
                            'tournament_id' => $request->tournament_id,
                            'game_id' => $request->game_id,
                            'round_id' => $round->id,
                            'board' => $request->room_id,
                            'status' => 0,
                        ]);
                        $player = Playerinboard::create([
                            'tournament_id' => $request->tournament_id,
                            'game_id' => $request->game_id,
                            'round_id' => $round->id,
                            'board_id' => $new_board->id,
                            'player_one' => Auth::user()->id,
                            'status' => 0,
                        ]);
                        // this function is used for use diamond
                        $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);

                        DB::commit();
                        $player = new Roundjoindeatils($player);
                        return api_response('success', 'First Player Join', $player, 200);
                    } elseif (($board) && (Playerinboard::where('board_id', $board->id)->first()->player_one == Auth::user()->id)) {
                        $player = Playerinboard::where('board_id', $board->id)->first();
                        $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                        $player = new Roundjoindeatils($player);
                        return api_response('success', 'First Player Already Join', $player, 200);
                    } else {
                        $player = Playerinboard::where('board_id', $board->id)->first();
//                       dd($player);
                        $player->tournament_id = $request->tournament_id;
                        $player->game_id = $request->game_id;
                        $player->round_id = $round->id;
                        $player->board_id = $board->id;
                        $player->status = 0;

                        if (($player->player_one != null) && ($player->player_one != Auth::user()->id) && ($player->player_two == null)) {
                            $player->player_two = Auth::user()->id;
                            $player->save();
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Second Player Join', $player, 200);
                        } elseif (($player->player_one != null) && ($player->player_one != Auth::user()->id) && ($player->player_two == Auth::user()->id)) {
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Second Player Already Join', $player, 200);
                        }
                        if (($player->player_two != null) && ($player->player_two != Auth::user()->id) && ($player->player_three == null)) {
                            $player->player_three = Auth::user()->id;
                            $player->save();
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Third Player Join', $player, 200);
                        } elseif (($player->player_two != null) && ($player->player_two != Auth::user()->id) && ($player->player_three == Auth::user()->id)) {
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Third Player Already Join', $player, 200);
                        }
                        if (($player->player_three != null) && ($player->player_three != Auth::user()->id) && ($player->player_four == null)) {
                            $player->player_four = Auth::user()->id;
                            $player->save();
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Fourth Player Join', $player, 200);
                        } elseif (($player->player_three != null) && ($player->player_three != Auth::user()->id) && ($player->player_four == Auth::user()->id)) {
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'Fourth Player Already Join', $player, 200);
                        }
                    }
                } else {
                    $tournament = Tournament::find($round->tournament_id);
                    if ($tournament->player_type == '4p') {
                        $board = Roundludoboard::where('round_id', $round->id)->where('status', 0)->first();
                        if (empty($board)) {
                            $new_board = Roundludoboard::create([
                                'tournament_id' => $request->tournament_id,
                                'game_id' => $request->game_id,
                                'round_id' => $round->id,
                                'board' => $request->room_id,
                                'status' => 0,
                            ]);
                            $player = Playerinboard::create([
                                'tournament_id' => $request->tournament_id,
                                'game_id' => $request->game_id,
                                'round_id' => $round->id,
                                'board_id' => $new_board->id,
                                'player_one' => Auth::user()->id,
                                'status' => 0,
                            ]);
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'First Player Join', $player, 200);
                        } elseif (($board) && (Playerinboard::where('board_id', $board->id)->first()->player_one == Auth::user()->id)) {
                            $player = Playerinboard::where('board_id', $board->id)->first();
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'First Player Already Join', $player, 200);
                        } else {
                            $player = Playerinboard::where('round_id', $round->id)->where('board_id', $board->id)->first();
                            if (($player->player_one != null) && ($player->player_one != Auth::user()->id) && ($player->player_two == null)) {
                                $player->tournament_id = $request->tournament_id;
                                $player->game_id = $request->game_id;
                                $player->round_id = $round->id;
                                $player->board_id = $board->id;
                                $player->status = 0;
                                $player->player_two = Auth::user()->id;
                                $player->save();
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                DB::commit();
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Second Player Join', $player, 200);
                            } elseif (($player->player_one != null) && ($player->player_one != Auth::user()->id) && ($player->player_two == Auth::user()->id)) {
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);

                                $player = new Roundjoindeatils($player);

                                return api_response('success', 'Second Player Already Join', $player, 200);
                            }
                            if (($player->player_two != null) && ($player->player_two != Auth::user()->id) && ($player->player_three == null)) {
                                $player->tournament_id = $request->tournament_id;
                                $player->game_id = $request->game_id;
                                $player->round_id = $round->id;
                                $player->board_id = $board->id;
                                $player->status = 0;
                                $player->player_three = Auth::user()->id;
                                $player->save();
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                DB::commit();
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Third Player Join', $player, 200);
                            } elseif (($player->player_two != null) && ($player->player_two != Auth::user()->id) && ($player->player_three == Auth::user()->id)) {
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Third Player Already Join', $player, 200);
                            }
                            if (($player->player_three != null) && ($player->player_three != Auth::user()->id) && ($player->player_four == null)) {
                                $player->tournament_id = $request->tournament_id;
                                $player->game_id = $request->game_id;
                                $player->round_id = $round->id;
                                $player->board_id = $board->id;
                                $player->status = 0;
                                $player->player_four = Auth::user()->id;
                                $player->save();
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                Roundludoboard::find($board->id)->update(['status' => 3]);
                                DB::commit();
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Fourth Player Join', $player, 200);
                            } elseif (($player->player_three != null) && ($player->player_three != Auth::user()->id) && ($player->player_four == Auth::user()->id)) {
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Fourth Player Already Join', $player, 200);
                            }
                        }
                    } elseif ($tournament->player_type == '2p') {
                        $board = Roundludoboard::where('round_id', $round->id)->where('status', 0)->first();
                        if (empty($board)) {
                            $new_board = Roundludoboard::create([
                                'tournament_id' => $request->tournament_id,
                                'game_id' => $request->game_id,
                                'round_id' => $round->id,
                                'board' => $request->room_id,
                                'status' => 0,
                            ]);
                            $player = Playerinboard::create([
                                'tournament_id' => $request->tournament_id,
                                'game_id' => $request->game_id,
                                'round_id' => $round->id,
                                'board_id' => $new_board->id,
                                'player_one' => Auth::user()->id,
                                'status' => 0,
                            ]);
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            DB::commit();
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'First Player Join', $player, 200);
                        } elseif (($board) && (Playerinboard::where('board_id', $board->id)->first()->player_one == Auth::user()->id)) {
                            $player = Playerinboard::where('board_id', $board->id)->first();
                            $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                            $player = new Roundjoindeatils($player);
                            return api_response('success', 'First Player Already Join', $player, 200);
                        } else {
                            $player = Playerinboard::where('round_id', $round->id)->where('board_id', $board->id)->first();
                            if (($player->player_one != null) && ($player->player_one != Auth::user()->id)) {
                                $player->tournament_id = $request->tournament_id;
                                $player->game_id = $request->game_id;
                                $player->round_id = $round->id;
                                $player->board_id = $board->id;
                                $player->status = 0;
                                $player->player_two = Auth::user()->id;
                                $player->save();
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                Roundludoboard::find($board->id)->update(['status' => 3]);
                                DB::commit();
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Second Player Join', $player, 200);
                            } elseif (($player->player_one != null) && ($player->player_one != Auth::user()->id) && ($player->player_two == Auth::user()->id)) {
                                $player = round_diamond($player, $request->tournament_id, $round->round_no, $request->game_id, $round->id);
                                $player = new Roundjoindeatils($player);
                                return api_response('success', 'Second Player Already Join', $player, 200);
                            }
                        }
                    }
                }
            } else {
                DB::commit();
                return api_response('success', 'No Round Found of this game', 200);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }
//    This function for join round of game end



//bidded player api function  start
    public function bided_to_player(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'board_id' => 'required|numeric',
            'bided_to' => 'required|numeric',
            'bid_amount' => 'required',
        ]);
        $this->coin = $request->bid_amount;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            if ($request->bid_amount > setting()->max_bidding_amount) {
                return api_response('warning', 'maximum Limit Exceed. Limit is  ' . setting()->max_bidding_amount, 200);
            } elseif ($request->bid_amount < setting()->min_bidding_amount) {
                return api_response('warning', 'You need to bid Minimum amount ' . setting()->min_bidding_amount, 200);
            } else {
                if (Auth::user()->paid_coin >= $request->bid_amount) {
                    $board = Roundludoboard::find($request->board_id);
                    $already_bid = Biding_details::where('userid', Auth::user()->id)->where('tournament_id', $board->tournament_id)->where('game_id', $board->game_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->first();
                    if (empty($already_bid)) {
                        $bided_user = Biding_details::create([
                            'userid' => Auth::user()->id,
                            'tournament_id' => $board->tournament_id,
                            'game_id' => $board->game_id,
                            'round_id' => $board->round_id,
                            'board_id' => $board->id,
                            'bided_to' => $request->bided_to,
                            'bid_amount' => $request->bid_amount,
                            'status' => 0,
                        ]);
                        $user = Auth::user();
                        $user->paid_coin = $user->paid_coin - $request->bid_amount;
                        $update_user = $user->save();
                        DB::commit();
                        if ($update_user) {
                            $type = RANK_COMMISSION_COLUMN[2];
                            $this->auth_user = auth()->user();
                            $this->rank_commission_distribution(auth()->user(), $type);
                            share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['bidding'], $this->coin);

                        }
                        return api_response('success', 'Bidding successfully Completed!', $bided_user, 200);
                    } else {
                        return api_response('warning', 'You already Bidded this Board', 200);
                    }
                } else {
                    return api_response('warning', 'You Didnot have enough Coin!', 200);
                }
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }
//bidded player api function  end
// Diamond Use api start
    public function diamond_use(Request $request)
    {
        //    return dd($request->all());
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'game_id' => 'required|numeric',
            'round_id' => 'required|numeric',
        ]);
        $this->coin = setting()->use_diamond;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $tournament = Tournament::find($request->tournament_id);
            $used_diamond = DiamondUseHistory::where('user_id', Auth::user()->id)->where('tournament_id', $tournament->id)->sum('used_diamond');
            if ($tournament->diamond_limit > $used_diamond) {
                $gameround = Gameround::where('tournament_id', $tournament->id)->where('id', $request->round_id)->where('game_id', $request->game_id)->first();
                $round_diamond_limit = RoundSettings::where('tournament_id', $tournament->id)->where('round_type', $gameround->round_no)->first();
                $used_diamond_in_round = DiamondUseHistory::where('user_id', Auth::user()->id)->where('tournament_id', $tournament->id)->where('game_id', $request->game_id)->where('round_id', $request->round_id)->sum('used_diamond');
                if ($round_diamond_limit->diamond_limit > $used_diamond_in_round) {
                    if (Auth::user()->paid_diamond > 0) {
                        DB::beginTransaction();
                        Auth::user()->decrement('paid_diamond', 1);
                        // here rank commission
                        $type = RANK_COMMISSION_COLUMN[1];
                        $this->auth_user = auth()->user();
                        $this->rank_commission_distribution(auth()->user(), $type);
                        share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['diamond_use'], $this->coin);

                        if (Auth::user()->vip_member == 0) {
                            Auth::user()->increment('vip_member', 1);
                            Auth::user()->update([
                                'rank_id' => Rank::where('priority', 1)->first()->id,
                                'next_rank_id' => Rank::where('priority', 2)->first()->id
                            ]);

                            campaign_history(User::find(auth()->user()->id), CAMPAIGN_TYPE[3]);

                            RankUpdateHistory::create([
                                'user_id' => Auth::user()->id,
                                'previous_rank_id' => Rank::where('priority', 0)->first()->id,
                                'current_rank_id' => Rank::where('priority', 1)->first()->id,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                        DiamondUseHistory::create([
                            'user_id' => Auth::user()->id,
                            'used_diamond' => 1,
                            'type' => 'game',
                            'tournament_id' => $request->tournament_id,
                            'game_id' => $request->game_id,
                            'round_id' => $request->round_id,
                            'note' => null,
                        ]);

                        DB::commit();
                        return api_response('success', 'Diamond Updated Successfully.', null, Response::HTTP_OK);

                    } else {
                        return api_response('success', 'You dont have a paid Diamond. Please Buy at first!', null, Response::HTTP_OK);
                    }
                } else {
                    return api_response('success', 'Diamond use limit of this round exceed!.', null, Response::HTTP_OK);
                }

            } else {
                return api_response('success', 'Diamond use limit of this tournament exceed!.', null, Response::HTTP_OK);
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            $ex->getMessage();
        }
    }

//    Diamond use api end

    public function round_diamond_use(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|numeric',
            'game_id' => 'required|numeric',
            'round_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            $use_diamond = Diamond_uses::where('tournament_id', $request->tournament_id)->where('game_id', $request->game_id)->where('round_id', $request->round_id)->where('userid', Auth::user()->id)->first();
            if ($use_diamond != null) {
                $use_diamond += 1;
                $use_diamond->save();
                $user = Auth::user();
                $user->update([
                    'paid_diamond' => $user->paid_diamond - 1,
                ]);
                // here is the commission functionality start
                // here is the commission functionality end
                DB::commit();
                return api_response('success', 'Diamond update', $use_diamond, 200);
            } else {
                $use_diamond = Diamond_uses::create([
                    'tournament_id' => $request->tournament_id,
                    'game_id' => $request->game_id,
                    'round_id' => $request->round_id,
                    'userid' => Auth::user()->id,
                    'diamond_use' => 1,
                ]);
                $user = Auth::user();
                $user->update([
                    'paid_diamond' => $user->paid_diamond - 1,
                ]);
                // here is the commission functionality start
                // here is the commission functionality end
                DB::commit();
                return api_response('success', 'Diamond update', $use_diamond, 200);
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }

//    This function for entry game  start
    public function game_entry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {

            $player_game = Playerenroll::where('tournament_id', $request->tournament_id)->where('user_id', Auth::user()->id)->first();
            if ($player_game != null) {
                $game_data = Game::where('id', $player_game->game_id)->with('tournament', 'allrounds')->first();
                $game_data = new GamedataResource($game_data);
                if ($game_data != null) {
                    return api_response('success', 'Details of this tournament which you select.', $game_data, 200);
                } else {
                    return api_response('warning', 'No game Found', 200);
                }

            } else {
                return api_response('warning', 'You are not enrolled', 200);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }

//    This function for entry game  end

    public function bidding_refund(Request $request)
    {
        $request->validate([
            'board_id' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $board = Roundludoboard::find($request->board_id);
            $tournament = Tournament::find($board->tournament_id);
            if ($board != null) {
                $bidding_details = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->get()->groupBy('bided_to');
                if (count($bidding_details) > 0) {
                    if (count($bidding_details) > 1) {
                        $player_in_board = Playerinboard::where('board_id', $board->id)->first();
                        if ($player_in_board != null) {
                            $bidding_details_winner = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('userid', Auth::user()->id)->first();
                            if ($bidding_details_winner->bided_to == $player_in_board->player_one) {
                                $other_bidder = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_one)->get();
                                if (count($other_bidder) > 0) {
                                    $bidding_details_winner_amount = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', $player_in_board->player_one)->sum('bid_amount');
                                    $other_bidder_looser_coin = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_one)->sum('bid_amount');
                                    $result = setting()->bidder_commission / 100;
                                    $output = $other_bidder_looser_coin * $result;
                                    $module = $output / $bidding_details_winner_amount;
                                    $module = number_format((float)$module, 2, '.', '');
                                    $coin = ($bidding_details_winner->bid_amount * $module) + $bidding_details_winner->bid_amount;
                                    return api_response('success', 'If Your Bidding player win then you will get ' . $coin . ' coin.', null, 200);

                                } else {
                                    $bidding_details_looser = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_one)->get();
                                    foreach ($bidding_details_looser as $data) {
                                        $user = User::find($data->userid);
                                        $user->update([
                                            'paid_coin' => $user->paid_coin += $data->bid_amount,
                                        ]);
                                        $data->status = 1;
                                        $data->save();
                                    }
                                    return api_response('success', 'Refunded.');
                                }


                            } elseif ($bidding_details_winner->bided_to == $player_in_board->player_two) {
                                $other_bidder = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_two)->get();
                                if (count($other_bidder) > 0) {
                                    $bidding_details_winner_amount = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', $player_in_board->player_two)->sum('bid_amount');
                                    $other_bidder_looser_coin = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_two)->sum('bid_amount');
                                    $result = setting()->bidder_commission / 100;
                                    $output = $other_bidder_looser_coin * $result;
                                    $module = $output / $bidding_details_winner_amount;
                                    $module = number_format((float)$module, 2, '.', '');
                                    $coin = ($bidding_details_winner->bid_amount * $module) + $bidding_details_winner->bid_amount;
                                    return api_response('success', 'If Your Bidding player win then you will get ' . $coin . ' coin.', null, 200);
                                } else {
                                    $bidding_details_looser = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_two)->get();
                                    foreach ($bidding_details_looser as $data) {
                                        $user = User::find($data->userid);
                                        $user->update([
                                            'paid_coin' => $user->paid_coin += $data->bid_amount,
                                        ]);
                                        $data->status = 1;
                                        $data->save();
                                    }
                                    return api_response('success', 'Refunded.');
                                }

                            } elseif ($bidding_details_winner->bided_to == $player_in_board->player_three) {
                                $other_bidder = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_three)->get();
                                if (count($other_bidder) > 0) {
                                    $bidding_details_winner_amount = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', $player_in_board->player_three)->sum('bid_amount');
                                    $other_bidder_looser_coin = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_three)->sum('bid_amount');
                                    $result = setting()->bidder_commission / 100;
                                    $output = $other_bidder_looser_coin * $result;
                                    $module = $output / $bidding_details_winner_amount;
                                    $module = number_format((float)$module, 2, '.', '');
                                    $coin = ($bidding_details_winner->bid_amount * $module) + $bidding_details_winner->bid_amount;
                                    return api_response('success', 'If Your Bidding player win then you will get ' . $coin . ' coin.', null, 200);
                                } else {
                                    $bidding_details_looser = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_three)->get();
                                    foreach ($bidding_details_looser as $data) {
                                        $user = User::find($data->userid);
                                        $user->update([
                                            'paid_coin' => $user->paid_coin += $data->bid_amount,
                                        ]);
                                        $data->status = 1;
                                        $data->save();
                                    }
                                    return api_response('success', 'Refunded.');
                                }

                            } elseif ($bidding_details_winner->bided_to == $player_in_board->player_four) {
                                $other_bidder = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_three)->get();
                                if (count($other_bidder) > 0) {
                                    $bidding_details_winner_amount = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', $player_in_board->player_three)->sum('bid_amount');
                                    $other_bidder_looser_coin = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_three)->sum('bid_amount');
                                    $result = setting()->bidder_commission / 100;
                                    $output = $other_bidder_looser_coin * $result;
                                    $module = $output / $bidding_details_winner_amount;
                                    $module = number_format((float)$module, 2, '.', '');
                                    $coin = ($bidding_details_winner->bid_amount * $module) + $bidding_details_winner->bid_amount;
                                    return api_response('success', 'If Your Bidding player win then you will get ' . $coin . ' coin.', null, 200);
                                } else {
                                    $bidding_details_looser = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->where('bided_to', '!=', $player_in_board->player_three)->get();
                                    foreach ($bidding_details_looser as $data) {
                                        $user = User::find($data->userid);
                                        $user->update([
                                            'paid_coin' => $user->paid_coin += $data->bid_amount,
                                        ]);
                                        $data->status = 1;
                                        $data->save();
                                    }
                                    return api_response('success', 'Refunded.');
                                }
                            }

                        } else {
                            return api_response('success', 'Board Not found.');
                        }
                    } else {
                        $bidding_details_looser = Biding_details::where('tournament_id', $board->tournament_id)->where('round_id', $board->round_id)->where('board_id', $board->id)->get();
                        foreach ($bidding_details_looser as $data) {
                            $user = User::find($data->userid);
                            $user->update([
                                'paid_coin' => $user->paid_coin + $data->bid_amount,
                            ]);
                            $data->status = 1;
                            $data->save();
                        }
                        return api_response('success', 'Refunded.');
                    }
                } else {
                    return api_response('Warning', 'No Bidding Found.');
                }
            } else {
                return api_response('success', 'Board Not Found.');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
        }
    }

    public function start_game(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            $user = Auth::user()->id;
            $board = Roundludoboard::where('board', $request->room_id)->first();
            if ($board->round->round_no == 'final') {
                $playerinboard = Playerinboard::where('board_id', $board->id)
                    ->where(function ($query) use ($user) {
                        $query->where('player_one', $user)
                            ->orWhere('player_two', $user)
                            ->orWhere('player_three', $user)
                            ->orWhere('player_four', $user);
                    })
                    ->first();
            } else {
                if ($board->tournament->player_type == '2p') {
                    $playerinboard = Playerinboard::where('board_id', $board->id)
                        ->where(function ($query) use ($user) {
                            $query->where('player_one', $user)
                                ->orWhere('player_two', $user);
                        })
                        ->first();

                } elseif ($board->tournament->player_type == '4p') {
                    $playerinboard = Playerinboard::where('board_id', $board->id)
                        ->where(function ($query) use ($user) {
                            $query->where('player_one', $user)
                                ->orWhere('player_two', $user)
                                ->orWhere('player_three', $user)
                                ->orWhere('player_four', $user);
                        })
                        ->first();
                }
            }

            if ($playerinboard->status == 0) {
                $playerinboard->status = 1;
                $playerinboard->save();
                if ($playerinboard->board_name->status == 0) {
                    $board->status = 1;
                    $board->save();
                }

                if ($playerinboard->round->status == 0) {
                    Gameround::find($playerinboard->round_id)->update(['status' => 1]);
                }
                if ($playerinboard->game->status == 3) {
                    Game::find($playerinboard->game_id)->update(['status' => 1]);
                }
                return api_response('success', 'Game started', null, 200);
            } else {
                return api_response('warning', 'Already start', null, 200);
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
        }

    }

//    Tournament Game complete api start
    public function tournament_game_complete_old(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
            'first_winner' => 'nullable|numeric',
            'second_winner' => 'nullable|numeric',
            'third_winner' => 'nullable|numeric',
            'looser' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {

            $ludo_board = Roundludoboard::where('board', $request->room_id)->where('status', 1)->first();
            if ($ludo_board != null) {
                $tournament = Tournament::find($ludo_board->tournament_id);
                DB::beginTransaction();
                //     for final round of 4 player tournament  start
                $round_settings = RoundSettings::where('tournament_id', $ludo_board->tournament_id)->where('round_type', $ludo_board->round->round_no)->first();

                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->first();

                if ($ludo_board->round->round_no == 'final') {

                    if (($player->first_winner == null) && ($request->first_winner != null)) {

                        $player->first_winner = User::find($request->first_winner)->id;

                        $player->save();

                        $user = User::find($request->first_winner);

                        provide_winning_prize($tournament, $user, $round_settings->first_bonus_point);

                        if ($tournament->game_type == 1) {
                            $win_user = User::find($request->first_winner);
                            $this->coin = $round_settings->first_bonus_point;
                            $type = RANK_COMMISSION_COLUMN[4];
                            $this->auth_user = $win_user;
                            $this->rank_commission_distribution($win_user, $type);
                        }
                        //  game asset distribution function end here

                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {

                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $running_boards = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();

                            if (count($running_boards) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        bidding_result($ludo_board->id);
                        DB::commit();
                        return api_response('success', 'Congratulations, You are the winner!', $player, 200);
                    } elseif (($player->first_winner != null) && ($player->first_winner == $request->first_winner)) {
                        return api_response('success', 'You already declared as a first winner!.', $player, 200);
                    }
                    if (($player->second_winner == null) && ($request->second_winner != null)) {
                        $player->second_winner = User::find($request->second_winner)->id;
                        $player->save();
                        $user = User::find($request->second_winner);
                        provide_winning_prize($tournament, $user, $round_settings->second_bonus_point);

                        // Add game  asset distribution
                        if ($tournament->game_type == 1) {
                            $win_user = User::find($request->second_winner);
                            $this->coin = $round_settings->second_bonus_point;
                            $type = RANK_COMMISSION_COLUMN[4];
                            $this->auth_user = $win_user;
                            $this->rank_commission_distribution($win_user, $type);
                        }
                        // game asset distribution function start here

                        //  game asset distribution function end here
                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                            if (count($complete_board) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        DB::commit();
                        return api_response('success', 'Congratulations, You are the Second winner!', $player, 200);
                    } elseif (($player->second_winner != null) && ($player->second_winner == $request->second_winner)) {
                        return api_response('success', 'You already declared as a Second winner!.', $player, 200);
                    }
                    if (($player->third_winner == null) && ($request->third_winner != null)) {
                        $player->third_winner = User::find($request->third_winner)->id;
                        $player->save();
                        $user = User::find($request->third_winner);
                        provide_winning_prize($tournament, $user, $round_settings->third_bonus_point);

                        // game assets distribution
                        if ($tournament->game_type == 1) {
                            $win_user = User::find($request->third_winner);
                            $this->coin = $round_settings->third_bonus_point;
                            $type = RANK_COMMISSION_COLUMN[4];
                            $this->auth_user = $win_user;
                            $this->rank_commission_distribution($win_user, $type);
                        }

                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                            if (count($complete_board) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        DB::commit();
                        return api_response('success', 'Congratulations, You are the Third winner!', $player, 200);
                    } elseif (($player->third_winner != null) && ($player->third_winner == $request->third_winner)) {
                        return api_response('success', 'You already declared as a Third winner!.', $player, 200);
                    }
                    if (($player->fourth_winner == null) && ($request->looser != null)) {
                        $player->fourth_winner = User::find($request->looser)->id;
                        $player->save();
                        $user = User::find($request->looser);
                        $user->win_balance += $round_settings->fourth_bonus_point;
                        $user->save();
                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                            if (count($complete_board) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        DB::commit();
                        return api_response('success', 'Opps, You loose the game!', $player, 200);
                    } elseif (($player->fourth_winner != null) && ($player->fourth_winner == $request->looser)) {
                        return api_response('success', 'You already declared as a looser!.', $player, 200);
                    }

                } else {
                    // for 4p game round start
                    if ($ludo_board->tournament->player_type == '4p') {
                        if (($player->first_winner == null) && ($request->first_winner != null)) {
                            $player->first_winner = User::find($request->first_winner)->id;
                            $player->save();
                            $user = User::find($request->first_winner);
                            $user->win_balance += $round_settings->first_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {
                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }

                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            bidding_result($ludo_board->id);
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the winner!', $player, 200);
                        }
                        if (($player->second_winner == null) && ($request->second_winner != null)) {
                            $player->second_winner = User::find($request->second_winner)->id;
                            $player->save();
                            $user = User::find($request->second_winner);
                            $user->win_balance += $round_settings->second_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the Second winner!', $player, 200);
                        }
                        if (($player->third_winner == null) && ($request->third_winner != null)) {
                            $player->third_winner = User::find($request->third_winner)->id;
                            $player->save();
                            $user = User::find($request->third_winner);
                            $user->win_balance += $round_settings->third_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the Third winner!', $player, 200);
                        }
                        if (($player->fourth_winner == null) && ($request->looser != null)) {
                            $player->fourth_winner = User::find($request->looser)->id;
                            $player->save();
                            $user = User::find($request->looser);
                            $user->win_balance += $round_settings->fourth_bonus_point;
                            $user->save();
                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Opps, You loose the game!', $player, 200);
                        }
                    } elseif ($ludo_board->tournament->player_type == '2p') {
                        if (($player->first_winner == null) && ($request->first_winner != null)) {
                            $player->first_winner = User::find($request->first_winner)->id;
                            $player->save();
                            $user = User::find($request->first_winner);
                            $user->win_balance += $round_settings->fourth_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            bidding_result($ludo_board->id);
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the winner!', $player, 200);
                        }
                        if (($player->fourth_winner == null) && ($request->looser != null)) {
                            $player->fourth_winner = User::find($request->looser)->id;
                            $player->save();
                            $user = User::find($request->looser);
                            $user->win_balance += $round_settings->fourth_bonus_point;
                            $user->save();
                            if (($player->first_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Opps, You loose the game!', $player, 200);
                        }
                    }
                    //  for 2p player game round without  final end
                }
                //     for  game round without  final end

            } else {
                return api_response('warning', 'Game Not Found or Already Complete 1', 200);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }
//    Tournament Game complete api end


//    Tournament Game complete api start
    public function tournament_game_complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
            'first_winner' => 'nullable|numeric',
            'second_winner' => 'nullable|numeric',
            'third_winner' => 'nullable|numeric',
            'looser' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {

            $ludo_board = Roundludoboard::where('board', $request->room_id)->where('status', '!=', 2)->first();
            if ($ludo_board != null) {
                $tournament = Tournament::find($ludo_board->tournament_id);
                DB::beginTransaction();
                //     for final round of 4 player tournament  start
                $round_settings = RoundSettings::where('tournament_id', $ludo_board->tournament_id)->where('round_type', $ludo_board->round->round_no)->first();

                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->first();

                if ($ludo_board->round->round_no == 'final') {

                    if (($player->first_winner == null) && ($request->first_winner != null)) {

                        $player->first_winner = User::find($request->first_winner)->id;

                        $player->save();

                        $user = User::find($request->first_winner);

                        provide_winning_prize($tournament, $user, $round_settings->first_bonus_point);

                        if ($tournament->game_type == 1) {
                            $win_user = User::find($request->first_winner);
                            $this->coin = $round_settings->first_bonus_point;
                            $type = RANK_COMMISSION_COLUMN[4];
                            $this->auth_user = $win_user;
                            $this->rank_commission_distribution($win_user, $type);
                        }
                        //  game asset distribution function end here

                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {

                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $player->status = 2;
                            $player->save();
                            $running_boards = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();

                            if (count($running_boards) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        bidding_result($ludo_board->id);
                        DB::commit();
                        return api_response('success', 'Congratulations, You are the winner!', $player, 200);
                    } elseif (($player->first_winner != null) && ($player->first_winner == $request->first_winner)) {
                        return api_response('success', 'You already declared as a first winner!.', $player, 200);
                    }
                    if (($player->second_winner == null) && ($request->second_winner != null)) {
                        $player->second_winner = User::find($request->second_winner)->id;
                        $player->save();
                        $user = User::find($request->second_winner);
                        provide_winning_prize($tournament, $user, $round_settings->second_bonus_point);

                        // Add game  asset distribution
                        if ($tournament->game_type == 1) {
                            $win_user = User::find($request->second_winner);
                            $this->coin = $round_settings->second_bonus_point;
                            $type = RANK_COMMISSION_COLUMN[4];
                            $this->auth_user = $win_user;
                            $this->rank_commission_distribution($win_user, $type);
                        }
                        // game asset distribution function start here

                        //  game asset distribution function end here
                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $player->status = 2;
                            $player->save();
                            $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                            if (count($complete_board) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        DB::commit();
                        return api_response('success', 'Congratulations, You are the Second winner!', $player, 200);
                    } elseif (($player->second_winner != null) && ($player->second_winner == $request->second_winner)) {
                        return api_response('success', 'You already declared as a Second winner!.', $player, 200);
                    }
                    if (($player->third_winner == null) && ($request->third_winner != null)) {
                        $player->third_winner = User::find($request->third_winner)->id;
                        $player->save();
                        $user = User::find($request->third_winner);
                        provide_winning_prize($tournament, $user, $round_settings->third_bonus_point);

                        // game assets distribution
                        if ($tournament->game_type == 1) {
                            $win_user = User::find($request->third_winner);
                            $this->coin = $round_settings->third_bonus_point;
                            $type = RANK_COMMISSION_COLUMN[4];
                            $this->auth_user = $win_user;
                            $this->rank_commission_distribution($win_user, $type);
                        }

                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $player->status = 2;
                            $player->save();
                            $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                            if (count($complete_board) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        DB::commit();
                        return api_response('success', 'Congratulations, You are the Third winner!', $player, 200);
                    } elseif (($player->third_winner != null) && ($player->third_winner == $request->third_winner)) {
                        return api_response('success', 'You already declared as a Third winner!.', $player, 200);
                    }
                    if (($player->fourth_winner == null) && ($request->looser != null)) {
                        $player->fourth_winner = User::find($request->looser)->id;
                        $player->save();
                        $user = User::find($request->looser);
                        $user->win_balance += $round_settings->fourth_bonus_point;
                        $user->save();
                        if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                            $ludo_board->status = 2;
                            $ludo_board->save();
                            $player->status = 2;
                            $player->save();
                            $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                            if (count($complete_board) > 0) {

                            } else {
                                $round = Gameround::find($ludo_board->round_id)->update([
                                    'status' => 2,
                                    'round_end_time' => Carbon::now(),
                                ]);
                            }
                            $complete_game = Gameround::where('game_id', $ludo_board->game_id)->where('status', 1)->get();
                            if (count($complete_game) > 0) {

                            } else {
                                Game::find($ludo_board->game_id)->update(['status' => 2]);
                            }
                            $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                        }
                        DB::commit();
                        return api_response('success', 'Opps, You loose the game!', $player, 200);
                    } elseif (($player->fourth_winner != null) && ($player->fourth_winner == $request->looser)) {
                        return api_response('success', 'You already declared as a looser!.', $player, 200);
                    }

                } else {
                    // for 4p game round start
                    if ($ludo_board->tournament->player_type == '4p') {
                        if (($player->first_winner == null) && ($request->first_winner != null)) {
                            $player->first_winner = User::find($request->first_winner)->id;
                            $player->save();
                            $user = User::find($request->first_winner);
                            $user->win_balance += $round_settings->first_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $player->status = 2;
                                $player->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {
                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }

                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            bidding_result($ludo_board->id);
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the winner!', $player, 200);
                        }
                        if (($player->second_winner == null) && ($request->second_winner != null)) {
                            $player->second_winner = User::find($request->second_winner)->id;
                            $player->save();
                            $user = User::find($request->second_winner);
                            $user->win_balance += $round_settings->second_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $player->status = 2;
                                $player->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the Second winner!', $player, 200);
                        }
                        if (($player->third_winner == null) && ($request->third_winner != null)) {
                            $player->third_winner = User::find($request->third_winner)->id;
                            $player->save();
                            $user = User::find($request->third_winner);
                            $user->win_balance += $round_settings->third_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $player->status = 2;
                                $player->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the Third winner!', $player, 200);
                        }
                        if (($player->fourth_winner == null) && ($request->looser != null)) {
                            $player->fourth_winner = User::find($request->looser)->id;
                            $player->save();
                            $user = User::find($request->looser);
                            $user->win_balance += $round_settings->fourth_bonus_point;
                            $user->save();
                            if (($player->first_winner != null) && ($player->second_winner != null) && ($player->third_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $player->status = 2;
                                $player->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                    $round = Gameround::find($ludo_board->round_id);
                                    if ($round->round_no != 'final') {
                                        $tournament_data = Tournament::find($round->tournament_id);
                                        $next_round = Gameround::where('game_id', $round->game_id)->where('status', '!=', 2)->orderBy('round_no', 'asc')->first();
                                        $settings = RoundSettings::where('tournament_id', $round->tournament_id)->where('round_type', $next_round->round_no)->first();

                                        $players = Playerinboard::select('first_winner', 'second_winner')->where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->get();
                                        for ($i = 0; $i < $settings->board_quantity; $i++) {
                                            $new_board = Roundludoboard::create([
                                                'tournament_id' => $next_round->tournament_id,
                                                'game_id' => $next_round->game_id,
                                                'round_id' => $next_round->id,
                                                'board_number' => strtoupper(Str::random(6)),
                                                'status' => 0,
                                            ]);
                                            foreach ($players->chunk(2) as $datas) {
                                                $player = Playerinboard::create([
                                                    'tournament_id' => $new_board->tournament_id,
                                                    'game_id' => $next_round->game_id,
                                                    'round_id' => $next_round->id,
                                                    'board_id' => $new_board->id,
                                                    'player_one' => $datas[0]->first_winner,
                                                    'player_two' => $datas[0]->second_winner,
                                                    'player_three' => $datas[1]->first_winner,
                                                    'player_four' => $datas[1]->second_winner,
                                                    'status' => 0,
                                                ]);
                                            }
                                        }
                                        $round_settings = RoundSettings::where(['tournament_id' => $next_round->tournament_id, 'round_type' => $next_round->round_no])->first();
                                        $next_round->round_start_time = Carbon::parse($round->round_end_time)->addMinute($round_settings->time_gapping);
                                        $next_round->count_down = 1;
                                        $next_round->save();

                                    }
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            DB::commit();
                            return api_response('success', 'Opps, You loose the game!', $player, 200);
                        }
                    } elseif ($ludo_board->tournament->player_type == '2p') {
                        if (($player->first_winner == null) && ($request->first_winner != null)) {
                            $player->first_winner = User::find($request->first_winner)->id;
                            $player->save();
                            $user = User::find($request->first_winner);
                            $user->win_balance += $round_settings->fourth_bonus_point;
                            $user->save();

                            if (($player->first_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $player->status = 2;
                                $player->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    $round = Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                    $round = Gameround::find($ludo_board->round_id);
                                    if ($round->round_no != 'final') {
                                        $tournament_data = Tournament::find($round->tournament_id);
                                        $next_round = Gameround::where('game_id', $round->game_id)->where('status', '!=', 2)->orderBy('round_no', 'asc')->first();
                                        $settings = RoundSettings::where('tournament_id', $round->tournament_id)->where('round_type', $next_round->round_no)->first();

                                        $players = Playerinboard::select('first_winner', 'second_winner')->where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->get();
                                        for ($i = 0; $i < $settings->board_quantity; $i++) {
                                            $new_board = Roundludoboard::create([
                                                'tournament_id' => $next_round->tournament_id,
                                                'game_id' => $next_round->game_id,
                                                'round_id' => $next_round->id,
                                                'board_number' => strtoupper(Str::random(6)),
                                                'status' => 0,
                                            ]);


                                            if ($next_round->round_no == 'final') {
                                                foreach ($players->chunk(4) as $datas) {
                                                    $player = Playerinboard::create([
                                                        'tournament_id' => $new_board->tournament_id,
                                                        'game_id' => $next_round->game_id,
                                                        'round_id' => $next_round->id,
                                                        'board_id' => $new_board->id,
                                                        'player_one' => $datas[0]->first_winner,
                                                        'player_two' => $datas[1]->first_winner,
                                                        'player_three' => $datas[2]->first_winner,
                                                        'player_four' => $datas[3]->first_winner,
                                                        'status' => 0,
                                                    ]);
                                                }
                                            } else {
                                                foreach ($players->chunk(2) as $datas) {
                                                    $player = Playerinboard::create([
                                                        'tournament_id' => $new_board->tournament_id,
                                                        'game_id' => $next_round->game_id,
                                                        'round_id' => $next_round->id,
                                                        'board_id' => $new_board->id,
                                                        'player_one' => $datas[0]->first_winner,
                                                        'player_two' => $datas[1]->first_winner,
                                                        'status' => 0,
                                                    ]);
                                                }
                                            }
                                        }
                                        $round_settings = RoundSettings::where(['tournament_id' => $next_round->tournament_id, 'round_type' => $next_round->round_no])->first();
                                        $next_round->round_start_time = Carbon::parse($round->round_end_time)->addMinute($round_settings->time_gapping);
                                        $next_round->count_down = 1;
                                        $next_round->save();

                                    }
                                }
                                $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                            }
                            bidding_result($ludo_board->id);
                            DB::commit();
                            return api_response('success', 'Congratulations, You are the winner!', $player, 200);
                        }
                        if (($player->fourth_winner == null) && ($request->looser != null)) {
                            $player->fourth_winner = User::find($request->looser)->id;
                            $player->save();
                            $user = User::find($request->looser);
                            $user->win_balance += $round_settings->fourth_bonus_point;
                            $user->save();
                            if (($player->first_winner != null) && ($player->fourth_winner != null)) {
                                $ludo_board->status = 2;
                                $ludo_board->save();
                                $player->status = 2;
                                $player->save();
                                $complete_board = Roundludoboard::where('round_id', $ludo_board->round_id)->where('status', 1)->get();
                                if (count($complete_board) > 0) {

                                } else {
                                    Gameround::find($ludo_board->round_id)->update([
                                        'status' => 2,
                                        'round_end_time' => Carbon::now(),
                                    ]);
                                    $round = Gameround::find($ludo_board->round_id);
                                    if ($round->round_no != 'final') {
                                        $tournament_data = Tournament::find($round->tournament_id);
                                        $next_round = Gameround::where('game_id', $round->game_id)->where('status', '!=', 2)->orderBy('round_no', 'asc')->first();
                                        $settings = RoundSettings::where('tournament_id', $round->tournament_id)->where('round_type', $next_round->round_no)->first();

                                        $players = Playerinboard::select('first_winner', 'second_winner')->where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->get();
                                        for ($i = 0; $i < $settings->board_quantity; $i++) {
                                            $new_board = Roundludoboard::create([
                                                'tournament_id' => $next_round->tournament_id,
                                                'game_id' => $next_round->game_id,
                                                'round_id' => $next_round->id,
                                                'board_number' => strtoupper(Str::random(6)),
                                                'status' => 0,
                                            ]);


                                            if ($next_round->round_no == 'final') {
                                                foreach ($players->chunk(4) as $datas) {
                                                    $player = Playerinboard::create([
                                                        'tournament_id' => $new_board->tournament_id,
                                                        'game_id' => $next_round->game_id,
                                                        'round_id' => $next_round->id,
                                                        'board_id' => $new_board->id,
                                                        'player_one' => $datas[0]->first_winner,
                                                        'player_two' => $datas[1]->first_winner,
                                                        'player_three' => $datas[2]->first_winner,
                                                        'player_four' => $datas[3]->first_winner,
                                                        'status' => 0,
                                                    ]);
                                                }
                                            } else {
                                                foreach ($players->chunk(2) as $datas) {
                                                    $player = Playerinboard::create([
                                                        'tournament_id' => $new_board->tournament_id,
                                                        'game_id' => $next_round->game_id,
                                                        'round_id' => $next_round->id,
                                                        'board_id' => $new_board->id,
                                                        'player_one' => $datas[0]->first_winner,
                                                        'player_two' => $datas[1]->first_winner,
                                                        'status' => 0,
                                                    ]);
                                                }
                                            }
                                        }
                                        $round_settings = RoundSettings::where(['tournament_id' => $next_round->tournament_id, 'round_type' => $next_round->round_no])->first();
                                        $next_round->round_start_time = Carbon::parse($round->round_end_time)->addMinute($round_settings->time_gapping);
                                        $next_round->count_down = 1;
                                        $next_round->save();

                                    }
                                    $player = Playerinboard::where('tournament_id', $ludo_board->tournament_id)->where('game_id', $ludo_board->game_id)->where('round_id', $ludo_board->round_id)->where('board_id', $ludo_board->id)->update(['status' => 2]);
                                }
                                DB::commit();
                                return api_response('success', 'Opps, You loose the game!', $player, 200);
                            }
                        }
                        //  for 2p player game round without  final end
                    }
                    //     for  game round without  final end

                }
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }
//    Tournament Game complete api end


//  here is the function where we got all tournament data and its start of this function
    public function all_tournament(Request $request)
    {
        if ($request->game_sub_type != null) {
            $tournaments = Tournament::where('game_type', $request->game_type)->where('game_sub_type', $request->game_sub_type)->where('status', 1)->latest()->get();
            $tournaments = TournamentResource::collection($tournaments);
            if (count($tournaments) > 0) {
                return api_response('success', 'All tournament of this game type', $tournaments, 200);
            } else {
                return api_response('warning', 'No tournament Found', 'nothing Found', 200);
            }
        } else {
            $tournaments = Tournament::where('game_type', $request->game_type)->where('status', 1)->latest()->get();
            $tournaments = TournamentResource::collection($tournaments);
            if (count($tournaments) > 0) {
                return api_response('success', 'All tournament of this game type', $tournaments, 200);
            } else {
                return api_response('warning', 'No tournament Found', 'nothing Found', 200);
            }
        }
    }


    // bidding list in board
    public function bidding_list($id)
    {
        $board_data = Roundludoboard::find($id);
        $bidding_lists = Biding_details::where('board_id', $id)->latest()->get();
        return view('webend.bidding_list', compact('bidding_lists', 'board_data'));
    }

//    below code are comment out because here we write down main code of bidding refund and commission distribution

    public function rank_commission_distribution($user, $type)
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
                    $this->rank_commission_distribution($parent, $type);
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
                    $this->rank_commission_distribution($parent_one, $type);
                } else {
                    //echo "no parent 2";
                }
            }
        }
    }

}


