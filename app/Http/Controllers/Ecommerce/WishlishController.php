<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WishlishController extends Controller
{
   public function add_to_wishlist(Request $request)
   {
       $wish_list = Wishlist::where('product_id', $request->product_id)
                    ->where('user_id', auth()->user()->id)->first();
       if (is_null($wish_list)) {
           $wish_list = new Wishlist();
           $wish_list->product_id = $request->product_id;
           $wish_list->user_id = auth()->user()->id;
           $wish_list->save();
       }else{
           return response()->json([
               'message' => "Item Already Added to  Wish list",
               'status' => 200
           ], Response::HTTP_OK);
       }
       return response()->json([
           'message' => "Item added to  Wish list",
           'status' => 200
       ], Response::HTTP_OK);
   }

    public function view_wishlist()
    {
        $wish_list=Wishlist::with(['product:id,title,previous_price,current_price,thumbnail',])->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'wish list'=>$wish_list,
            'status' =>200
        ],Response::HTTP_OK);
    }

    public function delete_wishlist($id)
    {
        $wish_list = Wishlist::where('id', $id)->first();
        $wish_list->delete();
        return response()->json([
            'message' => "Successfully delete",
            'status' => 200,
            'type' => "success",
        ], Response::HTTP_OK);

    }
}
