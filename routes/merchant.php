<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\LoginController;
use App\Http\Controllers\Merchant\ProductController;
use App\Http\Controllers\Merchant\StockController;
use App\Http\Controllers\Merchant\GalleryController;



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
    Route::get('/get-product-meta-info',[ProductController::class,'getMetaInfo'])->name('product.flash-deal');
    Route::post('/store-flash-deal',[ProductController::class,'storeFlashDeal'])->name('product.flash-deal.store');
    Route::get('/control-panel',[ProductController::class,'controlPanel'])->name('product.control.panel');
    Route::get('/get-product',[ProductController::class,'getProduct'])->name('product');
    Route::post('/delete',[ProductController::class,'delete'])->name('product.delete');
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


