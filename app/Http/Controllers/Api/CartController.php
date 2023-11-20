<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Ecommerce\Cart;
use App\Models\Ecommerce\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{


    public function add_to_cart(Request $request){

       // $user=Auth::guard('api')->check() ? Auth::guard('api')->user() : null;


        $validator = Validator::make($request->all(), [
            'product_id'=>'required|integer',
            'quantity' => 'required|numeric',
            'size_id'=>'nullable|integer',
        ]);

        $product=Product::find($request->product_id);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => "error",
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            if (empty($request->size_id)){
                if (auth()->guard('api')->check()){
                    $cart=Cart::where(['product_id'=>$request->product_id,'user_id'=>auth()->guard('api')->user()->id])->first();
                }else{
                    $cart=Cart::where(['product_id'=>$request->product_id,'ip_address'=>$request->ip()])->first();
                }
            }else{
                if (auth()->guard('api')->check()){
                    $cart=Cart::where(['product_id'=>$request->product_id,'user_id'=>auth()->guard('api')->user()->id,'size_id'=>$request->size_id])->first();
                }else{
                    $cart=Cart::where(['product_id'=>$request->product_id,'ip_address'=>$request->ip(),'size_id'=>$request->size_id])->first();
                }
            }

            if (is_null($cart)){

                $data=new Cart();
                $data->product_id=$request->product_id;
                $data->quantity=$request->quantity;
                $data->ip_address=$request->ip();
                $data->user_id=auth()->guard('api')->check() ? auth()->guard('api')->user()->id : null;
                $data->size_id=$request->size_id !=null ? $request->size_id : null;
                $data->seller_id=$request->seller_number  !=null ? seller($request->seller_number)->id : null;
                $data->affiliator_id=$request->affiliate_number  !=null ? affiliator($request->affiliate_number)->id : null;
                $data->is_flash_deal=$product->flash_deal==1 ? 1 : 0;
                $data->save();

            }else{
                $cart->increment('quantity');
            }

           // return Cart::carts();

            return response()->json([
                'message'=>"successfully added to cart",
                'type'=>'success',
                'subtotal'=>Cart::subtotal(),
                'total_item'=>Cart::total_item(),
                'status'=>Response::HTTP_OK,
            ],Response::HTTP_OK);

        }
    }

    public function view_cart(){


        return response()->json([
            'data'=>CartResource::collection(Cart::carts()),
            'subtotal'=>Cart::subtotal(),
            'total_item'=>Cart::total_item(),
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);
    }

    public function update_cart(Request  $request){
         if ($request->isMethod('post')){
             try {
                 DB::beginTransaction();
                 Cart::find($request->cart_id)->update(['quantity'=>$request->quantity]);
                 DB::commit();
                 return response()->json([
                     'data'=>'Successfully updated',
                     'subtotal'=>Cart::subtotal(),
                     'total_item'=>Cart::total_item(),
                     'status'=>Response::HTTP_OK,
                 ],Response::HTTP_OK);
             }catch (QueryException $exception){
                 return response()->json([
                     'data'=>CartResource::collection(Cart::carts()),
                     'type'=>'error',
                     'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                 ],Response::HTTP_INTERNAL_SERVER_ERROR);
             }
         }
    }

    public function delete_cart(Request  $request){
        if ($request->isMethod('post')){
            try {
                Cart::find($request->cart_id)->delete();

                return response()->json([
                    'data'=>'Successfully delete',
                    'subtotal'=>Cart::subtotal(),
                    'total_item'=>Cart::total_item(),
                    'status'=>Response::HTTP_OK,
                ],Response::HTTP_OK);
            }catch (QueryException $exception){
                return response()->json([
                    'data'=>CartResource::collection(Cart::carts()),
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
