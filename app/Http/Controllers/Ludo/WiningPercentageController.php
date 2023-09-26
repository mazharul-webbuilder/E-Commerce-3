<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Models\Free2pgame;
use App\Models\Free3pgame;
use App\Models\Free4playergame;
use App\Models\UserDeviceTrack;
use App\Models\UserDevuceTrack;
use App\Models\WinningPercentage;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\QueryException as DatabaseQueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class WiningPercentageController extends Controller
{


    const GAME_TYPE = ['2p', '3p', '4p'];

    public function store_wining_percentage(Request $request)
    {
       // return auth()->user()->id;

        if ($request->isMethod("post")) {
            try {
                DB::beginTransaction();
                if ($request->game_type == self::GAME_TYPE[0]) {

                    $wining_percentage = WinningPercentage::query()
                        ->where('game_type', self::GAME_TYPE[0])
                        ->where('player_id', $request->player_id)
                        ->where('free2pgame_id', $request->free2pgame_id)->first();
                    if (empty($wining_percentage)) {

                        WinningPercentage::create([
                            'free2pgame_id' => $request->free2pgame_id,
                            'player_id' => $request->player_id,
                            'room_number' => $request->room_number,
                            'game_type' => self::GAME_TYPE['0'],
                            'wining_percentage' => $request->wining_percentage
                        ]);
                    } else {
                        $wining_percentage->update(['wining_percentage' => $request->wining_percentage]);
                    }
                    DB::commit();
                    return response()->json([
                        'message' => 'Successfully updated',
                        'type' => 'success',
                        'status' => Response::HTTP_OK
                    ], Response::HTTP_OK);
                } elseif ($request->game_type == self::GAME_TYPE[1]) {

                    $wining_percentage = WinningPercentage::query()
                        ->where('game_type', self::GAME_TYPE[1])
                        ->where('player_id', $request->player_id)
                        ->where('free3pgame_id', $request->free3pgame_id)->first();

                    if (empty($wining_percentage)) {

                        WinningPercentage::create([
                            'free3pgame_id' => $request->free3pgame_id,
                            'player_id' => $request->player_id,
                            'room_number' => $request->room_number,
                            'game_type' => self::GAME_TYPE[1],
                            'wining_percentage' => $request->wining_percentage
                        ]);
                    } else {
                        $wining_percentage->update(['wining_percentage' => $request->wining_percentage]);
                    }
                    DB::commit();
                    return response()->json([
                        'message' => 'Successfully updated',
                        'type' => 'success',
                        'status' => Response::HTTP_OK
                    ], Response::HTTP_OK);
                } elseif ($request->game_type == self::GAME_TYPE[2]) {

                    $wining_percentage = WinningPercentage::query()
                        ->where('game_type', self::GAME_TYPE[2])
                        ->where('player_id', $request->player_id)
                        ->where('free4pgame_id', $request->free4pgame_id)->first();

                    if (empty($wining_percentage)) {

                        WinningPercentage::create([
                            'free4pgame_id' => $request->free4pgame_id,
                            'player_id' => $request->player_id,
                            'room_number' => $request->room_number,
                            'game_type' => self::GAME_TYPE[2],
                            'wining_percentage' => $request->wining_percentage
                        ]);
                    } else {
                        $wining_percentage->update(['wining_percentage' => $request->wining_percentage]);
                    }

                    DB::commit();
                    return response()->json([
                        'message' => 'Successfully updated',
                        'type' => 'success',
                        'status' => Response::HTTP_OK
                    ], Response::HTTP_OK);
                }
            } catch (QueryException $exception) {
                return response()->json([
                    'message' => $exception->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function get_wining_percentage()
    {
    }

    public function user_device_track(Request $request)
    {
        if ($request->isMethod("POST")) {
            try {
                $user = auth()->user();
                $checker = UserDeviceTrack::where(["user_id" => $user->id, 'room_code' => $request->room_code])->first();
                if (is_null($checker)) {
                    UserDeviceTrack::create([
                        'user_id' => $user->id,
                        'room_code' => $request->room_code,
                        'device_number' => $request->device_number
                    ]);
                    return response()->json([
                        'message' => 'Successfuly inserted',
                        'type' => 'success',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'message' => 'Your already exist in this room',
                        'type' => 'warning',
                        'status' => Response::HTTP_BAD_REQUEST,
                    ], Response::HTTP_OK);
                }
            } catch (QueryException $th) {
                return response()->json([
                    'message' => $th,
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function show_user_device_track($room_code, $device_number)
    {
        $user = auth()->user();

        $data = DB::table('user_device_tracks')
            ->where('user_id', $user->id)
            ->where('room_code', $room_code)
            ->where('device_number', $device_number)
            ->orderBy('id', 'desc')
            ->first();

        if (!$data) {
            $data = DB::table('user_device_tracks')
                ->where('user_id', $user->id)
                ->where('room_code', $room_code)
                ->orderBy('id', 'desc')
                ->first();

            if (!$data) {
                // different user
                $data = DB::table('user_device_tracks')
                    ->where('room_code', $room_code)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$data) {
                    return response()->json([
                        'data' => null,
                        'message' => 'No data found.',
                        'type' => 'error',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                } else {
                    if ($data->device_number !== $device_number) {
                        return response()->json([
                            'data' => $data,
                            'message' => 'Device number does not match.',
                            'type' => 'error',
                            'status' => Response::HTTP_OK,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'data' => $data,
                            'message' => 'Data found for the specified room code.',
                            'type' => 'success',
                            'status' => Response::HTTP_OK,
                        ], Response::HTTP_OK);
                    }
                }
            } else {
                if ($data->device_number !== $device_number) {
                    return response()->json([
                        'data' => $data,
                        'message' => 'Device number does not match.',
                        'type' => 'success',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'data' => $data,
                        'message' => 'Data found for the specified user and room code.',
                        'type' => 'success',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                }
            }
        }

        return response()->json([
            'data' => $data,
            'message' => 'Data found for the specified user, room code, and device number.',
            'type' => 'success',
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);












        // if (!$data) {
        //     $data = DB::table('user_device_tracks')
        //         ->where('room_code', $room_code)
        //         ->where('user_id', $user->id)
        //         ->orderBy('id', 'desc')
        //         ->first();

        //     if (!$data) {
        //         $data = DB::table('user_device_tracks')
        //             ->where('room_code', $room_code)
        //             ->orderBy('id', 'desc')
        //             ->first();
        //     }
        // }

        // if ($data) {
        //     return response()->json([
        //         'data' => $data,
        //         'message' => "Data found.",
        //         'type' => 'success',
        //         'status' => Response::HTTP_OK,
        //     ], Response::HTTP_OK);
        // } else {
        //     return response()->json([
        //         'data' => null,
        //         'message' => "No data found.",
        //         'type' => 'error',
        //         'status' => Response::HTTP_OK,
        //     ], Response::HTTP_OK);
        // }
    }

    function roomFullCheck($room_code)
    {
        $user = auth()->user();

        $game = Free2pgame::where('game_id', $room_code)
            ->where(function ($query) use ($user) {
                $query->where('player_one', $user->id)
                    ->orWhere('player_two', $user->id);
            })
            ->first();

        if (!is_null($game)) {
            return json_encode([
                'status' => true,
                'message' => 'You are already joined'
            ]);
        }

        $game = Free2pgame::where('game_id', $room_code)->first();

        if ($game) {
            if (!is_null($game->player_two)) {
                return json_encode([
                    'status' => false,
                    'message' => 'Game already fulfilled'
                ]);
            } else {
                return json_encode([
                    'status' => true,
                    'message' => 'Player Two can join the game'
                ]);
            }
        } else {
            return json_encode([
                'status' => false,
                'message' => 'Room not found'
            ]);
        }
    }


    function roomFullCheck3p($room_code)
    {

        $user = auth()->user();

        $game = Free3pgame::where('game_id', $room_code)
            ->where(function ($query) use ($user) {
                $query->where('player_one', $user->id)
                    ->orWhere('player_two', $user->id)
                    ->orWhere('player_three', $user->id);
            })
            ->first();

        if (!is_null($game)) {
            return json_encode([
                'status' => true,
                'message' => 'You are already joined'
            ]);
        }



        $game = Free3pgame::where('game_id', $room_code)->first();

        if ($game) {
            if ($game->player_two !== null && $game->player_three !== null) {
                return json_encode([
                    "success" => false,
                    'message' => 'Game Already fulfilled'
                ]);
            } elseif ($game->player_two !== null && $game->player_three === null) {
                return json_encode([
                    "success" => true,
                    'message' => 'Player Three can join the game'
                ]);
            } else {
                return json_encode([
                    "success" => true,
                    'message' => 'Room is not full'
                ]);
            }
        } else {
            return json_encode([
                'message' => 'Room not found'
            ]);
        }
    }

    function roomFullCheck4p($room_code)
    {
        $user = auth()->user();

        $game = Free4playergame::where('game_id', $room_code)
            ->where(function ($query) use ($user) {
                $query->where('player_one', $user->id)
                    ->orWhere('player_two', $user->id)
                    ->orWhere('player_three', $user->id)
                    ->orWhere('player_four', $user->id);
            })
            ->first();

        if (!is_null($game)) {
            return json_encode([
                'status' => true,
                'message' => 'You are already joined'
            ]);
        }


        $game = Free4playergame::where('game_id', $room_code)->first();

        if ($game) {

            if ($game->player_two !== null && $game->player_three !== null && $game->player_four !== null) {
                return json_encode([
                    "success" => false,
                    'message' => 'Game Already fulfilled'
                ]);
            } elseif ($game->player_two !== null && $game->player_three !== null && $game->player_four === null) {
                return json_encode([
                    "success" => true,
                    'message' => 'Player Four can join the game'
                ]);
            } elseif ($game->player_two !== null && $game->player_three === null) {
                return json_encode([
                    "success" => true,
                    'message' => 'Player Three can join the game'
                ]);
            } else {
                return json_encode([
                    "success" => true,
                    'message' => 'Room is not full'
                ]);
            }
        } else {
            return json_encode([
                'message' => 'Room not found'
            ]);
        }
    }
}
