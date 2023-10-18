<?php

namespace App\Models;

use App\Models\Ecommerce\Payment;
use App\Models\Seller\Seller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    use HasFactory;

    protected $table = 'recharges';

    protected $guarded=[];

    public function seller(){
        return $this->belongsTo('seller_id',Seller::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
