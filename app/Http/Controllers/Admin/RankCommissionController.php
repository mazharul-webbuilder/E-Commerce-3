<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RankCommission;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RankCommissionController extends Controller
{

    public function index()
    {
        $rank_commissions = RankCommission::get();
        return view('webend.rank_commisions',compact('rank_commissions'));
    }
    public function edit($id)
    {
        $rank_commission = RankCommission::find($id);
        return view('webend.rank_commisions',compact('rank_commission'));
    }
    public function update(Request $request,$id)
    {
        try{
            DB::beginTransaction();
            $rank_commission = RankCommission::find($id);
            $rank_commission->registration_commission = $request->registration_commission;
            $rank_commission->diamond_commission = $request->diamond_commission;
            $rank_commission->betting_commission = $request->betting_commission;
            $rank_commission->withdraw_commission = $request->withdraw_commission;
            $rank_commission->game_asset_commission = $request->game_asset_commission;
            $rank_commission->updating_commission = $request->updating_commission;
            $rank_commission->save();
            DB::commit();
            Alert::success('Rank Commission Update Successfully!');
            return redirect()->route('rank.commission');

        }catch (\Exception $ex)
        {
            $ex->getMessage();
            return back();
        }
    }
}
