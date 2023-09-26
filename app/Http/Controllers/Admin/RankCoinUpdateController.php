<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order_detail;
use App\Models\RankUpdateHistory;
use Illuminate\Http\Request;
use App\Models\CoinRankUpdate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RankCoinUpdateController extends Controller
{
    public function index()
    {
        $coin_rank = CoinRankUpdate::get();
        return view('webend.coin_ranks',compact('coin_rank'));
    }

    public function edit($id)
    {
        $coinRank = CoinRankUpdate::find($id);
        return view('webend.coin_ranks',compact('coinRank'));
    }
    public function update(Request  $request,$id)
    {
//        dd('dsf');
        try {
            DB::beginTransaction();
            $coinRank = CoinRankUpdate::find($id);
            $coinRank->coin = $request->coin;
            $coinRank->save();
            DB::commit();
            Alert::success('Coin Update Successfully');
            return redirect()->route('rank.coins');
        }catch (\Exception $ex)
        {
            DB::rollBack();
            $ex->getMessage();
        }

    }

    public function rank_update_history($type=null){

        if ($type !=null){
           if ($type=='all'){
               $histories=RankUpdateHistory::query()->orderBy('id','DESC')->get();
           }else{
               $histories=RankUpdateHistory::query()->where('type',$type)->orderBy('id','DESC')->get();
           }
        }else{
            $histories=RankUpdateHistory::query()->orderBy('id','DESC')->get();
        }
        return view('webend.report.rank_update_history',compact('histories'));
    }

    public function search_by_date(Request  $request){
        $histories=RankUpdateHistory::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->get();
        return view('webend.report.rank_update_history',compact("histories"));
    }
}
