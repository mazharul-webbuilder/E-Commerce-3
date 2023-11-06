<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TournamentController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ludo\AdvertisementController;
use App\Http\Controllers\Ludo\CampaignController;
use App\Http\Controllers\Ludo\CampaignTournamentController;
use App\Http\Controllers\Ludo\ClubController;
use App\Http\Controllers\Ludo\LeagueTournamentController;
use App\Http\Controllers\Ludo\RankUpdateController;
use App\Http\Controllers\Ludo\ShareHolderController;
use App\Http\Controllers\Ludo\WiningPercentageController;
use App\Http\Controllers\Ludo\WithdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\WishlishController;
use App\Http\Controllers\Ludo\UserGeneralApiController;
use App\Http\Controllers\Admin\FriendListController;
use App\Http\Controllers\Ludo\TournamentApiController;
use App\Http\Controllers\Ludo\TokenController;
use App\Http\Controllers\Ecommerce\ApiController;
use App\Http\Controllers\Ludo\PlayerWiningPercentageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('ecommerce')->group(base_path('routes/ecommerce.php'));


Route::post('/test', [TournamentApiController::class, 'test']);

Route::post('/login-step-1', [LoginController::class, 'login_step_one']);
Route::post('/login-step-2', [LoginController::class, 'otp_verification']);
Route::post('/login-step-3', [LoginController::class, 'user_info']);
Route::post('/gmail-login', [LoginController::class, 'gmail_Login']);
Route::post('/free-2p-complete', [Free_two_playerController::class, 'two_player_game_complete']);
Route::post('/free-3p-complete', [Free_three_playerController::class, 'three_player_game_complete']);
Route::post('/free-4p-complete', [Free4playerController::class, 'game_complete']);
Route::post('/tournament-round-complete', [TournamentApiController::class, 'tournament_round_complete']);
Route::get('/get_system_version', [MetaController::class, 'get_system_version']);
//Route::post('/tournament-round-complete-update',[TournamentApiController::class,'tournament_game_complete_update']);

Route::get('/user-delete/{id}', [Admin\UserController::class, 'destroy']);
// betting result start
Route::post('/bidding-result', [TournamentController::class, 'bidding_result']);
//betting result end

