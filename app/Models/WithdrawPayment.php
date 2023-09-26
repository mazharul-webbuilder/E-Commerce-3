<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawPayment extends Model
{
    use HasFactory;
    protected $guarded=[];



    public function saved_payment(){
        return $this->hasOne(SavePaymentMethod::class,'withdraw_payment_id');
    }
}
