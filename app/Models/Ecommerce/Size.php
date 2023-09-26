<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
