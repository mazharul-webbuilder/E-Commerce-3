<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Show Index
    */
    public function index(): View
    {
        return  \view('seller.withdraw.index');
    }
}
