<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EcommerceController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;


Route::post('merchant_register',[RegisterController::class,'merchant_register']);
Route::post('email_verification',[RegisterController::class,'email_verification']);
Route::post('seller_register',[RegisterController::class,'seller_register']);
Route::post('affiliate_register',[RegisterController::class,'affiliate_register']);

//category
Route::get('/get_categories', [EcommerceController::class, 'get_category']);
Route::get('/category_wise_product/{id}', [EcommerceController::class, 'category_wise_product']);
Route::get('/product_list', [EcommerceController::class, 'product_list']);
Route::get('/flash_deal_product', [EcommerceController::class, 'flash_deal_product']);
Route::get('/merchant_product/{merchant_id}', [EcommerceController::class, 'merchant_product']);
Route::get('/recommended_product/{category_ids?}', [EcommerceController::class, 'recommended_product']);
Route::get('product_detail/{id}/{seller_or_affiliate?}/{type?}', [EcommerceController::class, 'product_detail'])->name('api.product_detail');
Route::get('slider_list', [EcommerceController::class, 'slider_list']);
Route::get('banner_list', [EcommerceController::class, 'banner_list']);
Route::post('add_to_wishlist', [EcommerceController::class, 'add_to_wishlist']);
Route::get('view_wishlist', [EcommerceController::class, 'view_wishlist']);
Route::post('delete_wishlist', [EcommerceController::class, 'delete_wishlist']);
Route::post('search_product', [EcommerceController::class, 'search_product']);

//===Authenticate guard=====
Route::group(['middleware'=>'auth:api'],function (){
    Route::post('provide_review',[EcommerceController::class,'provide_review']);
    Route::post('checkout',[CheckoutController::class,'checkout']);
    Route::get('get_payment',[CheckoutController::class,'get_payment']);
    Route::post('shipping_charge',[CheckoutController::class,'shipping_charge']);
});

//cart api

Route::post('add_to_cart', [CartController::class, 'add_to_cart']);
Route::get('view_cart', [CartController::class, 'view_cart']);
Route::post('update_cart', [CartController::class, 'update_cart']);
Route::post('delete_cart', [CartController::class, 'delete_cart']);



