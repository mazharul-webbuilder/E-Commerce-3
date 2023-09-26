<?php

namespace Database\Seeders;

use App\Models\CampaignPosition;
use Illuminate\Database\Seeder;

class CampaignPositionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CampaignPosition::insert([
            [
                'position_name'=>'Diamond Partner',
                'constrain_title'=>CAMPAIGN_POSITION_CONSTRAIN_TITLE['diamond_partner'],
            ],
        [
            'position_name'=>'VIP',
            'constrain_title'=>CAMPAIGN_POSITION_CONSTRAIN_TITLE['vip'],
        ],
        [
            'position_name'=>'partner',
            'constrain_title'=>CAMPAIGN_POSITION_CONSTRAIN_TITLE['partner'],
        ],
        [
            'position_name'=>'star',
            'constrain_title'=>CAMPAIGN_POSITION_CONSTRAIN_TITLE['star'],
        ],
        [
            'position_name'=>'sub controller',
            'constrain_title'=>CAMPAIGN_POSITION_CONSTRAIN_TITLE['sub_controller'],
        ],
        [
            'position_name'=>'controller',
            'constrain_title'=>CAMPAIGN_POSITION_CONSTRAIN_TITLE['controller'],
        ],

    ]);
    }
}
