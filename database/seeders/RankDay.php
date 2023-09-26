<?php

namespace Database\Seeders;

use App\Models\RankUpdateDay;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankDay extends Seeder
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
            RankUpdateDay::create([
                'rank_id' => Rank::where('priority',$i)->first()->id,
                'title' => rank_title()[$i-1],
                'constant_title' => rank_constant()[$i-1],
                'duration'=>10,
            ]);
        }
    }
}
