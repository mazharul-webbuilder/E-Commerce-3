<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 use App\Models\Rank;
class Memberrank extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::insert([
            [
                'rank_name'=>'Normal',
                'priority'=>0,

            ],
            [
                'rank_name'=>'VIP',
                'priority'=>1,

            ],
            [
                'rank_name'=>'Partner',
                'priority'=>2,

            ],
            [
                'rank_name'=>'Star',
                'priority'=>3,
            ],
            [
                'rank_name'=>'Sub-controller',
                'priority'=>4,
            ],
            [
                'rank_name'=>'Controller',
                'priority'=>5,
            ]
        ]);

    }
}
