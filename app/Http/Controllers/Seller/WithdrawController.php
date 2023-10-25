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
     * Show Seller Withdraw History
    */
    public function index(): View
    {
        return  \view('seller.withdraw.index');
    }

    /**
     * Show Seller Withdraw Request Form
    */
    public function withdrawRequest(): View
    {
        return \view('seller.withdraw.request_form');
    }
}
