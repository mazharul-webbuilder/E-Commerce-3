<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\LoginController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ManageProductController;
use App\Http\Controllers\Seller\RechargeController;
use App\Http\Controllers\Seller\WithdrawController;


Route::group([ 'as'=>'seller.'],function(){
    /*Authentication Routes*/
    Route::get('login',[LoginController::class,'showForm'])->name('login.show');
    Route::post('login',[LoginController::class,'formSubmit'])->name('login.submit');
    Route::post('logout',[LoginController::class,'sellerLogout'])->name('logout');

    /*Dashboard*/
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

    /*Products*/
    Route::group(['prefix'=>'product'],function (){
        Route::get('product_load',[ManageProductController::class,'datatable'])->name('product.load');
        Route::get('/',[ManageProductController::class,'index'])->name('product.index');
        Route::post('/add_to_store',[ManageProductController::class,'add_to_store'])->name('product.add_to_store');
        Route::get('/shop_product_load',[ManageProductController::class,'shop_datatable'])->name('shop.product.load');
        Route::get('/shop',[ManageProductController::class,'shop'])->name('product.shop');
        Route::get('/details',[ManageProductController::class,'details'])->name('product.details');
        Route::post('/store-config',[ManageProductController::class,'configStore'])->name('product.config.store');
        Route::get('/view-product/{id}',[ManageProductController::class,'viewProduct'])->name('product.view');
        Route::get('/delete-product',[ManageProductController::class,'deleteProduct'])->name('product.delete');
        Route::get('/merchant/detail/{id}',[ManageProductController::class,'merchantProductDetail'])->name('merchant.product.details');
    });
    /*Seller Balance Recharge*/
    Route::get('/recharge/history', [RechargeController::class, 'index'])->name('recharge.history');
    Route::get('/datatable', [RechargeController::class, 'datatable'])->name('recharge.history.load');
    Route::get('/recharge/request', [RechargeController::class, 'recharge'])->name('recharge.page');
    Route::get('/payment/details', [RechargeController::class, 'paymentDetails'])->name('payment.details');
    Route::post('/recharge/store', [RechargeController::class, 'rechargePost'])->name('recharge.post');

    /*Seller Balance Withdraw*/
    Route::get('/withdraw/history', [WithdrawController::class, 'index'])->name('withdraw.history');
    Route::get('/withdraw/history/load', [WithdrawController::class, 'datatable'])->name('withdraw.history.load');
    Route::get('/withdraw/request', [WithdrawController::class, 'withdrawRequest'])->name('withdraw.request');
});
