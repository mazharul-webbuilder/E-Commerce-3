<?php

namespace App\Http\Controllers;

use App\Models\HomeCoinUseHistory;
use Illuminate\Http\Request;

class HomeCoinUseHistoryController extends Controller
{
    function home_used_coin_history()
    {
        $coin_used_histories = HomeCoinUseHistory::latest('id')->with('user:id,name,playerid')->get();
        return view('webend.general.home_used_coin_history', compact('coin_used_histories'));
    }
}
