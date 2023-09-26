<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation_commission extends Model
{
    use HasFactory;
    protected $guarded=[];
    const generation_name=[
        '1st generation',
        '2nd generation',
        '3rd generation',
        '4th generation',
        '5th generation',
        '6th generation',
        '7th generation',
        '8th generation',
        '9th generation',
        '10th generation',
        '11th generation',
        '12th generation',
        '13th generation',
        '14th generation',
        '15th generation'
    ];
    const generation_level=['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th','15th'];
}
