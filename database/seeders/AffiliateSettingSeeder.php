<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AffiliateSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('affiliate_settings')->insert(
            [
                'company_commission' => 25,
                'generation_commission' => 20,
                'game_asset_commission' => 10,
                'top_seller_commission' => 30,
                'share_holder_commission' => 15,
                'seller_user_rank_upgrade_require_product'=>1,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()

            ]
        );
    }
}
