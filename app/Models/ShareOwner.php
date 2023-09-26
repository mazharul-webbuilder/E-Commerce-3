<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class ShareOwner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded=[];

    public function share_holders(){
        return $this->hasMany(ShareHolder::class);
    }

    public function share_transfers(){
        return $this->hasMany(ShareTransferHistory::class,'share_from');
    }

}
