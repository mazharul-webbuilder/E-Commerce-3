<?php

namespace Database\Seeders;

use App\Models\ShareHolderIncomeSource;
use Illuminate\Database\Seeder;

class ShareHolderIncomeSourceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShareHolderIncomeSource::insert([
            [
                'income_source_name'=>'Tournament registration',
                'commission'=>10,
                'commission_type'=>2,
                'constrain_title'=>SHARE_HOLDER_INCOME_SOURCE['tournament_registration'],
            ],
            [
                'income_source_name'=>'Diamond Use',
                'commission'=>10,
                'commission_type'=>1,
                'constrain_title'=>SHARE_HOLDER_INCOME_SOURCE['diamond_use'],
            ],
            [
                'income_source_name'=>'Bidding',
                'commission'=>10,
                'commission_type'=>2,
                'constrain_title'=>SHARE_HOLDER_INCOME_SOURCE['bidding'],
          ],
            [
                'income_source_name'=>'Club Registration',
                'commission'=>10,
                'commission_type'=>2,
                'constrain_title'=>SHARE_HOLDER_INCOME_SOURCE['club_registration'],
            ],
            [
                'income_source_name'=>'Rank Update',
                'commission'=>10,
                'commission_type'=>2,
                'constrain_title'=>SHARE_HOLDER_INCOME_SOURCE['rank_update'],
            ],
            [
                'income_source_name'=>'Diamond Partner',
                'commission'=>10,
                'commission_type'=>2,
                'constrain_title'=>SHARE_HOLDER_INCOME_SOURCE['diamond_partner'],
             ]
        ]);
    }
}
