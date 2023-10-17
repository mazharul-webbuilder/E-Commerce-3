<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('merchant');
    }

    public function datatable(){

        $auth_user=Auth::guard('merchant')->user();
        $all_orders=Order::latest()->get();
        $orders=[];
        foreach ($all_orders as $order){
            $order_details=Order_detail::where('order_id',$order->id)->where('merchant_id',$auth_user->id)->get();


            if (count($order_details)>0){
                if ($order_details[0]->order_id==$order->id){

                    $id=$order->id;
                    $quantity=0;
                    $grand_total=0;
                    $order_number=$order->order_number;
                    $status=$order->status;
                    $created_at=$order->created_at;
                    // calculate seller amount and quantity
                    foreach ($order_details as $order_detail){
                        $quantity+=$order_detail->product_quantity;
                        $product=Product::find($order_detail->product_id);
                        if ($order_detail->seller_id==null){
                            $grand_total+=$product->current_price*$order_detail->product_quantity;
                        }else{
                            $grand_total+=seller_price($order_detail->seller_id,$order_detail->product_id)->seller_price*$order_detail->product_quantity;
                        }

                    }
                    $custom_order=array(
                        'id'=>$id,
                        'order_number'=>$order_number,
                        'grand_total'=>$grand_total,
                        'quantity'=>$quantity,
                        'status'=>$status,
                        'created_at'=>$created_at
                    );
                    array_push($orders,$custom_order);
                }
            }
        }

        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('grand_total',function($orders){
                return number_format($orders['grand_total'],2);
            })
            ->editColumn('created_at',function($orders){
                return date("d-m-Y",strtotime($orders['created_at']));
            })
            ->editColumn('action',function($orders){
                return '<a href="'.route('merchant.order.details', $orders['id']).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(){

        return view('merchant.order.index');
    }

    /**
     * Show Order Details Page
    */
    public function details($id): View
    {
        $order = Order_detail::where('order_id', $id)->where('merchant_id', Auth::guard('merchant')->id())->get();

        dd($order);

        return view('merchant.order.details', compact('order'));
    }
}
