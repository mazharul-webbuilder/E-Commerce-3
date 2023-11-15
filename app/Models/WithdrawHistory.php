<?php

namespace App\Models;

use App\Models\Affiliate\Affiliator;
use App\Models\Merchant\Merchant;
use App\Models\Seller\Seller;
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

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function affiliator()
    {
        return $this->belongsTo(Affiliator::class, 'affiliator_id');
    }
}
