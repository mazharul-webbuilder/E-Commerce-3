<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareTransferHistory extends Model
{
    use HasFactory;
    protected $guarded =  [];

    public function share_holder()
    {
        return $this->belongsTo(ShareHolder::class,'share_holder_id');
    }
    public function share_from_user(){
        return $this->belongsTo(ShareOwner::class,'share_from');
    }
    public function share_to_user(){
        return $this->belongsTo(ShareOwner::class,'share_to');
    }
}
