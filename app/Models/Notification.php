<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded=[];

    const NOTIFICATION_TYPE=[
        'order'=>'order',
        'diamond'=>'diamond',
        'win'=>'win',
        'tournament'=>'tournament',
        'friend'=>'friend',
        'rank'=>'rank',
        'share_holder'=>'share_holder',
        'recovery_fund'=>'share_holder',
        'common'=>'common',
        'referral_invitation'=>'referral_invitation'
    ];
}
