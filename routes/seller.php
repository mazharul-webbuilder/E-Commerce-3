<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\LoginController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ManageProductController;


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
    });
});
