<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EcommerceController;
use App\Http\Controllers\Api\CartController;


Route::post('merchant_register',[RegisterController::class,'merchant_register']);
Route::post('seller_register',[RegisterController::class,'seller_register']);
Route::post('affiliate_register',[RegisterController::class,'affiliate_register']);



//category
Route::get('/get_categories', [EcommerceController::class, 'get_category']);
Route::get('/category_wise_product/{id}', [EcommerceController::class, 'category_wise_product']);
Route::get('/product_list', [EcommerceController::class, 'product_list']);
Route::get('/recommended_product/{category_ids?}', [EcommerceController::class, 'recommended_product']);
Route::get('product_detail/{id}/{seller_or_affiliate?}/{type?}', [EcommerceController::class, 'product_detail'])->name('api.product_detail');
Route::get('slider_list', [EcommerceController::class, 'slider_list']);
Route::get('banner_list', [EcommerceController::class, 'banner_list']);

//cart api

Route::post('add_to_cart', [CartController::class, 'add_to_cart']);
Route::get('view_cart', [CartController::class, 'view_cart']);
Route::post('update_cart', [CartController::class, 'update_cart']);
Route::post('delete_cart', [CartController::class, 'delete_cart']);


