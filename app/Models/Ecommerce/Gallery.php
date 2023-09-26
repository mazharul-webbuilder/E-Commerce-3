<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
