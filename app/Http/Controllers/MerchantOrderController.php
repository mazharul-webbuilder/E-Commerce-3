<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MerchantOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Merchant Orders
    */
    public function merchantOrder(): View
    {
        $orders = Order::whereHas('order_detail', function ($query) { // here order_details is relation with Order table product has relation in orderDetails model
            $query->where('merchant_id','!=', null);
        })->get();

        $date_range = null;

        return view('webend.ecommerce.order.admin_order.index', compact('orders', 'date_range'));
    }
}
