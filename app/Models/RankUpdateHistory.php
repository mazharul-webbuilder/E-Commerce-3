<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankUpdateHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function previous_rank()
    {
        return $this->belongsTo(Rank::class,'previous_rank_id');
    }
    public function current_rank()
    {
        return $this->belongsTo(Rank::class,'current_rank_id');
    }
}
