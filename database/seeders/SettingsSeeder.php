<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'free_login_coin' => 100,
            'free_login_diamond' => 100,
            'max_withdraw_limit' => 5000,
            'min_withdraw_limit' => 10,
            'referal_bonus' => 10,
            'game_logo' => 'https://e7.pngegg.com/pngimages/115/523/png-clipart-product-design-brand-logo-font-demo-text-orange.png',
            'min_purchase_diamond' => 10,
            'diamond_partner_coin' => 5,
            'admin_store' => '',
            'sub_controller_commission' => 10.36,
            'controller_commission' => 15.36,
            'use_diamond' => 5,
            'gift_to_dollar' => 1.36,
            'gift_to_win_charge' => 1.25,
            'win_to_gift_charge' => 3,
            'marketing_to_win_charge' => 5,
            'marketing_to_gift_charge' => 2,
            'balance_withdraw_charge' => 5,
            'played_tournament' => 2,
            'win_game_percentage' => 20,
            'bidder_commission' => 5,
            'admin_commission_from_bid' => 1.25,
            'max_bidding_amount' => 1000000,
            'min_bidding_amount' => 5,
            'coin_convert_to_bdt' => 5,
            'data_apply_row' => '',
            'data_apply_day' => '',
            'data_apply_coin' => '',
            'share_purchase_limit' => '',
            'board_start_within' => '',
            'recover_need_referral' => '',
            'recover_need_my_played' => '',
            'recover_need_team_played' => '',
            'tournament_unregistation_commission' => '',
            'withdraw_saving' => '',
            'withdraw_saving_controller' => '',
            'withdraw_saving_sub_controller' => '',
            'gift_to_green_convert_cost' => '',
        ]);
    }
}
