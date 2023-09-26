<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //            AdminSeeder::class,
            //            GamesettingsSedder::class,
            //            free3pgames::class,
            //            Free4playerSeeder::class,
            //            Memberrank::class,
            Diamondprice::class,
            Generation::class,
            AdminSeeder::class

        ]);
    }
}
