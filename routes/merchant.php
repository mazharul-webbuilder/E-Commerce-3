<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\LoginController;
use App\Http\Controllers\Merchant\ProductController;



Route::get('login',[LoginController::class,'show_form'])->name('merchant.login.show');
Route::post('show_form_submit',[LoginController::class,'show_form_submit'])->name('merchant.show_form_submit');
Route::post('logout',[LoginController::class,'logout'])->name('merchant.logout');
Route::get('dashboard',[DashboardController::class,'index'])->name('merchant.dashboard');

//manage product
Route::group(['prefix'=>'product', 'as'=>'merchant.'],function(){

    Route::get('product_load',[ProductController::class,'datatable'])->name('product.load');
    Route::get('/',[ProductController::class,'index'])->name('product.index');


});


