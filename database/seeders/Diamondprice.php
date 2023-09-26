<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diamond;

class Diamondprice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diamond::create([
            'previous_price'=>2,
            'current_price'=>1.5,
            'partner_price'=>.5,
        ]);
    }
}
