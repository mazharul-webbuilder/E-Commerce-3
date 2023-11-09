<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(): View
    {
        return view('frontend.home');
    }
    public function product_detail($id,$seller_or_affiliate,$type):void
    {

    }
}
