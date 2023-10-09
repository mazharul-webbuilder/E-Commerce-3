<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Ecommerce\Category;
use App\Models\Ecommerce\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EcommerceController extends Controller
{


    public function get_category(){
        $categories=Category::where('status',1)->orderBy('id','DESC')->get();
        $datas=CategoryResource::collection($categories);

        return response()->json([
            'datas'=>$datas,
            'status'=>200,
            'type'=>'success'
        ],Response::HTTP_OK);
    }

    public function category_wise_product($id){
        $datas=Product::where('category_id',$id)->latest()->paginate(8);
        $products=ProductResource::collection($datas);

        return \response()->json([
            'products'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function product_detail($id,$seller_or_affiliate=null,$type=null){
        $data=[$id,$seller_or_affiliate,$type];
        return $data;
    }

    public function product_list(){
        $datas=Product::where('current_price','<=',300)->latest()->paginate(8);
        $products=ProductResource::collection($datas);

        return \response()->json([
            'products'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }
    public function add_to_cart(Request $request){

    }
}
