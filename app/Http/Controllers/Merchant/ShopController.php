<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        return \view('merchant.shop.index');
    }
}
