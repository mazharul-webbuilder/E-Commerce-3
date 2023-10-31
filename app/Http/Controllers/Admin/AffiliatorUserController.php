<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate\Affiliator;
use App\Models\Ecommerce\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AffiliatorUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display Affiliator List in Admin panel
     *
    */
    public function index():View
    {
        return \view('webend.ecommerce.users.affiliator.index');
    }

    /**
     * Load Data of Seller to show affiliator list in admin panel
     */
    public function datatable()
    {
        $affiliators = DB::table('affiliators')->latest()->get();

        return DataTables::of($affiliators)->addIndexColumn()
            ->addColumn('avatar', function ($affiliator){
                return (!is_null($affiliator->avatar)) ?  '<img src="'.asset('uploads/affiliator/resize/').'/'.$affiliator->avatar.'" alt="'.$affiliator->name.'" />'
                    :
                    '<img src="'.asset(default_image()).'" alt="'.$affiliator->name.'" />'
                    ;
            })
            ->addColumn('view_store_detail', function ($affiliator) {
                return  ' <a href="' . route('admin.affiliator.shop.detail', $affiliator->id) . '" type="button" class="text-white bg-teal-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Store Detail
                    </a>';
            })
            ->addColumn('total_product', function ($affiliator){
                return DB::table('affiliator_products')->where('affiliator_id', $affiliator->id)->count();
            })
            ->rawColumns(['avatar', 'total_product', 'view_store_detail'])->make(true);
    }

    /**
     * Display Affiliator Shop Detail
     */
    public function shopDetail($id)
    {
        $affiliator = Affiliator::find($id);

        $products = Product::whereHas('affiliator_products', function ($q) use ($affiliator){
            return $q->where('affiliator_id', $affiliator->id);
        })->get();

        return \view('webend.ecommerce.users.affiliator.store', compact('affiliator', 'products'));
    }
}
