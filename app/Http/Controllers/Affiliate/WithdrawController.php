<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('affiliate');
    }

    public function index(): View
    {
        return \view('affiliate.withdraw.index');
    }
}
