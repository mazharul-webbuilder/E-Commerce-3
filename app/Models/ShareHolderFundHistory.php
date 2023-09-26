<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareHolderFundHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function share_holder_income_sources(){
        return $this->belongsTo(ShareHolderIncomeSource::class,'income_source_id');
    }
}
