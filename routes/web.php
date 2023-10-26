<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DiamondPackageController;
use App\Http\Controllers\Admin\FriendListController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\GenerationCommissionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RankUpdateDuration;
use App\Http\Controllers\Admin\RankUpdateTokenController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewCoinController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ShareHolderSettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\TournamentController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\WithdrawHistoryController;
use App\Http\Controllers\Admin\WithdrawPaymentController;
use App\Http\Controllers\Ludo\CampaignController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ManageSellerController;
use App\Http\Controllers\Admin\MerchantWithdrawController;
use App\Http\Controllers\Admin\SellerWithdrawController;
use App\Http\Controllers\Admin\AffiliatorWithdrawController;
use Illuminate\Support\Facades\Route;


Route::prefix('merchant')->group(base_path('routes/merchant.php'));
Route::prefix('affiliate')->group(base_path('routes/affiliate.php'));
Route::prefix('seller')->group(base_path('routes/seller.php'));
Route::prefix('club_owner')->group(base_path('routes/club_owner.php'));
Route::prefix('share_owner')->group(base_path('routes/share_owner.php'));




/*============================================
#Frontent Routes
====================================================*/

Route::get('/', [HomeController::class, 'home'])->name('home');

/*============================================
#Frontent Routes
====================================================*/


Route::get('admin/login', [AdminLoginController::class, 'showForm'])->name('show.login');
Route::post('/auth-login', [AdminLoginController::class, 'auth_login'])->name('auth.login');
Route::get('/user_manage', [AdminLoginController::class, 'user_manage'])->name('login.user_manage');

