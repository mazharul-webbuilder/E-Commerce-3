<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function game_players()
    {
        return $this->hasMany(Playerenroll::class,'game_id','id');
    }
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
    public function allrounds()
    {
        return $this->hasMany(Gameround::class,'game_id','id');
    }
    public function playerinboards(){
        return $this->hasMany(Playerenroll::class);
    }

}
