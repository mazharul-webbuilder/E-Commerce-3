<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTournament extends Model
{
    use HasFactory;
    protected $guarded=[];
    const OFFER_TYPE=['vip','partner','star','sub_controller','controller','diamond_partner','download'];

    public function tournament(){
        return $this->belongsTo(Tournament::class);
    }

}