// Player Game Wining percentage Store and Fetch
Route::post('user/player-wining-percentage', [PlayerWiningPercentageController::class, 'store']);
Route::get('user/player-wining-percentage/{room_code}', [PlayerWiningPercentageController::class, 'index']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'user'], function () {


        Route::post('store_wining_percentage', [WiningPercentageController::class, 'store_wining_percentage']);
        Route::get('get_wining_percentage/{game_id}/{}', [WiningPercentageController::class, 'get_wining_percentage']);

        Route::post('user_device_track', [WiningPercentageController::class, 'user_device_track']);
        Route::get('show_user_device_track/{room_code}/{device_number}', [WiningPercentageController::class, 'show_user_device_track']);

        Route::get('room-full-check/{room_code}', [WiningPercentageController::class, 'roomFullCheck']);
        Route::get('room-full-check-3p/{room_code}', [WiningPercentageController::class, 'roomFullCheck3p']);
        Route::get('room-full-check-4p/{room_code}', [WiningPercentageController::class, 'roomFullCheck4p']);


        Route::post('purchase_diamond', [UserGeneralApiController::class, 'purchase_diamond']);
        Route::get('my_referred_share', [UserGeneralApiController::class, 'my_referred_share']);
        Route::get('get_diamond_package', [UserGeneralApiController::class, 'get_diamond_package']);
        Route::post('purchase_diamond_package', [UserGeneralApiController::class, 'purchase_diamond_package']);
        Route::post('diamond_partner', [UserGeneralApiController::class, 'diamond_partner']);
        Route::get('my_referral_detail', [UserGeneralApiController::class, 'my_referral_detail']);
        Route::get('rank_progress', [UserGeneralApiController::class, 'rank_progress']);
        Route::post('data_apply', [UserGeneralApiController::class, 'data_apply']);
        Route::post('send_referral_code', [UserGeneralApiController::class, 'send_referral_code']);
        Route::get('data_apply_info', [UserGeneralApiController::class, 'data_apply_info']);
        Route::post('rank_update_coin', [RankUpdateController::class, 'rank_update_coin']);

        // token api

        Route::get('my-gift-token-api', [TokenController::class, 'my_gift_token']);
        Route::get('my-transfer-token-api', [TokenController::class, 'my_transfer_token']);
        Route::post('transfer-token', [TokenController::class, 'transfer_token']);
        Route::get('green-token', [TokenController::class, 'green_token']);
        Route::get('gift-token-history/{type}', [TokenController::class, 'gift_token_history']);
        Route::get('user_token_uses', [TokenController::class, 'user_token_uses']);
        Route::post('user_token_convert', [TokenController::class, 'user_token_convert']);

        Route::get('user-notification', [UserGeneralApiController::class, 'user_notification']);
        Route::get('user-notification-seen', [UserGeneralApiController::class, 'user_notification_status_update']);
        Route::post('send_referral_invitation', [UserGeneralApiController::class, 'send_referral_invitation']);


        Route::get('test_rank', [RankUpdateController::class, 'test_rank']);
        Route::post('transfer-balance', [WithdrawController::class, 'balance_transfer']);
        Route::get('get-commission-percent/{type}', [WithdrawController::class, 'get_commission']);
        Route::get('get-commission-balance/{type}/{amount}', [WithdrawController::class, 'commission_result']);
        Route::get('balance_detail/', [WithdrawController::class, 'coin_detail']);
        Route::get('transfer_balance_list/{type?}', [WithdrawController::class, 'transfer_balance_list']);
        Route::get('withdraw_balance_list/', [WithdrawController::class, 'withdraw_balance_list']);
        Route::get('withdraw_payment_list/', [WithdrawController::class, 'withdraw_payment_list']);
        Route::get('withdraw_detail_info/', [WithdrawController::class, 'withdraw_detail_info']);
        Route::post('coin_convert_to_bdt/', [WithdrawController::class, 'coin_convert_to_bdt']);
        Route::get('saved_payment_list/', [WithdrawController::class, 'saved_payment_list']);
        Route::post('add_payment_method/', [WithdrawController::class, 'add_payment_method']);
        Route::post('verify_payment_account_number/', [WithdrawController::class, 'verify_payment_account_number']);
        Route::post('resend_otp/', [WithdrawController::class, 'resend_otp']);
        Route::post('delete_saved_payment_method/', [WithdrawController::class, 'delete_saved_payment_method']);
        Route::get('coin_earning_history', [WithdrawController::class, 'coin_earning_history']);
        Route::get('withdraw_balance_detail/{id}', [WithdrawController::class, 'withdraw_balance_detail']);
        Route::post('withdraw_balance_delete', [WithdrawController::class, 'withdraw_balance_delete']);

        //  campaign
        Route::get('get_tournament_type', [CampaignController::class, 'get_tournament_type']);
        Route::get('get_tournament/{type}', [CampaignController::class, 'tournament']);
        Route::get('campaign_detail/{id}', [CampaignController::class, 'campaign_info']);
        Route::post('register_to_offer_tournament', [CampaignController::class, 'register_to_offer_tournament']);
        Route::get('get_campaign', [CampaignController::class, 'all_campaign']);

        // shareholder

        Route::post('purchase_share', [ShareHolderController::class, 'purchase_share']);
        Route::post('share-transfer', [ShareHolderController::class, 'share_transfer']);
        Route::get('my-share-list', [ShareHolderController::class, 'get_my_shareholder_list']);
        Route::get('my-share-transfer-list', [ShareHolderController::class, 'get_my_transfer_list']);

        // Club Controller
        Route::POST('search_club', [ClubController::class, 'search_club']);
        Route::POST('join_club', [ClubController::class, 'join_club']);
        Route::get('club_tournament', [ClubController::class, 'club_tournament']);


        // add mobile number
        Route::post('add_mobile', [UserProfileController::class, 'add_mobile']);
        Route::post('verify_mobile', [UserProfileController::class, 'verify_mobile']);
        Route::post('withdraw_balance', [TournamentApiController::class, 'withdraw']);

        //advertisement controller
        Route::post('get_ad', [AdvertisementController::class, 'get_ad']);
        Route::get('club_ad_setting', [AdvertisementController::class, 'club_ad_setting']);
        Route::get('club_detail/{id}', [AdvertisementController::class, 'club_detail']);

    });
    Route::post('/game-start', [TournamentApiController::class, 'start_game']);
    Route::get('/game-types', [TournamentApiController::class, 'game_type']);
    Route::get('/regular-sub-game-type', [TournamentApiController::class, 'regular_sub_game_type']);
    Route::get('/campaign-sub-game-type', [TournamentApiController::class, 'campaign_sub_game_type']);
    Route::post('/tournament', [TournamentApiController::class, 'all_tournament']);
    Route::post('/tournament-join', [TournamentApiController::class, 'tournament_join']); //registration
    Route::post('/tournament-join-update', [TournamentApiController::class, 'tournament_join_old']); //registration
    Route::post('/tournament-view', [TournamentApiController::class, 'game_entry']);
    Route::post('/tournament-round-join', [TournamentApiController::class, 'round_join']);
    Route::post('/tournament-round-join_update', [TournamentApiController::class, 'round_join_old']);
    Route::post('/tournament-round-diamond-use', [TournamentApiController::class, 'round_diamond_use']);

    Route::get('/tournament-bidding', [TournamentApiController::class, 'game_in_bidding']);
    Route::post('/tournament-bidding-by-player', [TournamentApiController::class, 'bided_to_player']);
    Route::post('/tournament-bidding-result-view', [TournamentApiController::class, 'bidding_refund']);



    // League Tournament api
    Route::post('join_league_tournament', [LeagueTournamentController::class, 'join_league_tournament']);
    Route::get('complete_game_list', [LeagueTournamentController::class, 'complete_game_list']);
    Route::get('running_game_list', [LeagueTournamentController::class, 'running_game_list']);
    Route::get('tournament_prize_detail/{tournament_id}', [LeagueTournamentController::class, 'tournament_prize_detail']);
    Route::get('filter_tournament/{game_type}', [LeagueTournamentController::class, 'filter_tournament']);
    // Campaign Tournament api
    Route::post('join_campaign_tournament', [CampaignTournamentController::class, 'join_campaign_tournament']);
    Route::post('tournament_game_round_start', [CampaignTournamentController::class, 'tournament_game_round_start']);
    Route::post('unregister_from_tournament', [CampaignTournamentController::class, 'unregister_from_tournament']);
    Route::post('tournament_game_round_end', [CampaignTournamentController::class, 'tournament_game_round_end']);

    //    Friend list route start here
    Route::post('/add-friend', [FriendListController::class, 'friendlist_add']);
    Route::get('/my-friendList-pending', [FriendListController::class, 'friendList_pending_request']);
    Route::get('/friendList-approved', [FriendListController::class, 'friendList_approved_request']);
    Route::post('/accept_request', [FriendListController::class, 'accept_request']);
    Route::post('/reject_delete_cancel_request', [FriendListController::class, 'reject_delete_cancel_request']);
    Route::get('/request_by_my_friend_list', [FriendListController::class, 'request_by_my_friend_list']);
    Route::post('/search_friend', [FriendListController::class, 'search_friend']);

    //    diamond use route start
    Route::post('/diamond_use', [TournamentApiController::class, 'diamond_use']);
    Route::get('/available_uses_diamond/{tournament_id}/{game_id}/{round_id}/{user_id}', [TournamentApiController::class, 'available_uses_diamond']);
    //    diamond use route end

    //    referel api route start
    Route::get('user/referral', [Admin\UserController::class, 'referral_link']);
    Route::get('user/my-referral-list', [Admin\UserController::class, 'my_referral_list']);
    Route::post('user/refer-code-use', [Admin\UserController::class, 'refer_code_use']);

    //    free two player join start
    Route::post('/free-2p-join', [Free_two_playerController::class, 'game_join']);
    Route::post('/free-two-player-play', [Free_two_playerController::class, 'twoplayer_play']);
    //    free two player  end


    //    free three player join start
    Route::post('/free-3p-join', [Free_three_playerController::class, 'game_join']);
    Route::post('/free-three-player-play', [Free_three_playerController::class, 'game_create_threeplayer']);

    //    free three player  end

    //    free four player join start
    Route::post('/free-four-player-join-game', [Free4playerController::class, 'game_join']);
    Route::post('/free-four-player-create-game', [Free4playerController::class, 'create_four_player_game']);

    //    free four player  end

    Route::get('/user', [LoginController::class, 'user']);
    Route::get('/user-profile', [LoginController::class, 'user_profile']);
    Route::post('/logout', [LoginController::class, 'logout']);
    // your protected routes.

    //    E-Commerce part Route Start

    //    Category Api start
    Route::get('/all-categories', [Ecommerce\ApiController::class, 'all_category']);
    Route::get('/all-categories-with-subcategory', [Ecommerce\ApiController::class, 'all_category_with_subcategory']);
    //all slider
    Route::get('/all-slider', [Ecommerce\ApiController::class, 'all_slider']);
    Route::get('/all-banner', [Ecommerce\ApiController::class, 'all_banner']);

    Route::group(['prefix' => 'ecommerce'], function () {

        // product api
        Route::group(['prefix' => 'product'], function () {
            Route::get('/get_recent_product', [ProductController::class, 'get_recent_product']);
            Route::get('/get_recent_product_all', [ProductController::class, 'get_recent_product_all']);

            Route::get('/get_most_sale_product', [ProductController::class, 'get_most_sale_product']);
            Route::get('/get_most_sale_product_all', [ProductController::class, 'get_most_sale_product_all']);

            Route::get('/get_best_sale_product', [ProductController::class, 'get_best_sale_product']);
            Route::get('/get_best_sale_product_all', [ProductController::class, 'get_best_sale_product_all']);

            Route::get('/get_flash_deal_product', [ProductController::class, 'get_flash_deal_product']);
            Route::get('/get_flash_deal_product_all', [ProductController::class, 'get_flash_deal_product_all']);
            Route::post('/provide_review', [ProductController::class, 'provide_review']);

            Route::get('/category_wise_product/{id}', [ProductController::class, 'category_wise_product']);
            Route::get('/subcategory_wise_product/{id}', [ProductController::class, 'subcategory_wise_product']);
            Route::post('/search_product/', [ProductController::class, 'search_product']);
            Route::get('/product_detail/{id}', [ProductController::class, 'product_detail']);
            Route::get('/my-review-details/{id}', [ProductController::class, 'my_review']);

            Route::post('/checkout', [Ecommerce\ApiController::class, 'checkout']);
        });
        Route::get('/payment', [Ecommerce\ApiController::class, 'payment_gateway']);
        Route::get('/payment-details/{id}', [Ecommerce\ApiController::class, 'payment_gateway_details']);
        Route::get('/my-order-list', [Admin\OrderController::class, 'my_order']);
        Route::get('/order-details/{id}', [Admin\OrderController::class, 'my_order_details']);

        Route::group(['prefix' => 'cart'], function () {

            Route::post('/add_to_cart', [CartController::class, 'add_to_cart']);
            Route::get('/view_cart', [CartController::class, 'view_cart']);
            Route::post('/update_cart', [CartController::class, 'update_cart']);
            Route::post('/delete_cart', [CartController::class, 'delete_cart']);
            Route::post('/order_details', [CartController::class, 'order_details']);
            Route::post('/shipping_charge', [CartController::class, 'shipping_charge']);
            Route::post('/update_cart_status', [CartController::class, 'update_cart_status']);
        });

        Route::group(['prefix' => 'wishlist'], function () {
            Route::post('/add_to_wishlist', [WishlishController::class, 'add_to_wishlist']);
            Route::get('/view_wishlist', [WishlishController::class, 'view_wishlist']);
            Route::delete('/delete_wishlist/{id}', [WishlishController::class, 'delete_wishlist']);
        });
    });
});


Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('tournament-list', [TournamentApiController::class, 'tournamentList']);

        Route::get('tournament-complete-bid-list', [TournamentApiController::class, 'tournamentCompleteBidList']);
        Route::get('tournament-incomplete-bid-list', [TournamentApiController::class, 'tournam entInCompleteBidList']);
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('homegamedimomduse/{game_type_id}/{roomcode_id}', [DashboardController::class, 'homegamedimomduse']);
    Route::post('homegamedimondusestore', [HomeDimondController::class, 'homedimondstore']);

    Route::get('home-incomplete-game', [HomeDimondController::class, 'homeIncompleteGame']);
    Route::get('home-incomplete-game-3p', [HomeDimondController::class, 'homeIncompleteGame3p']);
    Route::get('home-incomplete-game-4p', [HomeDimondController::class, 'homeIncompleteGame4p']);
});

Route::post('home-game/entry-fee', [HomeDimondController::class, 'entry_fee_check']);

Route::group(['prefix'=>'v2'],function (){

    Route::group(['prefix'=>'general'],function (){
        Route::post('send_verification_code',[GeneralController::class,'send_verification_code']);
        Route::post('verify_email_phone',[GeneralController::class,'verify_email_phone']);
        Route::post('check_user_account',[GeneralController::class,'check_user_account']);
    });

});
