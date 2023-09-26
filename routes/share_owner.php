<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shareOwner\ShareOwnerLoginController;
use App\Http\Controllers\shareOwner\ShareOwnerDashboardController;
use App\Http\Controllers\shareOwner\ShareOwnerController;




Route::get('login',[ShareOwnerLoginController::class,'show_form'])->name('share_owner.login.show');
Route::post('login',[ShareOwnerLoginController::class,'show_form_submit'])->name('share_owner.login.submit');
Route::post('logout',[ShareOwnerLoginController::class,'owner_logout'])->name('share_owner.logout');

Route::get('dashboard',[ShareOwnerDashboardController::class,'index'])->name('share_owner.dashboard');
Route::get('profile',[ShareOwnerDashboardController::class,'profile'])->name('share_owner.profile');
Route::post('update_profile',[ShareOwnerDashboardController::class,'update_profile'])->name('share_owner.update_profile');
Route::get('my_share',[ShareOwnerDashboardController::class,'my_share'])->name('share_owner.my_share');
Route::post('add_destination',[ShareOwnerDashboardController::class,'add_destination'])->name('share_owner.add_destination');
Route::get('share_transfer_history',[ShareOwnerDashboardController::class,'share_transfer_history'])->name('share_owner.share_transfer_history');
Route::post('transfer_share',[ShareOwnerDashboardController::class,'transfer_share'])->name('share_owner.transfer_share');
Route::get('share_balance_withdraw',[ShareOwnerDashboardController::class,'share_balance_withdraw'])->name('share_owner.share_balance_withdraw');
Route::post('share_charge_convert',[ShareOwnerDashboardController::class,'share_charge_convert'])->name('share_owner.share_charge_convert');
Route::post('share_withdraw_request',[ShareOwnerDashboardController::class,'share_withdraw_request'])->name('share_owner.share_withdraw_request');
Route::get('share_withdraw_history',[ShareOwnerDashboardController::class,'share_withdraw_history'])->name('share_owner.share_withdraw_history');
Route::post('purchase_share',[ShareOwnerDashboardController::class,'purchase_share'])->name('share_owner.purchase_share');

// share owner
Route::get('deposit',[ShareOwnerController::class,'deposit'])->name('share_owner.deposit');
Route::post('get_payment_detail',[ShareOwnerController::class,'get_payment_detail'])->name('share_owner.get_payment_detail');
Route::get('deposit_request',[ShareOwnerController::class,'deposit_request'])->name('share_owner.deposit_request');
Route::post('send_deposit_request',[ShareOwnerController::class,'send_deposit_request'])->name('share_owner.send_deposit_request');

// voucher route
Route::get('voucher',[ShareOwnerController::class,'voucher'])->name('share_owner.voucher');
Route::post('voucher_request',[ShareOwnerController::class,'voucher_request'])->name('share_owner.voucher_request');
Route::post('voucher_collect',[ShareOwnerController::class,'voucher_collect'])->name('share_owner.voucher_collect');
Route::post('transfer_voucher',[ShareOwnerController::class,'transfer_voucher'])->name('share_owner.transfer_voucher');
Route::get('transfer_voucher_history',[ShareOwnerController::class,'transfer_voucher_history'])->name('share_owner.transfer_voucher_history');
Route::get('coin_earning_history',[ShareOwnerController::class,'coin_earning_history'])->name('share_owner.coin_earning_history');



