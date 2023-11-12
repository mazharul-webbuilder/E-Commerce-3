<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::chunk(200, function ($users) {
            foreach ($users as $user) {
                if ($user->userDetail()->doesntHave('user')) {
                    UserDetail::create([
                        'user_id' => $user->id,
                        'ecommerce_balance' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