//Route::get('/login', [LoginController::class, 'login'])->name('login');


Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin_logout', [AdminLoginController::class, 'admin_logout'])->name('auth.logout');
    Route::get('/system_version', [Admin\DashboardController::class, 'system_version'])->name('system_version');
    Route::post('/version_update', [Admin\DashboardController::class, 'version_update'])->name('version_update');
    // your protected routes.

    //    user route start here
    Route::get('/users', [Admin\UserController::class, 'index'])->name('all.user');
    Route::match(['get', 'post'], '/users_by_date', [Admin\UserController::class, 'users_by_date'])->name('users_by_date');

    Route::post('/add_share', [Admin\UserController::class, 'add_share'])->name('user.add_share');
    Route::get('/user-referral-list/{id}', [Admin\UserController::class, 'user_referral_list'])->name('user_referral_list.user');
    Route::get('/user-edit/{id}', [Admin\UserController::class, 'edit'])->name('edit.user');
    Route::get('/all-referral-list', [Admin\UserController::class, 'all_referral_history'])->name('all_referral_history.user');
    Route::get('/token-transfer-history/{id}', [Admin\UserController::class, 'token_transfer_history'])->name('token_transfer_history.user');
    Route::get('/user/{id}', [Admin\UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user_applied_data/{user_id}', [Admin\UserController::class, 'data_applied_list'])->name('user.data_applied_list');
    Route::post('/update_user/', [Admin\UserController::class, 'update_user'])->name('update_user');
    Route::get('/daily_order/{id}', [Admin\UserController::class, 'user_daily_order'])->name('user.daily_order');


    //  friend list route start

    Route::get('/friend-list/{id}', [FriendListController::class, 'user_friend_list'])->name('user.friendlist');


    Route::get('/user/token/{id}', [Ludo\TokenController::class, 'user_token'])->name('user.token_history');
    Route::get('/token-transfer-history', [Ludo\TokenController::class, 'token_transfer_history'])->name('user.token_transfer_history');

    //    user route end

    // Balanace transfer history start
    Route::get('/balance-transfer-history', [Ludo\WithdrawController::class, 'all_balance_transfer_history'])->name('all_balance_transfer_history');
    Route::get('/user-balance-transfer-history/{id}', [Ludo\WithdrawController::class, 'user_balance_transfer_history'])->name('user_balance_transfer_history');
    // Balanace transfer history end


    //      free two player route start here
    Route::get('/free-two-player', [Admin\FreegameController::class, 'two_player'])->name('all.free.two_player');
    Route::get('/free-two-player_settings', [Admin\FreegameController::class, 'two_player_settings'])->name('settings.free.two_player');
    Route::post('/free-two-player-settings-update', [Admin\FreegameController::class, 'two_player_settings_update'])->name('settings.2p.update');

    //      free two player route end

    //     free three player route start here
    Route::get('/free-three-player', [Admin\FreegameController::class, 'three_player'])->name('all.free.three_player');
    Route::get('/free-three-player_settings', [Admin\FreegameController::class, 'three_player_settings'])->name('settings.free.three_player');
    Route::post('/free-three-player-settings-update', [Admin\FreegameController::class, 'three_player_settings_update'])->name('settings.3p.update');
    //      free three player route end

    //    free four player route start here
    Route::get('/free-four-player', [Admin\FreegameController::class, 'four_player'])->name('all.free.four_player');
    Route::get('/free-four-player_settings', [Admin\FreegameController::class, 'four_player_settings'])->name('settings.free.four_player');
    Route::post('/free-four-player-settings-update', [Admin\FreegameController::class, 'four_player_settings_update'])->name('settings.4p.update');
    //     free four player route end

    //    tournament route start
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('all.tournament');
    Route::get('/club-owner-tournaments', [TournamentController::class, 'club_owner_tournament'])->name('club_owner_tournaments');
    Route::post('/approve_club_owner_tournament', [TournamentController::class, 'approve_club_owner_tournament'])->name('approve_club_owner_tournament');
    Route::get('/sub-type-by-game-type/{id}', [TournamentController::class, 'game_sub_type'])->name('game_sub_type.tournament');
    //    Route::get('/game-type/{id}',[TournamentController::class,'game_type'])->name('game_type.tournament');
    Route::post('/tournament-create', [TournamentController::class, 'store'])->name('create.tournament');
    Route::get('/bidding_list/{id}', [TournamentController::class, 'bidding_list'])->name('bidding_list.board');
    Route::get('/offer_tournament_register/{id}', [TournamentController::class, 'offer_tournament_register'])->name('offer_tournament_register');
    // Route::get('/offer_tournament_register/{id}',[TournamentController::class,'offer_tournament_register'])->name('offer_tournament_register');
    Route::post('/offer_tournament_manage_game', [TournamentController::class, 'offer_tournament_manage_game'])->name('offer_tournament_manage_game');
    Route::post('/offer_tournament_start_game', [TournamentController::class, 'offer_tournament_start_game'])->name('offer_tournament_start_game');
    Route::get('/club-owner-tournaments-round_price/{id}', [TournamentController::class, 'club_owner_tournament_round_price'])->name('club_owner_tournament_round_price');

    //    tournament route end

    //    tournament route start
    Route::get('/all-games/{id}', [Admin\GameController::class, 'index'])->name('all.game');
    Route::get('/all-rounds/{id}', [Admin\GameController::class, 'round_list'])->name('all.round');
    Route::get('/all-boards/{id}', [Admin\GameController::class, 'board_list'])->name('all.board');
    Route::get('/player-in-board/{id}', [Admin\GameController::class, 'playerlist'])->name('playerlist.board');
    Route::get('all_join_user/{game_id}/{tournament_id}', [Admin\GameController::class, 'join_user'])->name('all.join_user');

    //    round settings  route start
    Route::get('/rounds/{id}', [Admin\RoundSettingController::class, 'index'])->name('all.round_ofgame');
    Route::post('/rounds', [Admin\RoundSettingController::class, 'store'])->name('store.round_ofgame');


    //Generation routes
    Route::get('/all/generation', [GenerationCommissionController::class, 'index'])->name('admin.generation_commission');
    Route::post('/update_generation_commission', [GenerationCommissionController::class, 'update_commission'])->name('admin.update_generation_commission');

    Route::group(['prefix' => 'setting'], function () {
        Route::get('/general_setting', [GeneralSettingController::class, 'general_setting'])->name('admin.general_setting');
        Route::post('/update_general_setting', [GeneralSettingController::class, 'update_general_setting'])->name('admin.update_general_setting');
        Route::get('/view_commission_history', [GeneralSettingController::class, 'view_commission_history'])->name('admin.view_commission_history');
        Route::get('/distribute_recovery_fund', [GeneralSettingController::class, 'distribute_recovery_fund'])->name('admin.distribute_recovery_fund');
    });

    //Diamond Package routes
    Route::group(['prefix' => 'diamond'], function () {

        Route::get('/package', [DiamondPackageController::class, 'index'])->name('diamond_package.index');
        Route::get('/package_create', [DiamondPackageController::class, 'create'])->name('diamond_package.create');
        Route::post('/package_store', [DiamondPackageController::class, 'store'])->name('diamond_package.store');
        Route::get('/package_edit/{id}', [DiamondPackageController::class, 'edit'])->name('diamond_package.edit');
        Route::post('/update', [DiamondPackageController::class, 'update'])->name('diamond_package.update');
        Route::post('/delete', [DiamondPackageController::class, 'delete'])->name('diamond_package.delete');
        Route::get('/sell_history', [DiamondPackageController::class, 'diamond_sell_history'])->name('diamond.sell_history');
    });

    //manage club routes
    Route::group(['prefix' => 'club'], function () {

        Route::get('/club', [ClubController::class, 'index'])->name('admin_club.index');
        Route::get('/create_club', [ClubController::class, 'create'])->name('admin_club.create');
        Route::post('/store_club', [ClubController::class, 'store'])->name('admin_club.store');
        Route::get('/edit_club/{id}', [ClubController::class, 'edit'])->name('admin_club.edit_club');
        Route::post('/update_club', [ClubController::class, 'update'])->name('admin_club.update_club');
        Route::post('/delete_club', [ClubController::class, 'delete'])->name('admin_club.delete');
        Route::get('/club_owner', [ClubController::class, 'club_owner'])->name('admin_club.club_owner');
        Route::get('/club_setting', [ClubController::class, 'club_setting'])->name('admin_club.setting');
        Route::post('/club_setting', [ClubController::class, 'update_setting'])->name('admin_club.setting_update');
        Route::get('/create_new_club_owner', [ClubController::class, 'create_new_club_owner'])->name('admin_club.create_new_club_owner');
        Route::post('/store_club_owner', [ClubController::class, 'store_club_owner'])->name('admin_club.store_club_owner');
        Route::get('/boasting_request', [ClubController::class, 'boasting_request'])->name('admin_club.boasting_request');
        Route::post('/manage_boasting', [ClubController::class, 'manage_boasting'])->name('admin_club.manage_boasting');
    });

    //manage advertisement routes
    Route::group(['prefix' => 'advertisement'], function () {

        Route::get('/setting', [AdvertisementController::class, 'setting'])->name('advertisement.setting');
        Route::post('/setting_update', [AdvertisementController::class, 'setting_update'])->name('advertisement.setting_update');
        Route::get('/ad_duration', [AdvertisementController::class, 'ad_duration'])->name('advertisement.ad_duration');
        Route::get('/time_slot/{ad_duration_id}', [AdvertisementController::class, 'time_slot'])->name('advertisement.time_slot');
        Route::get('/time_slot/{ad_duration_id}', [AdvertisementController::class, 'time_slot'])->name('advertisement.time_slot');
        Route::get('/ad_list', [AdvertisementController::class, 'ad_list'])->name('advertisement.ad_list');
    });


    Route::group(['prefix' => 'rank'], function () {

        Route::get('/duration', [RankUpdateDuration::class, 'index'])->name('rank.duration.index');
        Route::post('/update', [RankUpdateDuration::class, 'update'])->name('rank.duration.update');

        Route::get('/gift_token', [RankUpdateTokenController::class, 'index'])->name('rank.gift_token.index');
        Route::post('/gift_token_update', [RankUpdateTokenController::class, 'update'])->name('rank.gift_token.update');
    });

    Route::get('/used_coin_history', [GeneralController::class, 'used_coin_history'])->name('admin.used_coin_history');

    Route::get('/home_used_coin_history', [HomeCoinUseHistoryController::class, 'home_used_coin_history'])->name('admin.home.used_coin_history');

    Route::get('/home_used_diamond_history', [HomeDimondUseHistoryController::class, 'home_used_diamond_history'])->name('admin.home.used_diamond_history');

    Route::group(['prefix' => 'withdraw-transfer'], function () {

        Route::get('/withdraw_list/{type?}', [WithdrawHistoryController::class, 'index'])->name('withdraw.index');
        Route::post('/manage_withdraw_status', [WithdrawHistoryController::class, 'manage_withdraw'])->name('withdraw.manage_withdraw');
        Route::post('/processing_time', [WithdrawHistoryController::class, 'processing_time'])->name('withdraw.processing_time');
        Route::get('/withdraw_saving', [WithdrawHistoryController::class, 'withdraw_saving'])->name('withdraw.saving');
    });

    Route::group(['prefix' => 'withdraw-payment'], function () {

        Route::get('/withdraw_list', [WithdrawPaymentController::class, 'index'])->name('withdraw_payment.index');
        Route::get('/create', [WithdrawPaymentController::class, 'create'])->name('withdraw_payment.create');
        Route::post('/store', [WithdrawPaymentController::class, 'store'])->name('withdraw_payment.store');
        Route::get('/edit/{id}', [WithdrawPaymentController::class, 'edit'])->name('withdraw_payment.edit');
        Route::post('/update', [WithdrawPaymentController::class, 'update'])->name('withdraw_payment.update');
        Route::post('/delete', [WithdrawPaymentController::class, 'delete'])->name('withdraw_payment.delete');
    });

    //    campaign route start
    Route::group(['prefix' => 'campaign'], function () {
        Route::get('/position', [CampaignController::class, 'get_campaign_position'])->name('get_campaign_position');
        //    Rank Coin route start
        Route::get('/all', [CampaignController::class, 'index'])->name('campaign.index');
        Route::get('/create', [CampaignController::class, 'create_campaign'])->name('campaign.create');
        Route::post('/store', [CampaignController::class, 'store_campaign'])->name('campaign.store');
        Route::get('/campaign-edit/{id}', [CampaignController::class, 'edit'])->name('campaign.edit');
        Route::post('/campaign-update/{id}', [CampaignController::class, 'update'])->name('campaign.update');
    });

    //    share route end
    Route::group(['prefix' => 'shareholder'], function () {

        Route::get('/setting', [ShareHolderSettingController::class, 'setting'])->name('shareholder.setting');
        Route::post('/update_setting', [ShareHolderSettingController::class, 'update_setting'])->name('shareholder.update_setting');
        Route::get('/income_source', [ShareHolderSettingController::class, 'income_source'])->name('shareholder.income_source');
        Route::post('/update_income_source', [ShareHolderSettingController::class, 'update_income_source'])->name('shareholder.update_income_source');
        Route::get('/share_holder', [ShareHolderSettingController::class, 'share_holder'])->name('shareholder.share_holder');
        Route::match(['get', 'post'], '/share_holder_by_date', [ShareHolderSettingController::class, 'share_holder_by_date'])->name('share_holder_by_date');

        Route::get('/share_purchased_detail/{user_id}', [ShareHolderSettingController::class, 'share_purchased_detail'])->name('shareholder.share_purchased_detail');
        Route::get('/share_holder_fund_history', [ShareHolderSettingController::class, 'share_holder_fund_history'])->name('shareholder.share_holder_fund_history');
        Route::post('/distribute_share_holder_fund', [ShareHolderSettingController::class, 'distribute_share_holder_fund'])->name('shareholder.distribute_share_holder_fund');
        Route::get('/share_transfer_history', [ShareHolderSettingController::class, 'share_transfer_history'])->name('shareholder.share_transfer_history');
        Route::get('/create_share_owner', [ShareHolderSettingController::class, 'create_share_owner'])->name('shareholder.create_share_owner');
        Route::post('/store_share_owner', [ShareHolderSettingController::class, 'store_share_owner'])->name('shareholder.store_share_owner');
        Route::get('/user_all_share/{id}', [ShareHolderSettingController::class, 'user_all_share'])->name('shareholder.user_all_share');
        Route::post('/add_parent/', [ShareHolderSettingController::class, 'add_parent'])->name('shareholder.add_parent');
        Route::get('/share_owner/', [ShareHolderSettingController::class, 'share_owner'])->name('shareholder.share_owner');
        Route::post('/provide_share/', [ShareHolderSettingController::class, 'provide_share'])->name('shareholder.provide_share');
        Route::get('deposit_history', [ShareHolderSettingController::class, 'deposit_history'])->name('shareholder.deposit_history');
        Route::post('manage_deposit', [ShareHolderSettingController::class, 'manage_deposit'])->name('shareholder.manage_deposit');
        Route::get('/edit_share_owner/{id}', [ShareHolderSettingController::class, 'edit_share_owner'])->name('shareholder.edit_share_owner');
        Route::post('/update_share_owner', [ShareHolderSettingController::class, 'update_share_owner'])->name('shareholder.update_share_owner');
        Route::get('/coin_earning_history', [ShareHolderSettingController::class, 'coin_earning_history'])->name('shareholder.coin_earning_history');

        Route::get('voucher', [VoucherController::class, 'voucher'])->name('shareholder.voucher');
        Route::get('create_voucher', [VoucherController::class, 'create_voucher'])->name('shareholder.create_voucher');
        Route::post('create_voucher_voucher', [VoucherController::class, 'create_voucher_voucher'])->name('shareholder.create_voucher_voucher');
        Route::get('edit_voucher/{id}', [VoucherController::class, 'edit_voucher'])->name('shareholder.edit_voucher');
        Route::post('update_voucher', [VoucherController::class, 'update_voucher'])->name('shareholder.update_voucher');
        Route::post('delete_voucher', [VoucherController::class, 'delete_voucher'])->name('shareholder.delete_voucher');
        Route::get('voucher_request', [VoucherController::class, 'voucher_request'])->name('shareholder.voucher_request');
        Route::post('assign_voucher', [VoucherController::class, 'assign_voucher'])->name('shareholder.assign_voucher');


    });
    Route::get('voucher', [VoucherController::class, 'voucher'])->name('shareholder.voucher');
    Route::get('create_voucher', [VoucherController::class, 'create_voucher'])->name('shareholder.create_voucher');
    Route::post('create_voucher_voucher', [VoucherController::class, 'create_voucher_voucher'])->name('shareholder.create_voucher_voucher');
    Route::get('edit_voucher/{id}', [VoucherController::class, 'edit_voucher'])->name('shareholder.edit_voucher');
    Route::post('update_voucher', [VoucherController::class, 'update_voucher'])->name('shareholder.update_voucher');
    Route::post('delete_voucher', [VoucherController::class, 'delete_voucher'])->name('shareholder.delete_voucher');
    Route::get('voucher_request', [VoucherController::class, 'voucher_request'])->name('shareholder.voucher_request');
    Route::post('assign_voucher', [VoucherController::class, 'assign_voucher'])->name('shareholder.assign_voucher');      Route::get('voucher', [VoucherController::class, 'voucher'])->name('shareholder.voucher');
    Route::get('create_voucher', [VoucherController::class, 'create_voucher'])->name('shareholder.create_voucher');
    Route::post('create_voucher_voucher', [VoucherController::class, 'create_voucher_voucher'])->name('shareholder.create_voucher_voucher');
    Route::get('edit_voucher/{id}', [VoucherController::class, 'edit_voucher'])->name('shareholder.edit_voucher');
    Route::post('update_voucher', [VoucherController::class, 'update_voucher'])->name('shareholder.update_voucher');
    Route::post('delete_voucher', [VoucherController::class, 'delete_voucher'])->name('shareholder.delete_voucher');
    Route::get('voucher_request', [VoucherController::class, 'voucher_request'])->name('shareholder.voucher_request');
    Route::post('assign_voucher', [VoucherController::class, 'assign_voucher'])->name('shareholder.assign_voucher');
    // report routes
    Route::get('/rank_wise_user/{rank_name?}/{type?}', [ReportController::class, 'rank_wise_user'])->name('rank_wise_user');

    Route::match(['get', 'post'], '/rank_wise_user_search_by_date/{rank_name?}/{type?}', [ReportController::class, 'rank_wise_user_search_by_date'])->name('rank_wise_user_search_by_date');


    Route::get('/share_owner_list', [ReportController::class, 'share_owner'])->name('share_owner_list');
    Route::get('/share_holder_list', [ReportController::class, 'share_holder_list'])->name('share_holder_list');
    Route::match(['get', 'post'], '/share_holder_list_date', [ReportController::class, 'get_share_holders_by_date'])->name('share_holder_list_date');



    Route::get('/diamond_holder_user', [ReportController::class, 'diamond_holder_user'])->name('diamond_holder_user');
    Route::match(['get', 'post'], '/diamond_holder_user_by_date', [ReportController::class, 'diamond_holder_user_by_date'])->name('diamond_holder_user_by_date');



    Route::get('/diamond_purchase_history', [ReportController::class, 'diamond_purchase_history'])->name('diamond_purchase_history');
    Route::match(['get', 'post'], '/diamond_purchase_history_by_date', [ReportController::class, 'diamond_purchase_history_by_date'])->name('diamond_purchase_history_by_date');


    Route::get('/diamond_used_history_report', [ReportController::class, 'diamond_used_history_report'])->name('diamond_used_history_report');
    Route::get('/get_earning_coin/{earning_source}', [ReportController::class, 'get_earning_coin'])->name('get_earning_coin');
    Route::match(['get', 'post'], '/earning_coin_by_date/{earning_source}', [ReportController::class, 'earning_coin_by_date'])->name('earning_coin_by_date');


    Route::get('/get_withdraw_coin/{status}', [ReportController::class, 'get_withdraw_coin'])->name('get_withdraw_coin');
    Route::match(['get', 'post'], '/get_withdraw_coin_date/{status}', [ReportController::class, 'get_withdraw_coin_date'])->name('get_withdraw_coin_date');



    Route::get('/get_transfer_balance/{constant_title}', [ReportController::class, 'get_transfer_balance'])->name('get_transfer_balance');
    Route::match(['get', 'post'], '/get_transfer_balance_date/{constant_title}', [ReportController::class, 'get_transfer_balance_date'])->name('get_transfer_balance_date');

    Route::get('/get_coin_uses_history/{purpose}', [ReportController::class, 'get_coin_uses_history'])->name('get_coin_uses_history');
    Route::get('/get_user_token/{type}', [ReportController::class, 'get_user_token'])->name('get_user_token');
    Route::get('/get_token_used_history/{type}', [ReportController::class, 'get_token_used_history'])->name('get_token_used_history');
    Route::match(['get', 'post'], '/get_token_used_history_date/{type}', [ReportController::class, 'get_token_used_history_date'])->name('get_token_used_history_date');


    Route::get('/get_source_wise_token/{getting_source}', [ReportController::class, 'get_source_wise_token'])->name('get_source_wise_token');
    Route::match(['get', 'post'], '/get_source_wise_token_date/{getting_source}', [ReportController::class, 'get_source_wise_token_date'])->name('get_source_wise_token_date');

    Route::get('/get_token_transfer_history/{type}', [ReportController::class, 'get_token_transfer_history'])->name('get_token_transfer_history');
    Route::match(['get', 'post'], '/get_token_transfer_history_date/{type}', [ReportController::class, 'get_token_transfer_history_date'])->name('get_token_transfer_history_date');


    Route::get('/get_share_transfer_history', [ReportController::class, 'get_share_transfer_history'])->name('get_share_transfer_history');
    Route::match(['get', 'post'], '/share_transfer_history_by_date', [ReportController::class, 'share_transfer_history_by_date'])->name('share_transfer_history_by_date');
    Route::get('/coin_earning_history', [ReportController::class, 'coin_earning_history'])->name('coin_earning_history');
    Route::match(['get', 'post'], '/coin_earn_history_search_by_date', [ReportController::class, 'coin_earn_history_search_by_date'])->name('coin_earn_history_search_by_date');
    Route::get('/get_data_applied_users', [ReportController::class, 'get_data_applied_users'])->name('get_data_applied_users');
    Route::get('/get_admin_tournament/{game_type}', [ReportController::class, 'get_admin_tournament'])->name('get_admin_tournament');
    Route::get('/filter_admin_tournament/{game_type?}/{player_type?}', [ReportController::class, 'filter_admin_tournament'])->name('filter_admin_tournament');



    //    round settings  route end

    //    Rank commission route start
    Route::get('/rank-commissions', [Admin\RankCommissionController::class, 'index'])->name('rank.commission');
    Route::get('/rank-commission/{id}', [Admin\RankCommissionController::class, 'edit'])->name('rank_commission.edit');
    Route::post('/rank-commission-update/{id}', [Admin\RankCommissionController::class, 'update'])->name('rank_commission.update');

    //Rank Commission route end

    //    Rank Coin route start
    Route::get('/rank-coins', [Admin\RankCoinUpdateController::class, 'index'])->name('rank.coins');
    Route::get('/edit-rank-coin/{id}', [Admin\RankCoinUpdateController::class, 'edit'])->name('rank_coin.edit');
    Route::post('/rank-coin-update/{id}', [Admin\RankCoinUpdateController::class, 'update'])->name('rank_coin.update');
    Route::get('/rank-update-history/{type?}', [Admin\RankCoinUpdateController::class, 'rank_update_history'])->name('rank_update_history');
    Route::post('/rank_search_by_date', [Admin\RankCoinUpdateController::class, 'search_by_date'])->name('rank.search_by_date');
    //    Rank Coin route end

    //    Rank Coin route start
    Route::get('/rank-coins-auto-update', [Admin\AutoRankUpdateController::class, 'index'])->name('rank.coins_auto_update');
    Route::get('/rank-auto-update/{id}', [Admin\AutoRankUpdateController::class, 'edit'])->name('coins_auto_update.edit');
    Route::post('/rank-coin-auto-update/{id}', [Admin\AutoRankUpdateController::class, 'update'])->name('coins_auto_update.update');



    //    Rank Coin route end

    //    member rank route start
    Route::get('/member-rank', [Admin\RankController::class, 'index'])->name('rank.member');
    Route::get('/all-member-rank-update-history', [Admin\RankController::class, 'rank_update_history'])->name('rank_update_history.member');
    Route::post('/member-rank-update', [Admin\RankController::class, 'update'])->name('rank.update');
    //    E-Commerce part start

    //    Diamond route start
    Route::get('/diamond', [Admin\DiamondController::class, 'diamond'])->name('all.diamond');
    Route::post('/diamond-update', [Admin\DiamondController::class, 'diamond_update'])->name('diamond.update');
    Route::get('/diamond-used-history/', [Admin\DiamondController::class, 'diamond_used_history'])->name('diamond_used_history');
    Route::post('/diamond-search-by-date/', [Admin\DiamondController::class, 'diamond_search_by_date'])->name('diamond.search_by_date');
    //    Diamond Route end

    //    category route start
    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('category.all');
    Route::post('/category-create', [Admin\CategoryController::class, 'store'])->name('category.store');
    Route::get('/category-edit/{id}/{slug}', [Admin\CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category-update/{id}', [Admin\CategoryController::class, 'update'])->name('category.update');
    Route::get('/category-delete/{id}', [Admin\CategoryController::class, 'destroy'])->name('category.destroy');

    // category route end
    ////    Bannner route start
    Route::get('/banners', [Admin\BannerController::class, 'index'])->name('banner.all');
    Route::post('/banner-create', [Admin\BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner-edit/{slug}', [Admin\BannerController::class, 'edit'])->name('banner.edit');
    Route::post('/banner-update/{id}', [Admin\BannerController::class, 'update'])->name('banner.update');
    Route::get('/banner-delete/{id}', [Admin\BannerController::class, 'destroy'])->name('banner.destroy');
    // category route end

    //    Subcategory route start
    Route::get('/sub-categories', [Admin\SubCategoryController::class, 'index'])->name('sub-category.all');
    Route::post('/sub-category-create', [Admin\SubCategoryController::class, 'store'])->name('sub-category.store');
    Route::get('/sub-category-edit/{slug}', [Admin\SubCategoryController::class, 'edit'])->name('sub-category.edit');
    Route::post('/sub-category-update/{id}', [Admin\SubCategoryController::class, 'update'])->name('sub-category.update');
    Route::get('/sub-category-delete/{id}', [Admin\SubCategoryController::class, 'destroy'])->name('sub-category.destroy');

    /*Brand Route*/
    Route::group(['prefix' => 'brand', 'as' => 'brand.'], function (){
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/details', [BrandController::class, 'detail'])->name('detail');
        Route::post('/update', [BrandController::class, 'update'])->name('update');
        Route::post('/delete', [BrandController::class, 'delete'])->name('delete');
        Route::post('/update-status', [BrandController::class, 'statusUpdate'])->name('status.update');
    });

    // slider controller slider
    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::get('/update-slider-status', [SliderController::class, 'updateStatus'])->name('slider.status.change');
        Route::post('/delete', [SliderController::class, 'delete'])->name('slider.delete');
    });
    // Banner controller
    Route::group(['prefix' => 'banner'], function () {
        Route::get('/', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/create', [BannerController::class, 'create'])->name('banner.create');
        Route::post('/store', [BannerController::class, 'store'])->name('banner.store');
        Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
        Route::get('/update-banner-status', [BannerController::class, 'updateStatus'])->name('banner.status.change');
        Route::post('/update/{id}', [BannerController::class, 'update'])->name('banner.update');
        Route::post('/delete', [BannerController::class, 'delete'])->name('banner.delete');
    });

    // unit route
    Route::group(['prefix' => 'unit'], function () {
        Route::get('/', [UnitController::class, 'index'])->name('unit.index');
        Route::get('/create', [UnitController::class, 'create'])->name('unit.create');
        Route::post('/store', [UnitController::class, 'store'])->name('unit.store');
        Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
        Route::post('/update', [UnitController::class, 'update'])->name('unit.update');
        Route::post('/delete', [UnitController::class, 'delete'])->name('unit.delete');
    });

    // size route
    Route::group(['prefix' => 'size'], function () {
        Route::get('/', [SizeController::class, 'index'])->name('size.index');
        Route::get('/create', [SizeController::class, 'create'])->name('size.create');
        Route::post('/store', [SizeController::class, 'store'])->name('size.store');
        Route::get('/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
        Route::post('/update', [SizeController::class, 'update'])->name('size.update');
        Route::post('/delete', [SizeController::class, 'delete'])->name('size.delete');
    });

    // Product route
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/of/merchants', [ProductController::class, 'merchantsProduct'])->name('product.merchant');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update', [ProductController::class, 'update'])->name('product.update');
        Route::get('/product_detail/{slug}', [ProductController::class, 'product_detail'])->name('product.product_detail');
        Route::get('/all_flash_deal', [ProductController::class, 'all_flash_deal'])->name('product.all_flash_deal');
        Route::post('/delete', [ProductController::class, 'delete'])->name('product.delete');
        Route::post('/find_sub_category', [ProductController::class, 'find_sub_category'])->name('find_sub_category');
        Route::post('/product_status_update', [ProductController::class, 'product_status_update'])->name('product_status_update');
        Route::post('/control_product', [ProductController::class, 'control_product'])->name('control_product');
        Route::post('/show_product_status', [ProductController::class, 'show_product_status'])->name('show_product_status');
        Route::post('/set_product_flash', [ProductController::class, 'set_product_flash'])->name('set_product_flash');
        Route::post('/get_product_deal', [ProductController::class, 'get_product_deal'])->name('get_product_deal');
        Route::get('/product_sale_history', [ProductController::class, 'product_sale_history'])->name('product.sale_history');
        Route::post('/search_by_date', [ProductController::class, 'search_by_date'])->name('product.search_by_date');
    });

    // Stock route
    Route::group(['prefix' => 'stock'], function () {
        Route::get('/{product_id}', [StockController::class, 'index'])->name('stock.index');
        Route::post('/store', [StockController::class, 'store'])->name('stock.store');
        Route::get('/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
        Route::post('/update', [StockController::class, 'update'])->name('stock.update');
        Route::post('/delete', [StockController::class, 'delete'])->name('stock.delete');
    });

    // Gallery route
    Route::group(['prefix' => 'gallery'], function () {
        Route::get('/{product_id}', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
        Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::post('/update', [GalleryController::class, 'update'])->name('gallery.update');
        Route::post('/delete', [GalleryController::class, 'delete'])->name('gallery.delete');
    });

    // Review Coin route
    Route::group(['prefix' => 'review_coin'], function () {

        Route::get('/', [ReviewCoinController::class, 'index'])->name('review_coin.index');
        Route::get('/create', [ReviewCoinController::class, 'create'])->name('review_coin.create');
        Route::post('/store', [ReviewCoinController::class, 'store'])->name('review_coin.store');
        Route::get('/edit/{id}', [ReviewCoinController::class, 'edit'])->name('review_coin.edit');
        Route::post('/update', [ReviewCoinController::class, 'update'])->name('review_coin.update');
        Route::post('/delete', [ReviewCoinController::class, 'delete'])->name('review_coin.delete');
    });

    // Review route
    Route::group(['prefix' => 'review'], function () {
        Route::get('/', [ReviewController::class, 'index'])->name('review.index');
        Route::post('/update', [ReviewController::class, 'update'])->name('review.status.update');
        Route::post('/delete', [ReviewController::class, 'delete'])->name('review.delete');
    });


    // Payment route
    Route::group(['prefix' => 'payment'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/store', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::post('/update/{id}', [PaymentController::class, 'update'])->name('payment.update');
        Route::post('/delete', [PaymentController::class, 'delete'])->name('payment.delete');
    });

    // Order route
    Route::group(['prefix' => 'order'], function () {
        Route::get('/{type?}', [OrderController::class, 'index'])->name('order.index');
        Route::get('/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/store', [OrderController::class, 'store'])->name('order.store');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/update', [OrderController::class, 'update'])->name('order.update');
        Route::post('/manage_order', [OrderController::class, 'manage_order'])->name('order.manage_order');
        Route::get('/order_detail/{id}', [OrderController::class, 'order_detail'])->name('order.order_detail');
        Route::get('/order_invoice/{id}', [OrderController::class, 'order_invoice'])->name('order.order_invoice');
        Route::post('/search_by_date', [OrderController::class, 'search_by_date'])->name('order.search_by_date');
    });
    /*Admin Own Order*/
    Route::get('/admin/own/order', [OrderController::class, 'admin_order'])->name('admin.order');

    /*Ecommerce Withdraw Start*/
    Route::group(['prefix' => 'ecommerce/withdraw/', 'as' => 'ecommerce.withdraw.'], function (){
        /*Merchant*/
        Route::get('list/merchant', [MerchantWithdrawController::class, 'index'])->name('list.merchant');
        Route::get('list/merchant/datatable', [MerchantWithdrawController::class, 'datatable'])->name('list.datatable.merchant');
        Route::post('status/change', [MerchantWithdrawController::class, 'statusUpdate'])->name('status.change');
        /*Seller*/
        Route::get('list/seller', [SellerWithdrawController::class, 'index'])->name('list.seller');
        Route::get('list/seller/datatable', [SellerWithdrawController::class, 'datatable'])->name('list.datatable.seller');
        Route::post('status/change/seller', [SellerWithdrawController::class, 'statusUpdate'])->name('status.change.seller');
        /*Affiliate*/
        Route::get('list/affiliator', [AffiliatorWithdrawController::class, 'index'])->name('list.affiliator');
        Route::get('list/seller/datatable', [AffiliatorWithdrawController::class, 'datatable'])->name('list.datatable.affiliate');
        Route::post('status/change/affiliator', [AffiliatorWithdrawController::class, 'statusUpdate'])->name('status.change.affiliate');
    });
    /*Ecommerce Withdraw End*/
    Route::group(['prefix' => 'currency'], function () {
        Route::get('/', [CurrencyController::class, 'index'])->name('currency.index');
        Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('currency.edit');
        Route::post('update', [CurrencyController::class, 'update'])->name('currency.update');
    });

    /*Seller Balance Rechare History*/
    Route::group(['prefix' => 'seller/', 'as' => 'admin.seller.'], function (){
        Route::get('recharge/history', [ManageSellerController::class, 'index'])->name('balance.history');
        Route::get('load/datatable', [ManageSellerController::class, 'datatable'])->name('recharge.history.load');
        Route::post('recharge/status/update', [ManageSellerController::class, 'statusUpdate'])->name('recharge.history.status update');
    });

});

Route::get('privacy', [MetaController::class, 'privacy_policy'])->name('privacy_page');

Route::get('terms', [MetaController::class, 'terms_condition'])->name('terms_condition');
