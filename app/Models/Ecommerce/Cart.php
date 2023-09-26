<?php

namespace App\Models\Ecommerce;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;
    protected $guarded=[];

    const CART_TYPE=['cart'=>'cart','buy'=>'buy'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public static function carts()
    {
       $carts = Cart::where('user_id',Auth::user()->id)->where('status',1)->get();
        return $carts;
    }


    public static function subtotal()
    {
        $carts = Cart::where('user_id',Auth::user()->id)->where('status',1)->get();
        $subtotal = 0;
        foreach ($carts as $data)
        {
            $product = Product::find($data->product_id);
            $subtotal += $product->price() * $data->quantity;

        }
        return $subtotal;

    }
    public static function total_coin()
    {
        $carts = Cart::where('user_id',Auth::user()->id)->where('status',1)->get();
        $subtotal_coin = 0;
        foreach ($carts as $data)
        {
            $product = Product::find($data->product_id);
            $subtotal_coin += $product->current_coin * $data->quantity;

        }
        return $subtotal_coin;

    }
}
