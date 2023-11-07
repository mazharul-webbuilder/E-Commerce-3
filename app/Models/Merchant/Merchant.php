<?php

namespace App\Models\Merchant;

use App\Models\Ecommerce\Product;
use App\Models\ShopDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Merchant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded=[];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function publish_products(){
        return $this->hasMany(Product::class)->where('status',1);
    }
    public function shop_detail(){
        return $this->hasOne(ShopDetail::class,'merchant_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
