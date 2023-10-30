<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display Admin Users List
    */
    public function index(): View
    {
        return \view('webend.ecommerce.users.admin.index');
    }

    /**
     * Load Datatable of Ecommerce Admin List
    */
    public function datatable()
    {
        $admins = DB::table('admins')->get();

        return DataTables::of($admins)->addIndexColumn()->make(true);
    }

}
