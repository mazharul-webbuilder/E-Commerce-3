<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use App\Models\Seller\Seller;
use App\Models\SellerProduct;
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
                return (!is_null($seller->avatar)) ?  '<img src="'.asset('uploads/seller/resize/').'/'.$seller->avatar.'" alt="'.$seller->name.'" />'
                    :
                    '<img src="'.asset(default_image()).'" alt="'.$seller->name.'" />'
                    ;
            })
            ->addColumn('view_store_detail', function ($seller) {
                $shop = DB::table('shop_details')->where('merchant_id', $seller->id)->first();

                return  ' <a href="' . route('admin.seller.shop.detail', $seller->id) . '" type="button" class="text-white bg-teal-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Store Detail
                    </a>';
            })
            ->addColumn('total_product', function ($seller){
                return DB::table('seller_products')->where('seller_id', $seller->id)->count();
            })
            ->rawColumns(['avatar', 'total_product', 'view_store_detail'])->make(true);
    }

    /**
     * Display Seller Shop Detail
     */
    public function shopDetail($id)
    {
        $seller = Seller::find($id);

        $products = Product::whereHas('seller_products', function ($q) use ($seller){
            return $q->where('seller_id', $seller->id);
        })->get();

        return \view('webend.ecommerce.users.seller.store', compact('seller', 'products'));
    }
}
