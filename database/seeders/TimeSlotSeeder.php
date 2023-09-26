<?php

namespace Database\Seeders;

use App\Models\AdDuration;
use App\Models\TimeSlot;
use App\Models\TimeSlotSection;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeSlot::insert([
            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'00:00:00',
                'time_slot_to'=>'11:59:59',
            ],
            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'01:00:00',
                'time_slot_to'=>'12:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'02:00:00',
                'time_slot_to'=>'13:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'03:00:00',
                'time_slot_to'=>'14:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'04:00:00',
                'time_slot_to'=>'15:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'05:00:00',
                'time_slot_to'=>'16:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'06:00:00',
                'time_slot_to'=>'17:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'07:00:00',
                'time_slot_to'=>'18:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'08:00:00',
                'time_slot_to'=>'19:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'09:00:00',
                'time_slot_to'=>'20:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'10:00:00',
                'time_slot_to'=>'21:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','AM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'11:00:00',
                'time_slot_to'=>'22:59:59',
            ],



            // PM slot

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'12:00:00',
                'time_slot_to'=>'23:59:59',
            ],
            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'13:00:00',
                'time_slot_to'=>'00:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'14:00:00',
                'time_slot_to'=>'01:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'15:00:00',
                'time_slot_to'=>'02:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'16:00:00',
                'time_slot_to'=>'03:59:59',
            ],

            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'17:00:00',
                'time_slot_to'=>'04:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'18:00:00',
                'time_slot_to'=>'05:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'19:00:00',
                'time_slot_to'=>'06:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'20:00:00',
                'time_slot_to'=>'07:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'21:00:00',
                'time_slot_to'=>'08:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'22:00:00',
                'time_slot_to'=>'09:59:59',
            ],


            [
                'time_slot_section_id'=>TimeSlotSection::where('section_name','PM')->first()->id,
                'ad_duration_id'=>AdDuration::where('has_slot',1)->first()->id,
                'time_slot_from'=>'23:00:00',
                'time_slot_to'=>'10:59:59',
            ],

        ]);
    }
}
