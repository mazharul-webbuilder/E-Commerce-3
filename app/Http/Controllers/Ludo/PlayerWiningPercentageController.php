<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Models\PlayerWiningPercentage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class PlayerWiningPercentageController extends Controller
{

    public function store(Request $request)
    {
        $checkroomcode =  PlayerWiningPercentage::where('room_code', $request->room_code)->first();

        $validator = Validator::make($request->all(), [
            'room_code' => 'required',
            'player_1_winning_chance' => 'nullable',
            'player_2_winning_chance' => 'nullable',
            'player_3_winning_chance' => 'nullable',
            'player_4_winning_chance' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            try {
                DB::beginTransaction();
                if ($checkroomcode) {
                    $checkroomcode->update([
                        'player_1_winning_chance' => $request->player_1_winning_chance,
                        'player_2_winning_chance' => $request->player_2_winning_chance,
                        'player_3_winning_chance' => $request->player_3_winning_chance,
                        'player_4_winning_chance' => $request->player_4_winning_chance,
                    ]);
                } else {
                    PlayerWiningPercentage::create($request->all());
                }
                DB::commit();
                return response()->json([
                    'message' => "Successfully added",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
            } catch (\Exception $e) {
                DB::rollback();
                return response($e->getMessage());
            }
        }
    }


    public function index($room_code)
    {

       //  return date("Y-m-d H:i:s");
        try {
            $playerWiningPercentage = PlayerWiningPercentage::where('room_code', $room_code)->first();

            if ($playerWiningPercentage) {
                return response()->json(
                    [
                        'room_code' => $playerWiningPercentage->room_code,
                        'player_1_winning_chance' => $playerWiningPercentage->player_1_winning_chance,
                        'player_2_winning_chance' => $playerWiningPercentage->player_2_winning_chance,
                        'player_3_winning_chance' => $playerWiningPercentage->player_3_winning_chance,
                        'player_4_winning_chance' => $playerWiningPercentage->player_4_winning_chance,
                        'created_at' =>  $playerWiningPercentage->created_at->format('d-m-Y h:i:s A'),
                        'updated_at' =>  $playerWiningPercentage->updated_at->format('d-m-Y h:i:s A'),
                        'now_time' => Carbon::now()->format('d-m-Y h:i:s A'),
                    ]
                );
            } else {
                return response()->json(['message' => 'Player winning percentage not found'], 404);
            }
        } catch (\Throwable $th) {
            // Handle any exceptions if necessary
        }
    }
}
