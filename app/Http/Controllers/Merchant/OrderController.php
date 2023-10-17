<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Product;
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

        $orders = Order::whereHas('order_detail', function ($query) use ($auth_user) {
            $query->where('merchant_id',$auth_user->id);
        })->get();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('grand_total',function(Order $order) use($auth_user){
                $datas=Order_detail::where(['order_id'=>$order->id,'merchant_id'=>$auth_user->id])->get();
                $grand_total=0;
               foreach ($datas as $data){
                        if ($data->seller_id==null){
                            $product=Product::find($data->product_id);
                            $grand_total+=$product->current_price*$data->product_quantity;
                       }else{
                           $grand_total+=seller_price($data->seller_id,$data->product_id)->seller_price*$data->product_quantity;
                        }
               }
               return $grand_total;
            })
            ->editColumn('order_quantity',function(Order $order) use($auth_user){
                $datas=Order_detail::where(['order_id'=>$order->id,'merchant_id'=>$auth_user->id])->get();
                $quantity=0;
                foreach ($datas as $data){
                    $quantity+=$data->product_quantity;
                }
                return $quantity;
            })
            ->editColumn('created_at',function($orders){
                return date("d-m-Y",strtotime($orders['created_at']));
            })
            ->editColumn('action',function($orders){
                return '<a href="" class="btn btn-dark btn-sm">View</a>';
            })
            ->rawColumns(['grand_total','order_quantity','action'])
            ->make(true);
    }
    public function index(){

        return view('merchant.order.index');
    }
}
