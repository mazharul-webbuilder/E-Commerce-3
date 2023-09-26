<?php

namespace App\Http\Controllers;

use App\Models\HomeCoinUseHistory;
use App\Models\HomeDimondUseHistory;
use Illuminate\Http\Request;

class HomeDimondUseHistoryController extends Controller
{
    function home_used_diamond_history()
    {
        $diamond_used_histories = HomeDimondUseHistory::latest('id')->with('user:id,name,playerid')->get();

        return view('webend.general.home_used_diamond_history', compact('diamond_used_histories'));
    }
}
