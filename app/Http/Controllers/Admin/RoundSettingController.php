<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentResource;
use App\Models\RoundSettings;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoundSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tournament = Tournament::find($id);
        $rounds_setting = RoundSettings::where('tournament_id',$id)->get();
        return view('webend.round_setting',compact('rounds_setting','tournament'));
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
//        dd($request->all());
        try {
            DB::beginTransaction();
            $round = RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','!=','final')->max('round_type');

            for ($i =1;$i<=$round; $i++){
                $hour= $request->input('hour'.$i);
                $hourmin = $hour * 60;
                $total = $hourmin + $request->input('min'.$i);
//                dd($total);
               $tournament = Tournament::find($request->tournament_id);
                if ($tournament->player_type == '2p'){
                    RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','!=','final')->where('round_type',$i)->update([
                        'time_gaping' => $total,
                        'fourth_bonus_point' =>$request->input('forth'.$i),
                        'updated_at' =>Carbon::now(),
                    ]);
                }else{
                    RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','!=','final')->where('round_type',$i)->update([
                        'time_gaping' => $total,
                        'third_bonus_point' =>$request->input('third'.$i),
                        'fourth_bonus_point' =>$request->input('fourth'.$i),
                        'updated_at' =>Carbon::now(),
                    ]);
                }

            }
            RoundSettings::where('tournament_id',$request->tournament_id)->where('round_type','final')->update([
//            'time_gaping' => $total,
                'first_bonus_point' =>$request->first_final,
                'second_bonus_point' =>$request->second_final,
                'third_bonus_point' =>$request->third_final,
                'fourth_bonus_point' =>$request->forth_final,
                'updated_at' =>Carbon::now(),
            ]);
            DB::commit();
            Alert::success('Round setting Update Successfully.');
            return back();

        } catch (\Exception $e) {
            DB::rollback();
            Alert::error($e->getMessage());
            return back();

        }
//        dd($round);
//        dd($request->all());
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
