<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function owner(){
        return $this->hasOne(Owner::class);
    }

    public function club_tournaments(){

        return $this->hasManyThrough(Tournament::class,Owner::class,'club_id','club_owner_id','id','id');
    }
    public function users(){
        return $this->hasMany(User::class);
    }

}
