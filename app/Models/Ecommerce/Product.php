<?php

namespace App\Models\Ecommerce;

use App\Models\Brand;
use App\Models\Merchant\Merchant;
use App\Models\ProductAffiliateCommission;
use App\Models\ProductCommission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ecommerce\Unit;
use App\Models\Ecommerce\Category;
use  App\Models\Ecommerce\SubCategory;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public  function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public  function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }

    public function price()
    {
        $price=0;
        $today=date('d-m-Y');
        if ($this->flash_deal===1){
            if ($today>=$this->deal_start_date && $today<=$this->deal_end_date){
                if ($this->deal_type==="flat"){
                    $price=$this->current_price-$this->deal_amount;
                }else{
                    $total_discount=(($this->deal_amount*$this->current_price)/100);
                    $price=$this->current_price-$total_discount;
                }
            }else{
                $price=$this->current_price;
            }
        }else{
            $price=$this->current_price;
        }
        return $price;
    }

    public function product_commission()
    {
        return $this->hasOne(ProductCommission::class, 'product_id', 'id');
    }
    public function product_affiliate_commission()
    {
        return $this->hasOne(ProductAffiliateCommission::class, 'product_id', 'id');
    }

    public function reviews(){
       return $this->hasMany(Review::class);
    }
    public function public_reviews(){
        return $this->hasMany(Review::class)->where('status',1);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


}
