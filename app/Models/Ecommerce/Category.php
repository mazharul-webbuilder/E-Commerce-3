<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ecommerce\SubCategory;

class Category extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function subCategories(){
        return $this->hasMany(SubCategory::class);
    }

}
