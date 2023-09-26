<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function rank(){
        return $this->belongsTo(Rank::class);
    }

    public function winners(){
        return $this->hasMany(Playerinboard::class,'first_winner','id');
    }

    public function lossers(){
        return $this->hasMany(Playerinboard::class,'fourth_winner','id');
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id');
    }

    public function referals(){
        return $this->hasMany(self::class,'parent_id');
    }
    public function next_rank(){
        return $this->belongsTo(Rank::class,'next_rank_id');
    }

    public function devices()
    {
        return $this->hasMany(UserDevice::class,'user_id');
    }

    public function club(){
        return $this->belongsTo(Club::class);
    }

    public function club_join(){
        return $this->belongsTo(Club::class,'club_join_id');
    }
    public function share_holders(){
        return $this->hasMany(ShareHolder::class);
    }

    public function get_data_applied_user(){
        return self::where('data_applied_user_id',$this->id)->get();
    }







}
