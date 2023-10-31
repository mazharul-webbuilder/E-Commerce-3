<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use App\Models\ShopDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MerchantUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display All Merchant List in Admin
    */
    public function index(): View
    {
        return \view('webend.ecommerce.users.merchant.index');
    }
    /**
     * Datatable of Merchants List
    */
    public function datatable()
    {
        $merchants = DB::table('merchants')->latest()->get();

        return DataTables::of($merchants)->addIndexColumn()
            ->addColumn('avatar', function ($merchant){
                return (!is_null($merchant->avatar)) ?  '<img src="'.asset('uploads/merchant/resize/').'/'.$merchant->avatar.'" alt="'.$merchant->name.'" />'
                    :
                    '<img src="'.asset(default_image()).'" alt="'.$merchant->name.'" />'
                    ;
            })
            ->addColumn('shop_detail', function ($merchant) {
                $shop = DB::table('shop_details')->where('merchant_id', $merchant->id)->first();

                return (!is_null($shop)) ? ' <a href="' . route('admin.merchant.shop.detail', $shop->id) . '" type="button" class="text-white bg-teal-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                Shop Detial
            </a>'
                    :
            ' <a href="javascript:void(0)" type="button" class="text-white bg-red-600 hover:bg-red-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                Not Set Yet
            </a>'
                    ;
            })
            ->addColumn('total_product', function ($merchant){
                return DB::table('products')->where('merchant_id', $merchant->id)->count();
            })
            ->rawColumns(['shop_detail', 'avatar', 'total_product'])->make(true);
    }

    /**
     * Display Merchant Shop Detail
    */
    public function shopDetail($id)
    {
        $shop = ShopDetail::find($id);

        $products = Product::where('merchant_id', $shop->merchant->id)->get();

        return \view('webend.ecommerce.users.merchant.shop', compact('shop', 'products'));
    }
}
