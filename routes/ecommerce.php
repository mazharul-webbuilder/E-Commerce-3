<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;


Route::post('merchant_register',[RegisterController::class,'merchant_register']);
Route::post('seller_register',[RegisterController::class,'seller_register']);
Route::post('affiliate_register',[RegisterController::class,'affiliate_register']);
