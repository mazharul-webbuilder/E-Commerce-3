<?php

namespace Database\Seeders;

use App\Models\ShareHolderSetting;
use Illuminate\Database\Seeder;

class ShareHolderSettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShareHolderSetting::create([
            'share_price'=>1000,
            'share_commission'=>90,
            'referral_commission'=>10,
            'share_purchase_limit'=>5,
            'minimum_referral'=>20,
            'minimum_tournament_play'=>10,
            'minimum_tournament_team_play'=>20
        ]);
    }
}
