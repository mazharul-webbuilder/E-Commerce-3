<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpSendLimit extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function save_payment_method(){
        return $this->belongsTo(SavePaymentMethod::class,'save_payment_method_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
