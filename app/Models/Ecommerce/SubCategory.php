<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $guarded=[];
    public  function category()
    {
        return $this->belongsTo(Category::class);
    }
}
