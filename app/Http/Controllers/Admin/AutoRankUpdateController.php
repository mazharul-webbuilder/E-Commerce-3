<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AutoRankUpdate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AutoRankUpdateController extends Controller
{
    public function index()
    {
        $rank_auto_update = AutoRankUpdate::get();
       return view('webend.rank_auto_update',compact('rank_auto_update'));
    }
    public function edit($id)
    {
        $coinRank = AutoRankUpdate::find($id);
       $string_to_array=explode(" ",$coinRank->title);
        $needed_member=$string_to_array[0];
        return view('webend.rank_auto_update',compact('coinRank','needed_member'));
    }
    public function update(Request  $request,$id)
    {
//        dd('dsf');
        try {
            DB::beginTransaction();
            $coinRank = AutoRankUpdate::find($id);
            $coinRank->member = $request->member;
            $coinRank->save();
            DB::commit();
            Alert::success('Member Update Successfully');
            return redirect()->route('rank.coins_auto_update');
        }catch (\Exception $ex)
        {
            DB::rollBack();
            $ex->getMessage();
        }

    }
}
