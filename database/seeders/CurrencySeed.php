<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::insert([
            [
                'country_name'=>'Bangladesh',
                'currency_symbol'=>'৳',
                'currency_code'=>'BDT',
                'convert_to_bdt'=>'1',
                'convert_to_usd'=>'0.0094',
                'convert_to_inr'=>'0.77',
                'is_default'=>0,
            ],
            [
                'country_name'=>'United State',
                'currency_symbol'=>'$',
                'currency_code'=>'USD',
                'convert_to_bdt'=>'106.41',
                'convert_to_usd'=>'1',
                'convert_to_inr'=>'82.01',
                'is_default'=>1,
             ],
            [
                'country_name'=>'India',
                'currency_symbol'=>'₹',
                'currency_code'=>'INR',
                'convert_to_bdt'=>'1.30',
                'convert_to_usd'=>'0.012',
                'convert_to_inr'=>'1',
                'is_default'=>0
             ]
        ]);
    }
}
