<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransferHistory extends Model
{
    use HasFactory;
    protected $guarded=[];
    const balance_transfer_constant=['gift_to_win','win_to_gift','marketing_to_win','marketing_gift','gift_to_dollar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
