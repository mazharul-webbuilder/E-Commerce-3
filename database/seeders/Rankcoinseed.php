<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoinRankUpdate;
use App\Models\Rank;

class Rankcoinseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i =1;$i<6 ; $i++)
        {
            CoinRankUpdate::create([
               'rank_id' => Rank::where('priority',$i)->first()->id,
                'title' => rank_title()[$i-1],
                'constant_title' => rank_constant()[$i-1],
                'coin'=>10,
            ]);
        }
    }
}
