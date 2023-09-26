<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavePaymentMethod extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function withdraw_payment()
    {
        return $this->belongsTo(WithdrawPayment::class,'withdraw_payment_id');
    }
}
