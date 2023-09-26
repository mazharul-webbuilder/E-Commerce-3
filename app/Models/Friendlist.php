<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Friendlist extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user_one()
    {
        return $this->belongsTo(User::class,'user_id_one');
    }
    public function user_two()
    {
        return $this->belongsTo(User::class,'user_id_two');
    }
}
