<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
}
