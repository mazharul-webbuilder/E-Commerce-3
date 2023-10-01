<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function __construct(){
        $this->middleware('seller');
    }
    public function index(){
        return view('seller.index');
    }
}
