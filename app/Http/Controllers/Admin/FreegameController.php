<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Free2pgame;
use App\Models\Free2pgamesettings;
use App\Models\Free3pgame;
use App\Models\Free3pgamesettings;
use App\Models\Free4playergame;
use App\Models\Free4playergamesettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class FreegameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function two_player()
    {
        $free_two_player = Free2pgame::latest()->get();
        return view('webend.free2p.player', compact('free_two_player'));
    }

    public function two_player_settings()
    {
        $free_two_player_settings = Free2pgamesettings::first();
        return view('webend.free2p.settings', compact('free_two_player_settings'));
    }

    public function two_player_settings_update(Request $request)
    {

        $request->validate([
            'winner_coin_multiply_value' => 'required|numeric'
        ]);
        try {
            DB::beginTransaction();
            $free_two_player_settings = Free2pgamesettings::first();
            $free_two_player_settings->update([
                'winner_coin_multiply_value' => $request->winner_coin_multiply_value,
            ]);
            DB::commit();
            Alert::success('Updated Successfully!');
            return  back();
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }

    public function three_player()
    {
        $free_three_player = Free3pgame::latest()->get();
        return view('webend.free3p.player', compact('free_three_player'));
    }

    public function three_player_settings()
    {
        $free_three_player_settings = Free3pgamesettings::first();
        return view('webend.free3p.settings', compact('free_three_player_settings'));
    }

    public function three_player_settings_update(Request $request)
    {
        $request->validate([
            'first_winner_multiply' => 'required',
            'second_winner_multiply' => 'required',
            'third_winner_multiply' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $free_two_player_settings = Free3pgamesettings::first();
            $free_two_player_settings->update([
                'first_winner_multiply' => $request->first_winner_multiply,
                'second_winner_multiply' => $request->second_winner_multiply,
                'third_winner_multiply' => $request->third_winner_multiply,
            ]);
            DB::commit();
            Alert::success('Updated Successfully!');
            return  back();
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }

    public function four_player()
    {
        $free_four_player = Free4playergame::latest()->get();
        return view('webend.free4p.player', compact('free_four_player'));
    }

    public function four_player_settings()
    {
        $free_four_player_settings = Free4playergamesettings::first();
        return view('webend.free4p.settings', compact('free_four_player_settings'));
    }

    public function four_player_settings_update(Request $request)
    {
        $request->validate([
            'first_winner_multiply' => 'required',
            'second_winner_multiply' => 'required',
            'third_winner_multiply' => 'required',
            'looser_multiply' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $free_two_player_settings = Free4playergamesettings::first();
            $free_two_player_settings->update([
                'first_winner_multiply' => $request->first_winner_multiply,
                'second_winner_multiply' => $request->second_winner_multiply,
                'third_winner_multiply' => $request->third_winner_multiply,
                'looser_multiply' => $request->looser_multiply,
            ]);
            DB::commit();
            Alert::success('Updated Successfully!');
            return  back();
        } catch (\Exception $ex) {
            DB::rollBack();
            return api_response('error', 'Something went a wrong', $ex->getMessage(), 200);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
