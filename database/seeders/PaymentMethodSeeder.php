<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
                [
                    'payment_method_name' => 'UPI (Google Pay/ PhonePe)',
                    'status' => 1,
                    'created_at' => Carbon::now()
                ],
                [
                    'payment_method_name' => 'Wallet',
                    'status' => 1,
                    'created_at' => Carbon::now()
                ],
                [
                    'payment_method_name' => 'Debit/Credit Card',
                    'status' => 1,
                    'created_at' => Carbon::now()
                ],
                [
                    'payment_method_name' => 'Net Banking',
                    'status' => 1,
                    'created_at' => Carbon::now()
                ],
                [
                    'payment_method_name' => 'Cash On Delivery',
                    'status' => 1,
                    'created_at' => Carbon::now()
                ],
                [
                    'payment_method_name' => 'Mobile Banking',
                    'status' => 1,
                    'created_at' => Carbon::now()
                ]
        ]
        );
    }
}
