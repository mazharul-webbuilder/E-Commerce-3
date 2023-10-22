<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\ShopDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('merchant');
    }

    /**
     * Merchant Shop Setting Page Load
    */
    public function setting(): View
    {
        $data = ShopDetail::where('merchant_id', Auth::guard('merchant')->user()->id)->first();

        return \view('merchant.shop.index', compact('data'));
    }
}
