<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rank;
use App\Models\RankUpdateHistory;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ranks =  Rank::orderBy('priority')->get();
            return view('webend.member_rank',compact('ranks'));
    }

    public function rank_update_history()
    {
       $histories =  RankUpdateHistory::latest()->get();
        return view('webend.rank_update_history',compact('histories'));
    }


    public function update(Request $request)
    {
     //   dd($request->all());
        try {
            DB::beginTransaction();
                $update = Rank::where('priority',1)->update([
                    'rank_name' => $request->vip_rank_name,
                ]);

                $update = Rank::where('priority',2)->update([
                    'rank_name' => $request->partner_rank_name,
                ]);

                $update = Rank::where('priority',3)->update([
                    'rank_name' => $request->star_rank_name,
                ]);

                $update = Rank::where('priority',4)->update([
                    'rank_name' => $request->sub_controller_rank_name,
                ]);

                $update = Rank::where('priority',5)->update([
                    'rank_name' => $request->controller_rank_name,
                ]);

            DB::commit();
            Alert::success('Rank Updated successfully!');
            return back();
        }catch (\Exception $ex)
        {
            DB::rollBack();
            return $ex->getMessage();
        }
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
