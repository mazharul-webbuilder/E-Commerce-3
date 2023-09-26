<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;
    protected $guarded=[];
    const getting_source=['rank_update','withdrawal','transfer','league_tournament','convert'];
    const token_type=['gift','green'];

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

    public function withdrawal(){
        return $this->belongsTo(User::class,'withdrawal_id');
    }
}
