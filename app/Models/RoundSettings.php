<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundSettings extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function tournament()
    {
        return $this->belongsTo(Tournament::class,'tournament_id');
    }
}
