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
    Route::get('/create',[ProductController::class,'create'])->name('product.create');
    Route::post('/store',[ProductController::class,'store'])->name('product.store');
    Route::get('/view/{slug}',[ProductController::class,'view'])->name('product.view');
    Route::get('/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::post('/update',[ProductController::class,'update'])->name('product.update');
    Route::post('/status-update',[ProductController::class,'updateStatus'])->name('product.status.change');
    Route::post('/delete',[ProductController::class,'delete'])->name('product.delete');


});


