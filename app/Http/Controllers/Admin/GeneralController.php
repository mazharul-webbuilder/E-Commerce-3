<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinUseHistory;
use Illuminate\Http\Request;

class GeneralController extends Controller
{


    public function used_coin_history(){
        $coin_used_histories=CoinUseHistory::latest()->get();
        return view('webend.general.used_coin_history',compact('coin_used_histories'));
    }
}
