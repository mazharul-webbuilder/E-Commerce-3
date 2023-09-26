<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterToOfferTournament extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    public function tournament(){
        return $this->belongsTo(Tournament::class);
    }

}
