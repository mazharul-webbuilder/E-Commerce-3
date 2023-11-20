<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('merchant');
    }

    /**
     * Merchant Order Page
    */
    public function index(): View
    {
        $date_range = null;

        return view('merchant.order.index', compact('date_range'));
    }

    /**
     * Merchant Order Datatable
    */
    public function datatable(Request $request):JsonResponse
    {
        $filter = ['all', 'pending', 'processing', 'shipping', 'delivered', 'declined'];

        $request->validate(['filter' => Rule::in($filter)]);

        $auth_user=Auth::guard('merchant')->user();

        $orders = null;

        if (in_array($request->filter, $filter)) {
            if ($request->filter == 'all') {
                $orders = Order::whereHas('order_detail', function ($query) use ($auth_user) {
                    $query->where('merchant_id',$auth_user->id);
                })->get();
            } else {
                $orders = Order::whereHas('order_detail', function ($query) use ($auth_user, $request) {
                    $query->where('merchant_id',$auth_user->id)->where('status', $request->filter);
                })->get();
            }
        }
        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('grand_total',function(Order $order) use($auth_user){
                $datas=Order_detail::where(['order_id'=>$order->id,'merchant_id'=>$auth_user->id])->get();

               return get_merchant_order_grand_total($datas);
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
                return '<a href="'.route('merchant.order.details', $orders['id']).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">View</a>';
            })
            ->rawColumns(['grand_total','order_quantity','action'])
            ->make(true);
    }


    /**
     * Show Order Details Page
    */
    public function details($id): View
    {
        $orderDetails = Order_detail::where('order_id', $id)->where('merchant_id', Auth::guard('merchant')->id())->get();

        return view('merchant.order.details', compact('orderDetails'));
    }
}
