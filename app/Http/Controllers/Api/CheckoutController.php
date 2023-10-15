<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Paymentresource;
use App\Models\Ecommerce\Billing;
use App\Models\Ecommerce\Cart;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Payment;
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
    ],Response::HTTP_INTERNAL_SERVER_ERROR);
}

    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address_store_type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'shipping_charge'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->sub_total = Cart::subtotal();
            $order->grand_total = Cart::subtotal()+$request->shipping_charge;;
            $order->quantity = Cart::carts()->sum('quantity');
            $order->order_number = '#OR-'.rand(100000,999999);
            $order->transaction_number = $request->transaction_number;
            $order->order_note = $request->order_note;
            $order->status ='pending';
            $order->created_at = Carbon::now();
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
                $order_details->user_id = Auth::user()->id;
                $order_details->order_id = $order->id;
                $order_details->product_id = $data->product_id;
                $order_details->size_id = $data->size_id;
                $order_details->product_quantity = $data->quantity;
                $order_details->product_price = $data->product->current_price;
                $order_details->product_coin = $data->product->current_coin;
                $order_details->save();
            }
            $biling = new Billing();
            $biling->user_id = Auth::user()->id;
            $biling->order_id =  $order->id;
            $biling->name = $request->name;
            $biling->email = $request->email;
            $biling->phone = $request->phone;
            $biling->address = $request->address;
            $biling->city = $request->city;
            $biling->zip_code = $request->zip_code;
            $biling->created_at = Carbon::now();
            $biling->save();
            if ($request->address_store_type == 'yes')
            {
                Auth::user()->update(['address'=>$request->address]);
            }

            foreach (Cart::carts() as $data)
            {
                $data->delete();
            }
            DB::commit();
            return api_response('success','Checkout complited',null,Response::HTTP_OK);
        }catch (\Exception $ex)
        {
            DB::rollBack();
            $ex->getMessage();
        }
    }
}
