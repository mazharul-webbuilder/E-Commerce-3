<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function withdraw_payment(){
        return $this->belongsTo(WithdrawPayment::class);
    }

    public function share_owner(){
        return $this->belongsTo(ShareOwner::class,'share_owner_id');
    }
}
