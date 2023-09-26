<?php

namespace Database\Seeders;

use App\Models\Generation_commission;
use Illuminate\Database\Seeder;

class Generation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $generations=[
            [
                'generation_name'=>'1st generation',
                'commission'=>4,
                'generation_level'=>'1st'
            ],
            [
                'generation_name'=>'2nd generation',
                'commission'=>3.5,
                'generation_level'=>'2nd'
            ],
            [
                'generation_name'=>'3rd generation',
                'commission'=>3,
                'generation_level'=>'3rd'
            ],
            [
                'generation_name'=>'4th generation',
                'commission'=>2.5,
                'generation_level'=>'4th'
            ],
            [
                'generation_name'=>'5th generation',
                'commission'=>2,
                'generation_level'=>'5th'
            ],
            [
                'generation_name'=>'6th generation',
                'commission'=>1.5,
                'generation_level'=>'6th'
            ],
            [
                'generation_name'=>'7th generation',
                'commission'=>1,
                'generation_level'=>'7th'
            ],

            [
                'generation_name'=>'8th generation',
                'commission'=>.9,
                'generation_level'=>'8th'
            ],
            [
                'generation_name'=>'9th generation',
                'commission'=>.8,
                'generation_level'=>'9th'
            ],
            [
                'generation_name'=>'10th generation',
                'commission'=>.7,
                'generation_level'=>'10th'
            ],
            [
                'generation_name'=>'11th generation',
                'commission'=>.6,
                'generation_level'=>'11th'
            ],
            [
                'generation_name'=>'12th generation',
                'commission'=>.5,
                'generation_level'=>'12th'
            ],
            [
                'generation_name'=>'13th generation',
                'commission'=>.4,
                'generation_level'=>'13th'
            ],
            [
                'generation_name'=>'14th generation',
                'commission'=>.3,
                'generation_level'=>'14th'
            ],
            [
                'generation_name'=>'15th generation',
                'commission'=>.2,
                'generation_level'=>'15th'
            ],
        ];

        for($i=0;$i<count($generations);$i++){
                Generation_commission::create([
                    'generation_name'=>$generations[$i]['generation_name'],
                    'commission'=>$generations[$i]['commission'],
                    'generation_level'=>$generations[$i]['generation_level'],
                ]);
            }
        }

}
