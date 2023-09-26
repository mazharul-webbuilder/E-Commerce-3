<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RankCommission;
use App\Models\Rank;

class Rankcommisions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i =0;$i<4 ; $i++)
        {
          $d =  Rank::where('priority',$i+2)->first();
           // echo rank_name()[$i];
            RankCommission::create([
                'rank_name' => rank_name()[$i],
                'registration_commission' => 10,
                'diamond_commission' => 10,
                'betting_commission' => 10,
                'withdraw_commission' => 2,
                'game_asset_commission' => 2,
                'updating_commission' => 4,
                'rank_id' =>$d->id,
            ]);
        }
    }
}
