<?php

use App\Models\DueProduct;
use App\Models\Ecommerce\Product;
use App\Models\Seller\Seller;
use App\Models\Merchant\Merchant;
use App\Models\Affiliate\Affiliator;
use Carbon\Carbon;
use App\Models\SellerProduct;
use App\Models\Ecommerce\Review;
use Illuminate\Support\Facades\DB;

function default_image()
{
    return asset('uploads/default.png');
}

function seller($seller_number)
{
    return Seller::where('seller_number',$seller_number)->first();
}
function merchant($merchant_number)
{
    return Merchant::where('seller_number',$merchant_number)->first();
}

function affiliator($affiliate_number)
{
    return Affiliator::where('affiliate_number',$affiliate_number)->first();
}

function product_price($product_id){

    $product=Product::find($product_id);
    $price=0;
    $today=Carbon::now()->format('d-m-Y');
    if ($product->flash_deal==1){
        if ($product->deal_start_date>=$today && $product->deal_end_date<=$today){
            if ($product->deal_type=='flat'){
                $price=$product->current_price-$product->deal_amount;
            }else{
                $commission=($product->current_price*$product->deal_amount)/100;
                $price=$product->current_price-$commission;
            }
        }else{
            $price=$product->current_price;
        }
    }else{
        $price=$product->current_price;
    }

    return $price;

}

 function seller_price($seller_id,$product_id)
{
    return SellerProduct::where(['seller_id'=>$seller_id,'product_id'=>$product_id])->first();
}

function average_review($product_id){
    $reviews=Review::where(['status'=>1,'product_id'=>$product_id])->get();

    if (count($reviews)>0){
        $total_ratting=$reviews->sum('ratting');
        $average=$total_ratting/count($reviews);
        return $average;
    }else{
        return 0;
    }

}


function seller_due_product($product_id){
    try {
        DB::beginTransaction();
        /*Get Product id from event*/
        $product = Product::find($product_id);
        /*Find all sellers who added this product on their store*/
        $sellers_ids = SellerProduct::where('product_id', $product_id)->pluck('seller_id');

        /*Give Every Seller a Due Point*/
        foreach ($sellers_ids as $seller_id) {
            $due_product = new DueProduct();
            $due_product->seller_id = $seller_id;
            $due_product->merchant_id = $product->merchant->id;
            $due_product->save();
        }
        /*Delete all product that seller added their store*/
        SellerProduct::where('product_id', $product_id)->delete();

        DB::commit();
    } catch (\Exception $exception) {
        DB::rollBack();
    }
}










