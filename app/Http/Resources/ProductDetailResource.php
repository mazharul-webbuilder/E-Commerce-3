<?php

namespace App\Http\Resources;

use App\Models\Ecommerce\Product;
use App\Models\Seller\Seller;
use App\Models\SellerProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $type=null;
    private $seller_or_affiliate=null;

    private $sale_type=['seller','affiliate'];

    public function __construct($resource,$seller_or_affiliate,$type)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->type=$type;
        $this->seller_or_affiliate=$seller_or_affiliate;
    }

    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'title'=>$this->title,
            'product_code'=>$this->product_code,
            'previous_price'=>$this->previous_price($this->id),
            'current_price'=>$this->get_seller_price($this->id),
            'previous_coin'=>$this->previous_coin,
            'current_coin'=>$this->current_coin,
            'thumbnail'=>$this->thumbnail,
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'galleries'=>$this->galleries->map(function ($data){
                return [
                    "id"  => $data->id,
                    'image'=>$data->image
                ];
            }),
            'sizes'=>$this->stocks->map(function ($data){
                return [
                    "id"  => $data->size_id,
                    "size_name"  => $data->size->name,
                ];
            }),
            'public_reviews'=>$this->public_reviews->map(function ($data){
               return[
                   'id'=>$data->id,
                   'ratting'=>$data->ratting,
                   'created'=>$data->created_at,
                   'comment'=>$data->comment,
                   'reviewer'=>[
                       'name'=>$data->user->name,
                       'avatar'=>$data->user->avatar
                   ]
               ];
            })
        ];
    }

    private function previous_price($product_id){
        if ($this->type==null){
            return $this->previous_price;
        }else{
           if ($this->type==$this->sale_type[1]){
               return $this->previous_price;
           }else{
               return null;
           }
        }
    }

    private function get_seller_price($product_id){
        if ($this->type==null){
            $product=Product::find($product_id);
            return $product->current_price;
        }else{
            if ($this->type==$this->sale_type[0]){
                $reseller=Seller::where('seller_number',$this->seller_or_affiliate)->first();
                $seller_product=SellerProduct::where(['seller_id'=>$reseller->id,'product_id'=>$product_id])->first();
                return $seller_product->seller_price;
            }else{
                $product=Product::find($product_id);
                return $product->current_price;
            }
        }
    }


}
