<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawSaving extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function withdraw_history(){
        return $this->belongsTo(WithdrawHistory::class);
    }
}
