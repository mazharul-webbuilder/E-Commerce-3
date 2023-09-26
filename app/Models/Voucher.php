<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function share_owner(){
        return $this->belongsTo(ShareOwner::class);
    }
}
