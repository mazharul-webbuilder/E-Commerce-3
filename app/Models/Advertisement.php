<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function club(){
        return $this->belongsTo(Club::class);
    }

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function ad_duration(){
        return $this->belongsTo(AdDuration::class);
    }
     public function time_slot_section(){
        return $this->belongsTo(TimeSlotSection::class);
     }

     public function time_slot(){
        return $this->belongsTo(TimeSlot::class);
     }

     public function user_seen_ad_tracks(){
        return $this->hasMany(UserSeenAdTrack::class);
     }

    public function user_seen_ad_track_today(){
        $now_date=Carbon::now()->format('Y-m-d');
        return $this->hasMany(UserSeenAdTrack::class)->whereDate('created_at',Carbon::today());
    }
}
