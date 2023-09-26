<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareHolder extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function share_owner(){
        return $this->belongsTo(ShareOwner::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'parent_id');
    }
}
