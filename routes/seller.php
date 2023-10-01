<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\LoginController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ManageProductController;





Route::group([ 'as'=>'seller.'],function(){

    Route::get('login',[LoginController::class,'showForm'])->name('login.show');
    Route::post('login',[LoginController::class,'formSubmit'])->name('login.submit');
    Route::post('logout',[LoginController::class,'sellerLogout'])->name('logout');

    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::group(['prefix'=>'product'],function (){
        Route::get('product_load',[ManageProductController::class,'datatable'])->name('product.load');
        Route::get('/',[ManageProductController::class,'index'])->name('product.index');
    });




});
