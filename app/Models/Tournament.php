<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tournament extends Model
{
    use HasFactory;
    protected $guarded = [];
    const TOURNAMENT_OWNER = ['admin', 'club_owner'];

    public function rounds()
    {
        return $this->hasMany(RoundSettings::class, 'tournament_id', 'id');
    }
    public function isregister()
    {
        return $this->hasMany(Playerenroll::class, 'tournament_id', 'id')->where('user_id', '=', Auth::user()->id);
    }

    public function games()
    {
        return $this->hasMany(Game::class, 'tournament_id', 'id');
    }

    public function offer_tournament()
    {
        return $this->hasOne(OfferTournament::class, 'tournament_id');
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class);
    }

    public function register_to_offer_tournaments()
    {
        return $this->hasMany(RegisterToOfferTournament::class);
    }

    public function club_owner()
    {
        return $this->belongsTo(Owner::class, 'club_owner_id', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function gamerounds()
    {
        return $this->hasMany(Gameround::class);
    }

    // public function bider()
    // {
    //     return $this->belongsTo(Biding_details::class, 'tournament_id');
    // }

    public function round()
    {
        return $this->belongsTo(Gameround::class, 'round_id');
    }


    public function biders()
    {
        return $this->hasMany(Biding_details::class);
    }
}
