<?php

namespace Database\Seeders;

use App\Models\AdvertisementSetting;
use Illuminate\Database\Seeder;

class AdvertisementSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdvertisementSetting::create([
            'per_day_ad_price'=>0.002,
            'ad_stay_time'=>15,
            'minimum_ad_limit'=>1,
            'maximum_ad_limit'=>15,
            'ad_show_per_day'=>3,
            'ad_continue_day'=>15,
            'advertiser_referral_commission'=>10,
            'share_holder_fund_commission'=>10,
            'asset_fund_commission'=>10,
            'visitor_commission'=>1,
            'visitor_stay_time'=>20,

        ]);
    }
}
