<?php

namespace App\Models;

use App\Models\Ecommerce\Product;
use App\Models\Seller\Seller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProduct extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
