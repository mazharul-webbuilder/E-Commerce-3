<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidderCommissionHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function bidder(){
        return $this->belongsTo(User::class,'bidder_id');
    }
    public function bidded_to(){
        return $this->belongsTo(User::class,'bidded_to');
    }
    public function board(){
        return $this->belongsTo(Roundludoboard::class,'board_id');
    }

}
