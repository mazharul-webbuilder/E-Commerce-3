<?php

namespace Database\Seeders;

use App\Models\ClubSetting;
use Illuminate\Database\Seeder;

class ClubSettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClubSetting::create([
            'club_join_cost'=>10,
            'controller_tournament_post_limit'=>10,
            'sub_controller_tournament_post_limit'=>5,
            'club_join_referral_commission'=>10,
            'club_join_share_fund_commission'=>15,
            'club_join_club_owner_commission'=>75,
            'tournament_registration_admin_commission'=>20,
            'tournament_registration_club_owner_commission'=>20
        ]);
    }
}
