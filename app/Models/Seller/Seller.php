<?php

namespace App\Models\Seller;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
