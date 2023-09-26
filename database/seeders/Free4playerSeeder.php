<?php

namespace Database\Seeders;

use App\Models\Free4playergamesettings;
use Illuminate\Database\Seeder;

class Free4playerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Free4playergamesettings::create([
            'first_winner_multiply'=>2,
            'second_winner_multiply'=>1.5,
            'third_winner_multiply'=>.5,
            'looser_multiply'=>.2,
        ]);
    }
}



