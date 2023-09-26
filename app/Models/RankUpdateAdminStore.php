<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankUpdateAdminStore extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function rank_update_admin_store()
    {
        return $this->belongsTo(RankUpdateHistory::class,'rank_update_history_id');
    }
}
