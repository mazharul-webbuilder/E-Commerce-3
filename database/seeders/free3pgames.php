<?php

namespace Database\Seeders;

use App\Models\Free3pgamesettings;
use Illuminate\Database\Seeder;

class free3pgames extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Free3pgamesettings::create([
            'first_winner_multiply'=>2,
            'second_winner_multiply'=>1.5,
            'third_winner_multiply'=>.5,
        ]);
    }
}
