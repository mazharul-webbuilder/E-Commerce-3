<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Ecommerce\Cart;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{


    public function add_to_cart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric',
            'size_id'=>'required|integer',
            'product_id'=>'required|integer'
        ]);
        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => "error",
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {

            $cart = Cart::where('product_id', $request->product_id)
                ->where('size_id', $request->size_id)
                ->where('user_id', auth()->user()->id)->first();
            if (is_null($cart)) {
                $cart = new Cart();
                $cart->product_id = $request->product_id;
                $cart->size_id = $request->size_id;
                $cart->quantity = $request->quantity;
                $cart->user_id = auth()->user()->id;
                if ($request->type==Cart::CART_TYPE['buy']){
                    $cart->status=1;
                }else{
                    $cart->status=0;
                }

                $cart->save();
            } else {
                $cart->increment('quantity');
            }
            return response()->json([
                'message' => "Item added to cart",
                'status' => 200
            ], Response::HTTP_OK);
        }
    }

    public function view_cart(){
        $carts=Cart::where('user_id',auth()->user()->id)->latest()->get();
        $data=CartResource::collection($carts);
        return api_response('success','All Product',$data,Response::HTTP_OK);

    }

    public function update_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'quantity' => 'required|numeric',
       ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => "error",
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            if ($request->isMethod("post")) {
                try {
                    DB::beginTransaction();
                    $cart = Cart::find($request->cart_id);
                    $cart->quantity = $request->quantity;
                    $cart->save();
                    DB::commit();
                    return response()->json([
                        'message' => "Successfully updated",
                        'status' => 200,
                        'type' => "success",
                    ], Response::HTTP_OK);

                } catch (QueryException $e) {
                    DB::rollBack();
                    $error = $e->getMessage();
                    return \response()->json([
                        'error' => $error,
                        'type' => 'error',
                        'status_code' => 500
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
          }
        }

        public function delete_cart(Request $request)
        {
            $cart=Cart::find($request->cart_id);
            $cart->delete();
            return response()->json([
                'message' => "Successfully delete",
                'status' => 200,
                'type' => "success",
            ], Response::HTTP_OK);

        }

    public  function order_details(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'product_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $pattern = '/[\s"]/';
            $components = preg_split($pattern, $request->product_id);

            $cart_data = Cart::where('user_id',Auth::user()->id)->whereIn('product_id',array_filter($components, 'is_numeric'))->get();

            if ($request->type == 'remove')
            {
                if (count($cart_data) > 0){
                    foreach ($cart_data as $data)
                    {
                        Cart::find($data->id)->delete();
                        DB::commit();
                    }
                    $cart =  Cart::where('user_id',Auth::user()->id)->get();
                    return api_response('success','Remove Selected Product from Cart',$cart,Response::HTTP_OK);
                }else{
                    return api_response('success','No product Found',null,Response::HTTP_OK);
                }

            }elseif ($request->type == 'checkout'){
                if (count($cart_data) > 0){
                    foreach ($cart_data as $data)
                    {
                        Cart::find($data->id)->update(['status'=>1]);
                        DB::commit();
                    }
                    $cartdata = CartResource::collection($cart_data);
                    $cart['all_product'] = $cartdata;
                    $cart['subtotal'] = Cart::subtotal();
                    $cart['grand_total'] = default_currency()->currency_code." ".Cart::subtotal();
                    $cart['bdt_grand_total'] = currency_code('BDT')->currency_code." ".currency_convertor(Cart::subtotal(),'convert_to_bdt');
                    $cart['inr_grand_total'] = currency_code('INR')->currency_code." ".currency_convertor(Cart::subtotal(),'convert_to_inr');
                    $cart['quantity'] =  Cart::carts()->sum('quantity');
                    return response()->json(['type'=>'success','message'=>'All Selected Product','data'=>$cart,'status'=>Response::HTTP_OK,
                        'email_status'=> check_digital($cart_data)]);
//                   return api_response('success','All Selected Product',$cart,Response::HTTP_OK);
                }else{
                    return api_response('success','No product Found',null,Response::HTTP_OK);
                }
            }

        }catch (\Exception $ex)
        {
            $ex->getMessage();
        }
    }

    public function shipping_charge(Request $request){
        $request->validate([
            'shipping_type' => 'required',
        ]);
        if ($request->isMethod("post")){
            $carts=Cart::where('user_id',auth()->user()->id)->where('status',1)
                ->groupBy('product_id')
                ->get();

             $total_shipping=calculate_shipping_charge($carts,$request->shipping_type);
            $cart['grand_total'] = default_currency()->currency_code." ".Cart::subtotal();
            $total_shipping_bdt=currency_code('BDT')->currency_code." ".currency_convertor($total_shipping,'convert_to_bdt');
            $total_shipping_inr=currency_code('INR')->currency_code." ".currency_convertor($total_shipping,'convert_to_inr');

            return response()->json([
                'total_shipping'=>default_currency()->currency_code." ".$total_shipping,
                'total_shipping_bdt'=>$total_shipping_bdt,
                'total_shipping_inr'=>$total_shipping_inr,
                'status'=>Response::HTTP_OK,
                'type'=>'success'
            ],Response::HTTP_OK);
        }
    }

        public function test(){

            $carts=Cart::where('user_id',auth()->user()->id)->latest()->get();
           //return $carts[0]->product->category->digital_asset;
            $val=check_digital($carts);
            return $val;
        }

        public function update_cart_status(Request $request){


            $this->validate($request,[
                'cart_ids'=>'required'
            ]);
            if ($request->isMethod("post")){
                try {
                    $pattern = '/[\s"]/';
                    $components = preg_split($pattern, $request->cart_ids);
                    $carts=Cart::whereIn('id',array_filter($components,'is_numeric'))->get();

                    foreach ($carts as $cart){
                        $cart->update(['status'=>0]);
                    }
                    return response()->json([
                        'message'=>"Successfully updated",
                        'status'=>Response::HTTP_OK,
                        'type'=>'success'
                    ],Response::HTTP_OK);

                }catch (QueryException $exception){
                    return response()->json([
                        'message'=>$exception->getMessage(),
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                        'type'=>'success'
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }


        }
}
