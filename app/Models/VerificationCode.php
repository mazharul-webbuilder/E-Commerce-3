<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function scopeVerifycode($query,$verify_code)
    {
        return $query->where('verify_code',$verify_code);
    }
}
