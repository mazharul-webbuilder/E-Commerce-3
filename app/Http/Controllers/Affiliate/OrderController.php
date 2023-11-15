<?php

namespace App\Http\Controllers\Affiliate;

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
        $this->middleware('affiliate');
    }

    /**
     * Load Order Page that order has affiliate product
     */
    public function index(): View
    {
        return \view('affiliate.order.index');
    }

    /**
     * Load Data
     */
    public function datatable():JsonResponse
    {
        $affiliateOrders = Order::with('order_detail')->whereHas('order_detail', function ($query){
            $query->where('sell_type', 'affiliate')->where('affiliator_id', auth()->guard('affiliate')->user()->id);
        })->get();

        return DataTables::of($affiliateOrders)
            ->addIndexColumn()
            ->addColumn('product_quantity', function ($affiliateOrder){
                return $affiliateOrder->affiliator_order_detail->sum('product_quantity');
            })
            ->addColumn('order_date', function ($affiliateOrder){
                return Carbon::parse($affiliateOrder->created_at)->format('d-m-Y');
            })
            ->addColumn('view_my_products', function ($affiliateOrder){
                return '<a href="'.route('affiliate.ordered.products', $affiliateOrder->id).'"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View Ordered Products
                        </a>';
            })
            ->rawColumns(['product_quantity', 'order_date', 'view_my_products'])
            ->make('true');
    }

    /**
     * Ordered Product of affiliate
     */
    public function orderedProducts($id): View
    {
        $order = Order::find($id);

        return \view('affiliate.order.ordered_products', compact('order'));
    }
}
