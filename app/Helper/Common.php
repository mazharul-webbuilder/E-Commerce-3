<?php

use App\Mail\VerifyAccount;
use App\Models\DueProduct;
use App\Models\Ecommerce\Product;
use App\Models\Seller\Seller;
use \App\Models\VerificationCode;
use App\Models\Merchant\Merchant;
use App\Models\Affiliate\Affiliator;
use Carbon\Carbon;
use App\Models\SellerProduct;
use App\Models\Ecommerce\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Ecommerce\Order_detail;
use App\Mail\Sendmail;

const MERCHANT_RANK=['vim'=>"VIM",'mim'=>"MIM",'sim'=>"SIM"];

/**
 * Used In Forget Password user type
 * when request for password reset
*/
const FORGET_PASSWORD_BY=[
    'admin' => "admin",
    'merchant' => "merchant",
    'seller' => "seller",
    'affiliator' => "affiliator",
    'shareOwner' => "shareOwner",
    'clubOwner' => "clubOwner"
];

const ECOMMERCE_BALANCE_DESTINATION=['merchant_to_user'=>'merchant_to_user','seller_to_user'=>'seller_to_user','affiliate_to_user'=>'affiliate_to_user',
    'user_to_merchant'=>'user_to_merchant','user_to_seller'=>'user_to_seller','user_to_affiliate'=>'user_to_affiliate'
];

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


/**
 * Delete Origin and Resize Image If Exist Latest
 */
function delete_2_type_image_if_exist_latest($imageName, $folderName)
{
    $original_image_path = "uploads/{$folderName}/original/{$imageName}";
    $resize_image_path = "uploads/{$folderName}/resize/{$imageName}";

    if (File::exists(public_path($original_image_path))) {
        // Set permissions before deleting (e.g., set to 0644)
        File::chmod(public_path($original_image_path), 0644);
        File::chmod(public_path($resize_image_path), 0644);

        // Delete the files
        File::delete(public_path($original_image_path));
        File::delete(public_path($resize_image_path));
    }
}
 function merchant_ratting($merchant_id){

    $reviews=Review::where(['merchant_id'=>$merchant_id,'status'=>1])->get();

    if (count($reviews)>0){
        $total_ratting=$reviews->sum('ratting');
        $average_ratting=$total_ratting/count($reviews);
        $review_detail=['average_ratting'=>$average_ratting,'total_ratting'=>$total_ratting,'ranking'=>merchant_ranking($merchant_id)];
    }else{
        $review_detail=['average_ratting'=>0,'total_ratting'=>0, 'ranking'=>null];
    }
    return $review_detail;

 }
 function merchant_ranking($merchant_id){
        $merchant_sold=Order_detail::where('merchant_id',$merchant_id)->whereHas('order',function ($data){
            $data->where('status','delivered');
        })->count();
//     $merchant_sell=DB::table('order_details')->join('orders','order_details.order_id','=','orders.id')
//         ->where('orders.status','=','delivered')
//         ->where('merchant_id',$merchant_id)
//         ->select(DB::raw('count(order_details.id) as total_sold'))
//         ->get();

    if ($merchant_sold<=0){
        return "New Comer";
    }elseif ($merchant_sold >=1 && $merchant_sold<=10){
         return "VIP";
    }elseif ($merchant_sold >=11 && $merchant_sold<=20){
        return "MIP";
    }elseif ($merchant_sold >=21 && $merchant_sold<=30){
        return "SIP";
    }
 }


 function send_mail($data,$to_mail){
     Mail::to($to_mail)->send(new VerifyAccount($data));
 }
 function mail_template($data,$to_mail){
     Mail::to($to_mail)->send(new Sendmail($data));
 }
 /**
  * Get random verification code
 */
 if (!function_exists('getVerificationCode')) {
     function getVerificationCode(): int
     {
         $verificationCode = rand(min: 100000, max:  999999);
         if (DB::table('verification_codes')->where('verify_code', $verificationCode)->exists()) {
             return getVerificationCode();
         }
         return $verificationCode;
     }
 }

 /**
  * Check is Merchant | Seller | Affiliator Connected with User account
 */
 if (!function_exists('isConnectedWithUserAccount')) {
     function isConnectedWithUserAccount(string $userType): bool
     {
        switch ($userType) {
            case 'merchant':
                $merchant = get_auth_merchant();
                return isset($merchant->user_id);
            case 'seller':
                $seller = get_auth_seller();
                return isset($seller->user_id);
            case 'affiliator':
                $affiliator = get_auth_affiliator();
                return isset($affiliator->user_id);
        }
        return false;
     }
 }

 /**
  * Send Verification Code
 */
 if (!function_exists('sendVerificationCode'))
 {
     function sendVerificationCode($request): bool
     {
         try {
             $userEmail = DB::table('users')->where('playerid', $request->playerId)->value('email');

             $verificationCode = getVerificationCode();

             $data = [
                 'subject' => config('app.name') . ' ' . "User Account Connect Verification Code",
                 'body' => "<h2>Greeting From Netelmart</h2>
                        <p>User Account connection Verification code $verificationCode</p>
                        <p>Please don't share this code to anyone.</p>
                        <p>Have a Good Day!</p>
                        "
             ];
             mail_template(data: $data, to_mail: $userEmail);
             DB::beginTransaction();
             DB::table('verification_codes')->insert([
                 'type' => 'email',
                 'email_or_phone' => $userEmail,
                 'verify_code' => $verificationCode,
                 'created_at' => \Illuminate\Support\Carbon::now(),
                 'updated_at' => \Illuminate\Support\Carbon::now(),
             ]);
             DB::commit();

             return true;

         } catch (\Exception $exception) {
             DB::rollBack();
             return false;
         }

     }
 }

 /**
  * Verify Code Universal Function for this application
 */
 if (!function_exists('verifyCode')){
     function verifyCode(int $verifyCode): bool
     {
         try {
             DB::beginTransaction();
             $verifyCode = VerificationCode::where('verify_code', $verifyCode)->first();
             if (isset($verifyCode)) {
                 $verifyCode->delete();
                 DB::commit();
                 return true;
             } else {
                 return false;
             }
         } catch (\Exception $exception) {
             return false;
         }
     }
 }










