<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Owner extends Authenticatable
{
    use HasFactory;
    protected $guarded=[];
    protected $guard="owner";

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function origin(){
        return $this->belongsTo(User::class,'origin_id','id');
    }
    public function club(){
        return $this->belongsTo(Club::class);
    }

    public function tournaments(){
        return $this->hasMany(Tournament::class,'club_owner_id');
    }
}
