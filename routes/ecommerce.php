<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\EcommerceController;


Route::post('merchant_register',[RegisterController::class,'merchant_register']);
Route::post('seller_register',[RegisterController::class,'seller_register']);
Route::post('affiliate_register',[RegisterController::class,'affiliate_register']);



//category
Route::get('/get_categories', [EcommerceController::class, 'get_category']);
Route::get('product_detail/{id}/{seller_or_affiliate?}/{type?}', [EcommerceController::class, 'product_detail'])->name('api.product_detail');
