<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;
use App\Models\Game;

class Gameround extends Model
{
    use HasFactory;
    protected $guarded = [];

    //    protected $casts = [
    //        'round_start_time' => 'datetime',
    //    ];

    public function boards()
    {
        return $this->hasMany(Roundludoboard::class, 'round_id', 'id');
    }
    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
    public function bided()
    {
        return $this->belongsTo(Biding_details::class);
    }
}
