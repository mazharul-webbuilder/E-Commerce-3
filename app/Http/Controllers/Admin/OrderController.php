<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Myorderhistory;
use App\Http\Resources\Orderdetails;
use App\Models\Affiliate\Affiliator;
use App\Models\Merchant\Merchant;
use App\Models\OrderCoinHistory;
use App\Models\Seller\Seller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Stock;
use App\Models\Ecommerce\Product;
use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order_detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{


    /**
     * Admin Orders
    */
    public function index($type = null): View
    {
        if ($type !== null) {
            if ($type === ORDER_TYPE[0]) {
                // return $orders = Order::with('user')->latest()->get();
                $orders = Order::with('user:id,name,playerid')->latest()->get();
            } elseif ($type === ORDER_TYPE[1]) {
                $orders = Order::where('status', $type)->latest()->get();
            } elseif ($type === ORDER_TYPE[2]) {
                $orders = Order::where('status', $type)->latest()->get();
            } elseif ($type === ORDER_TYPE[3]) {
                $orders = Order::where('status', $type)->latest()->get();
            } elseif ($type === ORDER_TYPE[4]) {
                $orders = Order::where('status', $type)->latest()->get();
            } elseif ($type === ORDER_TYPE[5]) {
                $orders = Order::where('status', $type)->latest()->get();
            }
        } else {
            $orders = Order::latest()->get();
        }

        $date_range = null;

        return view('webend.ecommerce.order.index', compact('orders', 'date_range'));
    }

    /**
     * Show Admin Orders Page
    */
    public function admin_order(): View
    {
        $orders = Order::whereHas('order_detail', function ($query) { // here order_details is relation with Order table product has relation in orderDetails model
            $query->where('merchant_id', null);
        })->get();

        $date_range = null;

        return view('webend.ecommerce.order.admin_order.index', compact('orders', 'date_range'));
    }

    public function search_by_date(Request $request)
    {
        // dd($request->all());
        $orders = Order::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->get();
        $date_range = $request->start_date . "-" . $request->end_date;
        return view('webend.ecommerce.order.index', compact('orders', 'date_range'));
    }


    /**
     * Manage Order
    */
    public function manage_order(Request $request)
    {
        if ($request->isMethod("POST")) {
            $order = Order::find($request->order_id);
            $currentStatus = $order->status;

            // Check if the current status is already "delivered"
            if ($currentStatus !== 'delivered') {
                $order->status = $request->status;
                $order->save();

                if ($request->status == 'shipping') {
                    // Send notification for shipping status
                    $datas = [
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'title' => "Your Order number <b>" . $order->order_number . "</b>  is accepted.",
                        'type' => 'order',
                        'status' => 0
                    ];
                    notification($datas);
                } elseif ($request->status == 'declined') {
                    // Send notification for declined status
                    $datas = [
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'title' => "Your Order number <b>" . $order->order_number . "</b>  is declined.",
                        'type' => 'order',
                        'status' => 0
                    ];
                    notification($datas);
                } elseif ($request->status === "delivered") {
                    $order_details = Order_detail::where('order_id', $order->id)->get();
                    $this->provide_order_commission($request->order_id);

                    if (!empty($order_details)) {
                        // Rest of the code for updating stock, adding coin, and sending notifications
                        $total_coin = 0;
                        foreach ($order_details as $order_detail) {
                            //
                            if (!is_null($order_detail->size_id)) {
                                $stock = Stock::where(['product_id' => $order_detail->product_id, 'size_id' => $order_detail->size_id])
                                    ->first();
                                if (!is_null($stock)) {
                                    $current_stock = $stock->quantity;
                                    $order_stock = $order_detail->product_quantity;
                                    $remain_stock = $current_stock - $order_stock;
                                    $stock->quantity = $remain_stock;
                                    $stock->save();
                                }
                            }
                            // add coin
                            if (is_null($order_detail->seller_id)) {
                                $paidCoin = $order_detail->product_coin;
                            } else {
                                $coinFromSeller = DB::table('seller_products')
                                    ->where(['seller_id' => $order_detail->seller_id, 'product_id' => $order_detail->product_id])
                                    ->value('coin_from_seller');
                                $paidCoin = $order_detail->product_coin + $coinFromSeller;
                            }
                            $total_coin += $paidCoin * $order_detail->product_quantity;
                        }
                        $user = User::find($order->user_id);
                        $user->paid_coin += $total_coin;
                        $user->save();

                        OrderCoinHistory::create([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'provided_coin' => $total_coin
                        ]);

                        // send notification
                        $datas = [
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'title' => "Your Order  number <b>" . $order->order_number . "</b> is delivered.",
                            'type' => 'order',
                            'status' => 0
                        ];

                        notification($datas);

                    } else {
                        // Handle the case when there are no order details
                    }
                }

                return response()->json([
                    'message' => "Successfully Updated",
                    'type' => "success",
                    'status' => 200
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => "The order is already delivered and cannot be changed.",
                    'type' => "error",
                    'status' => 200
                ], Response::HTTP_OK);
            }
        }
    }

    public function provide_order_commission($order_id)
    {
        $order=Order::find($order_id);

        foreach ($order->order_detail as $order_item)
        {
            if ($order_item->merchant_id !=null)
            {
                $product=Product::find($order_item->product_id);
                $merchant=Merchant::find($order_item->merchant_id);
                $total_product_price=$product->price()*$order_item->product_quantity;



                //=============when affiliate and seller not found. only company commission===================
                if ($order_item->affiliator_id==null && $order_item->seller_id==null)
                {
                    //===company commission
                    $company_commission_from_merchant=(($product->price()*$product->company_commission)/100)*$order_item->product_quantity;
                   // return $company_commission_from_merchant;
                    $merchant_will_get=$total_product_price-$company_commission_from_merchant;
                    $merchant->balance=$merchant->balance+$merchant_will_get;
                    $merchant->save();

                }

                //=============seller & company commission===================
                if ($order_item->seller_id !=null)
                {
                    // seller commission from merchant
                    $seller=Seller::find($order_item->seller_id);
                    $seller_commission_from_merchant=(($product->price()*$product->product_commission->reseller_commission)/100)*$order_item->product_quantity;

                    // seller extra earning
                    $seller_product=seller_price($seller->id,$product->id);

                    $product_extra_price=$seller_product->seller_price*$order_item->product_quantity-$product->price()*$order_item->product_quantity;

                    $company_commission_from_seller=$product_extra_price*$seller_product->seller_company_commission/100;

                    $seller_extra_get=$product_extra_price-$company_commission_from_seller;

                    $total_seller_get=$seller_extra_get+$seller_commission_from_merchant;
                    $seller->balance=$seller->balance+$total_seller_get;
                    $seller->save();

                    // merchant will get total amount
                    $company_commission_from_merchant=(($product->price()*$product->company_commission)/100)*$order_item->product_quantity;

                    $total_seller_and_company_commission=$company_commission_from_merchant+$seller_commission_from_merchant;

                    $merchant_will_get=$total_product_price-$total_seller_and_company_commission;
                    //return $merchant_will_get;
                    $merchant->balance=$merchant->balance+$merchant_will_get;
                    $merchant->save();


                }

                //=============affiliate & company commission===================
                if ($order_item->affiliator_id !=null)
                {
                    $affiliate=Affiliator::find($order_item->affiliator_id);

                    // affiliate commission
                    $affiliate_commission_from_merchant=(($product->price()*$product->product_commission->affiliate_commission)/100)*$order_item->product_quantity;
                    $affiliate->balance=$affiliate->balance+$affiliate_commission_from_merchant;
                    $affiliate->save();

                    // company commission
                    $company_commission_from_merchant=(($product->price()*$product->company_commission)/100)*$order_item->product_quantity;
                    $total_affiliate_and_company_commission=$company_commission_from_merchant+$affiliate_commission_from_merchant;

                    $merchant_will_get=$total_product_price-$total_affiliate_and_company_commission;
                   // return $merchant_will_get;
                    $merchant->balance=$merchant->balance+$merchant_will_get;
                    $merchant->save();

                }

            }
        }

    }

    public function my_order()
    {
        $all_orders = Order::where('user_id', Auth::user()->id)->latest()->get();
        $order = Myorderhistory::collection($all_orders);
        return api_response('success', 'All my order List', $order, 200);
    }

    public function my_order_details($id)
    {
        $order_detail = Order_detail::where('order_id', $id)->with('product', 'size')->latest()->get();
        $order['order'] = new Myorderhistory(Order::find($id));
        $order['order_detail'] = Orderdetails::collection($order_detail);

        return api_response('success', 'Order Details of selected Order', $order, 200);
    }

    public function order_detail($id)
    {
        $order = Order::find($id);
        return view('webend.ecommerce.order.order_detail', compact('order'));
    }
    public function order_invoice($id)
    {
        $order = Order::find($id);
        return view('webend.ecommerce.order.order_invoice', compact('order'));
    }
}
