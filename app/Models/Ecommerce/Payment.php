<?php

namespace App\Models\Ecommerce;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
