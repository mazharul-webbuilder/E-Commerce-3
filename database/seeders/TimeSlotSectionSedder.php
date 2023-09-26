<?php

namespace Database\Seeders;

use App\Models\TimeSlotSection;
use Illuminate\Database\Seeder;

class TimeSlotSectionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeSlotSection::insert([['section_name'=>'AM'],['section_name'=>'PM']]);
    }
}
