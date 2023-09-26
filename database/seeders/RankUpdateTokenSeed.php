<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;
use App\Models\RankUpdateToken;

class RankUpdateTokenSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i =1;$i<=5 ; $i++)
        {
            RankUpdateToken::create([
                'rank_id' => Rank::where('priority',$i)->first()->id,
                'title' => rank_title()[$i-1],
                'constant_title' => rank_constant()[$i-1],
                'gift_token'=>10,
            ]);
        }
    }
}
