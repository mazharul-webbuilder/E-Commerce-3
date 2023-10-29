<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }
    /**
     * Display Seller Dashboard
    */
    public function index(): View
    {
        return view('seller.index');
    }
    /**
     * Display Seller Profile Page
    */
    public function profile(): View
    {
        $data = Auth::guard('seller')->user();

        return \view('seller.profile', compact('data'));
    }

}
