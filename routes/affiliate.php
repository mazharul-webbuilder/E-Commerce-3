<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\DashboardController;
use App\Http\Controllers\Affiliate\LoginController;



Route::get('login',[LoginController::class,'show_form'])->name('affiliate.login.show');
Route::post('show_form_submit',[LoginController::class,'show_form_submit'])->name('affiliate.show_form_submit');
Route::post('logout',[LoginController::class,'logout'])->name('affiliate.logout');
Route::get('dashboard',[DashboardController::class,'index'])->name('affiliate.dashboard');


