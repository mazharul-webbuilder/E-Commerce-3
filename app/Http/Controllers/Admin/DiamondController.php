<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiamondSellHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Diamond;
use App\Models\Rank;
use App\Models\RoundSettings;
use App\Models\Gameround;
use App\Models\Tournament;
use App\Models\DiamondUseHistory;
use App\Models\RankUpdateHistory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class DiamondController extends Controller
{
    public function diamond()
    {
        $diamond_view = Diamond::first();
        return view('webend.diamond_settings', compact('diamond_view'));
    }

    // diamond_update
    public function diamond_update(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->previous_price != null) {
                Diamond::first()->update([
                    'previous_price' => $request->previous_price,
                ]);
            }
            if ($request->current_price != null) {
                Diamond::first()->update([
                    'current_price' => $request->current_price,
                ]);
            }
            if ($request->partner_price != null) {
                Diamond::first()->update([
                    'partner_price' => $request->partner_price,
                ]);
            }
            DB::commit();
            Alert::success('Diamond Price Update');
            return back();
        } catch (\Exception $ex) {
            DB::rollBack();
            $ex->getMessage();
        }
    }


    public function diamond_used_history()
    {
        $diamond_histories = get_total_purchase_used();
        return view('webend.diamond_use_history', compact('diamond_histories'));
    }
    public function diamond_search_by_date(Request $request)
    {

        $diamond_histories = DiamondUseHistory::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->get();
        return view('webend.diamond_use_history', compact('diamond_histories'));
    }
}
