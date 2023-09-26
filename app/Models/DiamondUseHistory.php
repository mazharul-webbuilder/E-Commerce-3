<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tournament;
use App\Models\Game;
use App\Models\Gameround;

class DiamondUseHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function round()
    {
        return $this->belongsTo(Gameround::class);
    }
}
