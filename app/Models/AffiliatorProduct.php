<?php

namespace App\Models;

use App\Models\Affiliate\Affiliator;
use App\Models\Ecommerce\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliatorProduct extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function affiliator(){
        return $this->belongsTo(Affiliator::class);
    }
}
