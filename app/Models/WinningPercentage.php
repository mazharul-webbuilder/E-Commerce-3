<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinningPercentage extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function free2pgame(){
        return $this->belongsTo(Free2pgame::class,'free2pgame_id');
    }

    public function free3pgame(){
        return $this->belongsTo(Free3pgame::class,'free3pgame_id');
    }

    public function free4pgame(){
        return $this->belongsTo(Free4playergame::class,'free4pgame_id');
    }
}
