<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenTransferHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function user_token()
    {
        return $this->belongsTo(UserToken::class,'user_token_id');
    }
}
