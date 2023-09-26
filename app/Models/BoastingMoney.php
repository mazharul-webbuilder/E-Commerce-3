<?php

namespace App\Models;

use App\Models\Ecommerce\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoastingMoney extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function payment(){
        return $this->belongsTo(Payment::class);
    }
    public function owner(){
        return $this->belongsTo(Owner::class);
    }
}
