<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;

class Biding_details extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
    public function round()
    {
        return $this->belongsTo(Gameround::class, 'round_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
}
