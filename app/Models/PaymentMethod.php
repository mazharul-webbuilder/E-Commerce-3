<?php

namespace App\Models;

use App\Models\Ecommerce\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
