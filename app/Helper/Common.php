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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

/*Merchant Order Grand Total*/
function get_merchant_order_grand_total($datas)
{
    $grand_total = 0;

    foreach ($datas as $data){
            $product=Product::find($data->product_id);
            $grand_total+=$product->price()*$data->product_quantity;
    }
    return $grand_total;
}

/*store original and resize image*/
function store_2_type_image_nd_get_image_name($request, $folderName, $resize_width = 256, $resize_height = 200)
{
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $image_name = strtolower(Str::random(10)) . time() . "." . $image->getClientOriginalExtension();

        $original_directory = "uploads/{$folderName}/original";
        $resize_directory = "uploads/{$folderName}/resize";

        if (!File::exists(public_path($original_directory))) {
            File::makeDirectory(public_path($original_directory), 0777, true);
            File::makeDirectory(public_path($resize_directory), 0777, true);
        }
        $original_image_path = public_path("{$original_directory}/{$image_name}");
        $resize_large_path = public_path("{$resize_directory}/{$image_name}");

        Image::make($image)->save($original_image_path);
        Image::make($image)->resize($resize_width, $resize_height)->save($resize_large_path);

        return $image_name;
    }

    return null;
}

/**
 * Delete Origin and Resize Image If Exist
*/
function delete_2_type_image_if_exist($data, $folderName)
{
    $original_image_path = "uploads/{$folderName}/original/{$data->image}";
    $resize_image_path = "uploads/{$folderName}/resize/{$data->image}";

    if (File::exists(public_path($original_image_path))) {
        // Set permissions before deleting (e.g., set to 0644)
        File::chmod(public_path($original_image_path), 0644);
        File::chmod(public_path($resize_image_path), 0644);

        // Delete the files
        File::delete(public_path($original_image_path));
        File::delete(public_path($resize_image_path));
    }
}









