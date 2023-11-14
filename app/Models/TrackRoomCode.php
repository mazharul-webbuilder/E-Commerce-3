<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRoomCode extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function track_winners(){
        return $this->hasMany(TrackWinner::class);
    }
}
