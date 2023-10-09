<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EcommerceController;


Route::post('merchant_register',[RegisterController::class,'merchant_register']);
Route::post('seller_register',[RegisterController::class,'seller_register']);
Route::post('affiliate_register',[RegisterController::class,'affiliate_register']);



//category
Route::get('/get_categories', [EcommerceController::class, 'get_category']);
Route::get('/category_wise_product/{id}', [EcommerceController::class, 'category_wise_product']);
Route::get('/product_list', [EcommerceController::class, 'product_list']);
Route::get('product_detail/{id}/{seller_or_affiliate?}/{type?}', [EcommerceController::class, 'product_detail'])->name('api.product_detail');
Route::get('product_detail/{id}/{seller_or_affiliate?}/{type?}', [EcommerceController::class, 'product_detail'])->name('api.product_detail');
Route::post('add_to_cart', [EcommerceController::class, 'add_to_cart']);
