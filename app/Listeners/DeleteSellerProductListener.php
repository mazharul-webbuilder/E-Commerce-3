<?php

namespace App\Listeners;

use App\Events\MerchantProductStatusChangeEvent;
use App\Models\DueProduct;
use App\Models\Ecommerce\Product;
use App\Models\SellerProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeleteSellerProductListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MerchantProductStatusChangeEvent  $event
     * @return void
     */
    public function handle(MerchantProductStatusChangeEvent $event)
    {
        try {
            DB::beginTransaction();
            /*Get Product id from event*/
            $productId = $event->product_id;
            $product = Product::find($productId);
            /*Find all sellers who added this product on their store*/
            $sellers_ids = SellerProduct::where('product_id', $productId)->pluck('seller_id');

            /*Give Every Seller a Due Point*/
            foreach ($sellers_ids as $seller_id) {
                $due_product = new DueProduct();
                $due_product->seller_id = $seller_id;
                $due_product->merchant_id = $product->merchant->id;
                $due_product->save();
            }
            /*Delete all product that seller added their store*/
            SellerProduct::where('product_id', $productId)->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }


}
