<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    protected $guarded=[];

    const priority=[0,1,2,3,4,5];
    const priority_meaning='0=Normal,1=VIP member,2=partner,3=club/start,4=sub controller,5=controller';
}
