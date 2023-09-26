<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinUseHistory extends Model
{
    use HasFactory;
    protected $guarded = [];
    // these constant indexing should not be changed. If you want to add another element it must be placed from right site
    const balance_type = ['paid_coin', 'win_balance', 'paid_diamond', 'free_coin', 'free_diamond', 'shareholder_fund', 'marketing_balance', 'recovery_fund'];
    const balance_uses_purpose = ['diamond_purchase', 'diamond_partner', 'rank_update', 'tournament_registration', 'bidding', 'purchase_share', 'home_game'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
