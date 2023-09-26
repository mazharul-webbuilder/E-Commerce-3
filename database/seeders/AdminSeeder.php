<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            [
                'name'=>'admin dev',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('aaaaaaaa'),
            ],
            [
                'name'=>'dev',
                'email'=>'dev@gmail.com',
                'password'=>Hash::make('aaaaaaaa'),
            ],
            [
                'name'=>'admin@admin.com',
                'email'=>'admin@admin.com',
                'password'=>Hash::make('aaaaaaaa'),
            ]
        ]);
    }
}
