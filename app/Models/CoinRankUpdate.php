<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinRankUpdate extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }
}
