<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Paymentresource;
use App\Models\Ecommerce\Billing;
use App\Models\Ecommerce\Cart;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Payment;
use App\Models\Ecommerce\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CheckoutController extends Controller
{


public function get_payment(){
    $datas = Payment::where('status',1)->get();
    $payments=  Paymentresource::collection($datas);
    return response()->json([
        'payments'=>$payments,
        'status'=>200,
        'type'=>'success'
    ],Response::HTTP_OK);
}

public function shipping_charge(Request $request){
    $request->validate([
        'shipping_type' => 'required',
    ]);
    if ($request->isMethod("post")){
        $carts=Cart::where('user_id',auth()->user()->id)
            ->groupBy('product_id')
            ->get();

        $total_shipping=calculate_shipping_charge($carts,$request->shipping_type);

        return response()->json([
            'total_charge'=>$total_shipping,
            'status'=>Response::HTTP_OK,
            'type'=>'success',
        ],Response::HTTP_OK);
    }
}

    public function checkout(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'shipping_charge'=>'required',
            'transaction_number'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $user=auth()->user();

            $order = new Order();
            $order->user_id = $user->id;
            $order->sub_total = Cart::subtotal();
            $order->grand_total = Cart::subtotal()+$request->shipping_charge;;
            $order->quantity = Cart::carts()->sum('quantity');
            $order->order_number = '#OR-'.rand(100000,999999);
            $order->transaction_number = $request->transaction_number;
            $order->order_note = $request->order_note;
            $order->status ='pending';
            $order->payment_id  = $request->payment_id;
            $order->shipping_charge  = $request->shipping_charge;
            if ($request->image != null)
            {
                $path = public_path('uploads/order/');
                if (! File::exists($path)) {
                    File::makeDirectory($path);
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move($path, $imageName);
                $order->image = 'uploads/order/'.$imageName;
            }
            $order->save();

            foreach (Cart::carts() as $data)
            {
                $order_details = new Order_detail();
                $order_details->user_id = $user->id;
                $order_details->order_id = $order->id;
                $order_details->product_id = $data->product_id;
                $order_details->size_id = $data->size_id;
                $order_details->product_quantity = $data->quantity;
                $order_details->product_coin = $data->product->current_coin;
                $order_details->merchant_id=Product::find($data->product_id)->merchant_id;

                if ($data->seller_id !=null){
                    $order_details->seller_id=$data->seller_id;
                    $order_details->sell_type='seller';
                    $order_details->product_price=seller_price($data->seller_id,$data->product_id)->seller_price;

                }

                if ($data->affiliator_id !=null){
                    $order_details->affiliator_id=$data->affiliator_id;
                    $order_details->sell_type='affiliate';
                    $order_details->product_price = $data->product->current_price;

                }

                if ($data->affiliator_id ==null && $data->seller_id ==null){
                    $order_details->sell_type='normal';
                    $order_details->product_price = $data->product->current_price;

                }
                $order_details->save();
            }
            $biling = new Billing();
            $biling->user_id = $user->id;
            $biling->order_id =  $order->id;
            $biling->name = $request->name;
            $biling->email = $request->email;
            $biling->phone = $request->phone;
            $biling->address = $request->address;
            $biling->city = $request->city;
            $biling->zip_code = $request->zip_code;
            $biling->save();

//            if ($request->address_store_type == 'yes')
//            {
//                Auth::user()->update(['address'=>$request->address]);
//            }

            foreach (Cart::carts() as $data)
            {
                $data->delete();
            }
            DB::commit();
            return response()->json([
                'message'=>"Order placed successfully",
                'status'=>Response::HTTP_OK,
                'type'=>'success',
            ],Response::HTTP_OK);
        }catch (\Exception $ex)
        {
            DB::rollBack();
            $ex->getMessage();
            return response()->json([
                'message'=>$ex,
                'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                'type'=>'success',
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
