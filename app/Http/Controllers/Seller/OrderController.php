<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Load Order Page that order has seller product
    */
    public function index(): View
    {
        return \view('seller.order.index');
    }

    /**
     * Load Data
    */
    public function datatable():JsonResponse
    {
        $sellerOrders = Order::with('order_detail')->whereHas('order_detail', function ($query){
            $query->where('sell_type', 'seller')->where('seller_id', auth()->guard('seller')->user()->id);
        })->get();

        return DataTables::of($sellerOrders)
            ->addIndexColumn()
            ->addColumn('product_quantity', function ($sellerOrder){
                return $sellerOrder->seller_order_detail->sum('product_quantity');
            })
            ->addColumn('order_date', function ($sellerOrder){
                return Carbon::parse($sellerOrder->created_at)->format('d-m-Y');
            })
            ->addColumn('view_my_products', function ($sellerOrder){
                return '<a href="'.route('seller.ordered.products', $sellerOrder->id).'"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View Ordered Products
                        </a>';
            })
            ->rawColumns(['product_quantity', 'order_date', 'view_my_products'])
            ->make('true');
    }

    /**
     * Ordered Product of Seller
    */
    public function orderedProducts($id): View
    {
        $order = Order::find($id);

        return \view('seller.order.ordered_products', compact('order'));
    }
}
