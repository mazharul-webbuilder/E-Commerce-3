<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\DashboardController;
use App\Http\Controllers\Affiliate\LoginController;
use App\Http\Controllers\Affiliate\ManageProductController;






Route::group([ 'as'=>'affiliate.'],function(){

    Route::get('login',[LoginController::class,'show_form'])->name('login.show');
    Route::post('show_form_submit',[LoginController::class,'show_form_submit'])->name('show_form_submit');
    Route::post('logout',[LoginController::class,'logout'])->name('logout');
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

    // Manage product

    Route::group(['prefix'=>'product'],function (){
        Route::get('product_load',[ManageProductController::class,'datatable'])->name('product.load');
        Route::get('/',[ManageProductController::class,'index'])->name('product.index');
        Route::get('/store',[ManageProductController::class,'index'])->name('product.store');
    });

});
