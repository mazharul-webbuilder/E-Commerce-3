<?php

namespace Database\Seeders;

use App\Models\AdDuration;
use Illuminate\Database\Seeder;

class AdDurationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdDuration::insert([
            [
            'title'=>'24 Hours',
            'per_ad_price'=>0.002,
            'has_slot'=>0
            ],

            [
                'title'=>'12 Hours',
                'per_ad_price'=>0.003,
                'has_slot'=>1
            ],
        ]);
    }
}
