<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Ecommerce\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EcommerceController extends Controller
{


    public function get_category(){
        $categories=Category::where('status',1)->orderBy('priority','ASC')->get();
        $datas=CategoryResource::collection($categories);

        return response()->json([
            'datas'=>$datas,
            'status'=>200,
            'type'=>'success'
        ],Response::HTTP_OK);
    }

    public function product_detail($id,$seller_or_affiliate=null,$type=null){
        $data=[$id,$seller_or_affiliate,$type];
        return $data;
    }
    public function add_to_cart(Request $request){

    }
}
