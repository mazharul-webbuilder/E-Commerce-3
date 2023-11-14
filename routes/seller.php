<?php

use App\Http\Controllers\Seller\ConnectionWithUserAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\LoginController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ManageProductController;
use App\Http\Controllers\Seller\RechargeController;
use App\Http\Controllers\Seller\WithdrawController;
use App\Http\Controllers\Seller\BalanceTransferController;
use App\Http\Controllers\Seller\OrderController;


Route::group([ 'as'=>'seller.'],function(){
    /*Authentication Routes*/
    Route::get('login',[LoginController::class,'showForm'])->name('login.show');
    Route::post('login',[LoginController::class,'formSubmit'])->name('login.submit');

    /*Seller Authenticate Routes*/
    Route::middleware('seller')->group(function (){
        Route::post('logout',[LoginController::class,'sellerLogout'])->name('logout');
        Route::get('dashboard',[DashboardController::class,'index'])->name('seller.dashboard');
        Route::get('profile',[DashboardController::class,'profile'])->name('profile');
        Route::post('update_profile',[DashboardController::class,'update_profile'])->name('update_profile');

    });

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
        Route::get('/detail/{id}',[ManageProductController::class,'merchantProductDetail'])->name('merchant.product.details');
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
    Route::post('/withdraw/request', [WithdrawController::class, 'withdrawRequestPost'])->name('withdraw.request.post');


// Connection with user account
    Route::get('/connect/with/user/account', [ConnectionWithUserAccountController::class, 'index'])->name('connect.with.user.account');
    Route::post('/connect/with/user/account', [ConnectionWithUserAccountController::class, 'sendVerificationCode'])->name('connect.with.user.account');
    Route::post('verify/account', [ConnectionWithUserAccountController::class, 'verifyCode'])->name('connect.with.user.account.verify');
    /*Connect Account*/
    Route::get('/connected/user/account', [ConnectionWithUserAccountController::class, 'connectedAccount'])->name('connected.user.account');
    Route::post('/disconnect/user/account', [ConnectionWithUserAccountController::class, 'userDisconnect'])->name('account.discount');
    /*Balance Transfer history to user*/
    Route::get('/get/seller/balance/transfer/history/{userId}', [BalanceTransferController::class, 'datatable'])->name('balance.transfer.history');

    /*Order Module*/
    Route::prefix('order/')->group(function (){
        Route::get('all', [OrderController::class, 'index'])->name('orders');
        Route::get('datatable', [OrderController::class, 'datatable'])->name('order.load');
    });
});
