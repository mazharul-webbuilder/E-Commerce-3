<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ManageProductController extends Controller
{


    public function __construct(){
        $this->middleware('seller');
    }
    public function datatable(){

        $datas=Product::where('is_reseller',1)->orderBy('id','DESC')->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(Product $data){
                $url=$data->thumbnail ? asset("uploads/product/resize/".$data->thumbnail)
                    :default_image();
                return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
            })
            ->editColumn('merchant',function(Product $data){
               return '<div><p>Name:'.$data->merchant->name ?? "".'</p></div>';
            })
            ->editColumn('action',function(Product $data){
                return '<a href="javascriptL:;"   type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">

                                            Delete
                                        </a>
                                        <a href="javascriptL:;"   type="button" class="delete_item text-white bg-purple-600 hover:bg-purple-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                                            View Detail
                                        </a>
                                        <a href="javascriptL:;"   type="button" class="delete_item text-white bg-cyan-600 hover:bg-cyan-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                                            Add My Store
                                        </a>
                                        ';
            })
            ->rawColumns(['thumbnail','merchant','action'])
            ->make(true);
    }

    public function index(){

        return view('seller.product.index');
    }
}
