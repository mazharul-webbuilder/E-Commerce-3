<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function time_slot_section(){
        return $this->belongsTo(TimeSlotSection::class);
    }

    public function ad_duration(){
        return $this->belongsTo(AdDuration::class);
    }
}
