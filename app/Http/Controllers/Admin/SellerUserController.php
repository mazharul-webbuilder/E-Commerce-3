<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SellerUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display All Seller's In Admin
    */
    public function index(): View
    {
        return \view('webend.ecommerce.users.seller.index');
    }

    /**
     * Load Data of Seller to show seller list in admin panel
    */
    public function datatable()
    {
        $sellers = DB::table('sellers')->latest()->get();

        return DataTables::of($sellers)->addIndexColumn()
            ->addColumn('avatar', function ($seller){
                return '<img src="'.asset('uploads/seller/resize/').'/'.$seller->avatar.'" alt="'.$seller->name.'" />';
            })
            ->addColumn('total_product', function ($seller){
                return DB::table('seller_products')->where('seller_id', $seller->id)->count();
            })
            ->rawColumns(['avatar', 'total_product'])->make(true);
    }
}
