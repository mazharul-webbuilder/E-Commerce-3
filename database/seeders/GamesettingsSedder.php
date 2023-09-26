<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class GamesettingsSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'free_login_coin'=>10000,
            'free_login_diamond'=>10000,
            'min_withdraw_limit'=>100,
            'max_withdraw_limit'=>500,
            'referal_bonus'=>100,

        ]);
    }
}
