<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'club_name'=>$this->club->club_name,
            'ad_duration'=>$this->ad_duration->title,
            'time_slot_section'=>$this->time_slot_section->section_name ?? 'null',
            'time_slot_from'=>$this->time_slot->time_slot_from ?? 'null',
            'time_slot_to'=>$this->time_slot->time_slot_to ?? 'null',
            'total_ad'=>$this->total_ad,
            'total_day'=>$this->total_day,
            'ad_show_per_day'=>$this->ad_show_per_day,
            'ad_start_from'=>$this->ad_start_from,
            'ad_end_in'=>$this->ad_end_in,

        ];
    }
}
