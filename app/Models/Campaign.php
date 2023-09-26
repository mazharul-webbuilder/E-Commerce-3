<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $guarded = [];
    const OFFER_TYPE=['vip'=>'vip','partner'=>'partner','star'=>'star','sub_controller'=>'sub_controller','controller'=>'controller','diamond_partner'=>'diamond_partner','download'=>'download'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class,'tournament_id');
    }

    public function position()
    {
        return $this->belongsTo(CampaignPosition::class,'campaign_position_id');
    }
}
