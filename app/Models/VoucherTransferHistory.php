<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTransferHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function transfer_from(){
        return $this->belongsTo(ShareOwner::class,'transfer_from_id');
    }

    public function transfer_to(){
        return $this->belongsTo(ShareOwner::class,'transfer_to_id');
    }

    public function voucher_request(){
        return $this->belongsTo(VoucherRequest::class,'voucher_request_id');
    }


}
