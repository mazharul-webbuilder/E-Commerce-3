<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenUseHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function user_token(){
        return $this->belongsTo(UserToken::class);
    }
    public function tournament(){
       return $this->belongsTo(Tournament::class);
    }
}
