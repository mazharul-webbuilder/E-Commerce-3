<?php

use App\Http\Controllers\ClubOwner\OwnerDashboardController;
use App\Http\Controllers\ClubOwner\OwnerLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubOwner\ClubOwnerTournament;
use App\Http\Controllers\ClubOwner\AdvertisementController;


Route::get('login',[OwnerLoginController::class,'show_form'])->name('club_owner.login.show');
Route::post('login',[OwnerLoginController::class,'show_form_submit'])->name('club_owner.login.submit');
Route::post('logout',[OwnerLoginController::class,'owner_logout'])->name('club_owner.logout');

Route::get('dashboard',[OwnerDashboardController::class,'index'])->name('club_owner.dashboard');
Route::get('club_member',[OwnerDashboardController::class,'club_member'])->name('club_owner.club_member');
Route::get('club_info',[OwnerDashboardController::class,'club_info'])->name('club_owner.club_info');
Route::post('update_club_info',[OwnerDashboardController::class,'update_club_info'])->name('club_owner.update_club_info');
Route::get('profile',[OwnerDashboardController::class,'profile'])->name('club_owner.profile');
Route::post('update_profile',[OwnerDashboardController::class,'update_profile'])->name('club_owner.update_profile');

Route::get('tournament',[ClubOwnerTournament::class,'index'])->name('club_owner.tournament_index');
Route::get('create_tournament',[ClubOwnerTournament::class,'create'])->name('club_owner.tournament_create');
Route::post('store_tournament',[ClubOwnerTournament::class,'store'])->name('club_owner.tournament_store');
Route::get('sub-type-by-game-type/{id}',[ClubOwnerTournament::class,'get_game_sub_type'])->name('club_owner.get_game_sub_type');
Route::get('tournament_game_round/{id}',[ClubOwnerTournament::class,'tournament_round'])->name('club_owner.tournament_round');
Route::post('update_game_round',[ClubOwnerTournament::class,'update_game_round'])->name('club_owner.update_game_round');
Route::get('tournament_game/{id}',[ClubOwnerTournament::class,'tournament_game'])->name('club_owner.tournament_game');
Route::get('game_round/{id}',[ClubOwnerTournament::class,'game_round'])->name('club_owner.game_round');
Route::get('round_board/{id}',[ClubOwnerTournament::class,'round_board'])->name('club_owner.round_board');

// Advertisements Controller

Route::get('advertisement_list',[AdvertisementController::class,'advertisement_list'])->name('club_owner.advertisement_list');
Route::get('ad_request',[AdvertisementController::class,'ad_request'])->name('club_owner.ad_request');
Route::post('advertisement_calculation',[AdvertisementController::class,'advertisement_calculation'])->name('club_owner.advertisement_calculation');
Route::post('get_time_slot',[AdvertisementController::class,'get_time_slot'])->name('club_owner.get_time_slot');
Route::post('submit_ad_request',[AdvertisementController::class,'submit_ad_request'])->name('club_owner.submit_ad_request');
Route::get('boasting_money',[AdvertisementController::class,'boasting_money'])->name('club_owner.boasting_money');
Route::get('boasting_money_request',[AdvertisementController::class,'boasting_money_request'])->name('club_owner.boasting_money_request');
Route::post('dollar_convert',[AdvertisementController::class,'dollar_convert'])->name('club_owner.dollar_convert');
Route::post('send_boasting_request',[AdvertisementController::class,'send_boasting_request'])->name('club_owner.send_boasting_request');
Route::get('import_paid_coin',[AdvertisementController::class,'import_paid_coin'])->name('club_owner.import_paid_coin');
Route::post('import_paid_calculation',[AdvertisementController::class,'import_paid_calculation'])->name('club_owner.import_paid_calculation');
Route::post('import_coin_store',[AdvertisementController::class,'import_coin_store'])->name('club_owner.import_coin_store');
