<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\LoginController;
use App\Http\Controllers\Merchant\ProductController;
use App\Http\Controllers\Merchant\StockController;
use App\Http\Controllers\Merchant\GalleryController;
use App\Http\Controllers\Merchant\OrderController;
use App\Http\Controllers\Merchant\WithdrawController;
use App\Http\Controllers\Merchant\ShopController;
use App\Http\Controllers\Merchant\ConnectionWithUserAccountController;



Route::get('login',[LoginController::class,'show_form'])->name('merchant.login.show');
Route::post('show_form_submit',[LoginController::class,'show_form_submit'])->name('merchant.show_form_submit');
/*Merchant Authenticate Routes*/
Route::middleware('merchant')->group(function (){
    Route::post('logout',[LoginController::class,'logout'])->name('merchant.logout');
    Route::get('dashboard',[DashboardController::class,'index'])->name('merchant.dashboard');
    Route::get('profile',[DashboardController::class,'profile'])->name('merchant.profile');
    Route::post('update_profile',[DashboardController::class,'update_profile'])->name('merchant.update_profile');

});
//manage product
Route::group(['prefix'=>'product', 'as'=>'merchant.'],function(){
    Route::post('/find_sub_category', [ProductController::class, 'find_sub_category'])->name('find_sub_category');
    Route::get('product_load',[ProductController::class,'datatable'])->name('product.load');
    Route::get('/',[ProductController::class,'index'])->name('product.index');
    Route::get('/create',[ProductController::class,'create'])->name('product.create');
    Route::post('/store',[ProductController::class,'store'])->name('product.store');
    Route::get('/view/{slug}',[ProductController::class,'view'])->name('product.view');
    Route::get('/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::post('/update',[ProductController::class,'update'])->name('product.update');
    Route::post('/status-update',[ProductController::class,'updateStatus'])->name('product.status.change');
    Route::get('/get-product-meta-info',[ProductController::class,'getMetaInfo'])->name('product.flash-deal');
    Route::post('/store-flash-deal',[ProductController::class,'storeFlashDeal'])->name('product.flash-deal.store');
    Route::get('/control-panel',[ProductController::class,'controlPanel'])->name('product.control.panel');
    Route::get('/get-product',[ProductController::class,'getProduct'])->name('product');
    Route::get('/delete',[ProductController::class,'delete'])->name('product.delete');
});

//Shop
Route::group(['as' => 'merchant.'], function (){
    Route::get('/shop', [ShopController::class, 'myShop'])->name('shop.index');
    Route::get('/product/details/{id}', [ShopController::class, 'productDetails'])->name('product.detail');

});

// Stock route
Route::group(['prefix' => 'stock', 'as' => 'merchant.'], function () {
    Route::get('/{product_id}', [StockController::class, 'index'])->name('stock.index');
    Route::post('/store', [StockController::class, 'store'])->name('stock.store');
    Route::get('/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
    Route::post('/update', [StockController::class, 'update'])->name('stock.update');
    Route::post('/delete', [StockController::class, 'delete'])->name('stock.delete');
});

// Gallery route
Route::group(['prefix' => 'gallery', 'as' => 'merchant.'], function () {
    Route::get('/{product_id}', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::post('/update', [GalleryController::class, 'update'])->name('gallery.update');
    Route::post('/delete', [GalleryController::class, 'delete'])->name('gallery.delete');
});

// order route
Route::group(['prefix' => 'order', 'as' => 'merchant.'], function () {
    Route::get('order_load',[OrderController::class,'datatable'])->name('order.load');
    Route::get('/',[OrderController::class,'index'])->name('order.index');
    Route::get('/details/{id}',[OrderController::class,'details'])->name('order.details');
});

// Withdraw
Route::group(['as' => 'merchant.'], function (){
    Route::get('/withdraw/history', [WithdrawController::class, 'index'])->name('withdraw.history');
    Route::get('/withdraw/history/load', [WithdrawController::class, 'datatable'])->name('withdraw.history.load');
    Route::get('/withdraw/request', [WithdrawController::class, 'withdrawRequest'])->name('withdraw.request');
    Route::post('/withdraw/request', [WithdrawController::class, 'withdrawRequestPost'])->name('withdraw.request.post');
});

// Shop
Route::group(['as' => 'merchant.'], function (){
    Route::get('/shop/setting', [ShopController::class, 'setting'])->name('shop.setting');
    Route::post('/shop/setting', [ShopController::class, 'settingPost'])->name('shop.setting');
});

// Connection with user account
Route::group(['as' => 'merchant.'], function (){
    Route::get('/connect/with/user/account', [ConnectionWithUserAccountController::class, 'index'])->name('connect.with.user.account');
    Route::post('/connect/with/user/account', [ConnectionWithUserAccountController::class, 'sendVerificationCode'])->name('connect.with.user.account');
    Route::post('verify/account', [ConnectionWithUserAccountController::class, 'verifyCode'])->name('connect.with.user.account.verify');


    Route::get('/connected/user/account', [ConnectionWithUserAccountController::class, 'connectedAccount'])->name('connected.user.account');
});




