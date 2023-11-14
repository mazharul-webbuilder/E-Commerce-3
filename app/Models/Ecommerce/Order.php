<?php

namespace App\Models\Ecommerce;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    public  function order_detail()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function seller_order_detail()
    {
        return $this->hasMany(Order_detail::class, 'order_id')->where('sell_type', 'seller');
    }

    public function products()
    {

    }



}
