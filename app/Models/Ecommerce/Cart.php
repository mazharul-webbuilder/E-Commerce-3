<?php

namespace App\Models\Ecommerce;

use App\Models\SellerProduct;
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

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public static function carts()
    {
       if (auth()->guard('api')->check()){
           $carts=Cart::where(['user_id'=>auth()->guard('api')->user()->id])->get();
       }else{
           $carts=Cart::where(['ip_address'=>\Request::ip()])->get();
       }
       return $carts;
    }


    public static function subtotal()
    {
        $carts = self::carts();
        $subtotal = 0;
        foreach ($carts as $cart)
        {
            if ($cart->seller_id==null)
            {
                $subtotal += $cart->product->price() * $cart->quantity;
            }else
            {
                $subtotal += seller_price($cart->seller_id,$cart->product_id)->seller_price * $cart->quantity;
            }
        }
        return $subtotal;
    }


    public static function total_item()
    {
        $carts = self::carts();
        return count($carts);
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
