<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            ->addColumn('total_product', function ($affiliator){
                return DB::table('affiliator_products')->where('affiliator_id', $affiliator->id)->count();
            })
            ->rawColumns(['avatar', 'total_product'])->make(true);
    }
}
