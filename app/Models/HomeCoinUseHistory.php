<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCoinUseHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
