<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\LoginController;
use App\Http\Controllers\Seller\DashboardController;


Route::get('login',[LoginController::class,'showForm'])->name('seller.login.show');
Route::post('login',[LoginController::class,'formSubmit'])->name('seller.login.submit');
Route::post('logout',[LoginController::class,'sellerLogout'])->name('seller.logout');

Route::get('dashboard',[DashboardController::class,'index'])->name('seller.dashboard');
