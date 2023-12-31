<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SliderResource;
use App\Models\Ecommerce\Cart;
use App\Models\Ecommerce\Category;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Review;
use App\Models\Ecommerce\Slider;
use App\Models\Ecommerce\Wishlist;
use App\Models\Merchant\Merchant;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EcommerceController extends Controller
{


    public function get_category(){
        $categories=Category::where('status',1)->orderBy('id','DESC')->get();
        $datas=CategoryResource::collection($categories);

        return response()->json([
            'datas'=>$datas,
            'status'=>200,
            'type'=>'success'
        ],Response::HTTP_OK);
    }

    public function category_wise_product($id){
        $datas=Product::where('category_id',$id)->where('status',1)->latest()->paginate(8);
        $products=ProductResource::collection($datas);

        return \response()->json([
            'products'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function product_detail($id,$seller_or_affiliate=null,$type=null){

        //$data=[$id,$seller_or_affiliate,$type];
        $product=Product::find($id);
        $product=new ProductDetailResource($product,$seller_or_affiliate,$type);

        return \response()->json([
            'products'=>$product,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function product_list(){
        $datas=Product::where('current_price','<=',300)->where('status',1)->latest()->paginate(8);
        $products=ProductResource::collection($datas);

        return \response()->json([
            'products'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }
    public function recommended_product($category_ids=null){

        if (!is_null($category_ids)){
            $categories=explode(',',$category_ids);

            $datas=Product::whereIn('category_id',$categories)->where('status',1)->latest()->paginate(8);

        }else{
            $datas=Product::where('status',1)->inRandomOrder()->paginate(8);
        }
        $products=ProductResource::collection($datas);

        return \response()->json([
            'products'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function slider_list(){
        $sliders=DB::table('sliders')->where('status',1)->latest()->get();
        $datas=SliderResource::collection($sliders);
        return \response()->json([
            'datas'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);

    }

    public function banner_list(){
        $banners=DB::table('banners')->where('status',1)->latest()->get();
        $datas=BannerResource::collection($banners);
        return \response()->json([
            'datas'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function flash_deal_product(){
        $today=Carbon::now()->format('d-m-Y');
        $datas=Product::where('status',1)->where('flash_deal',1)->where(function ($query) use($today){
                $query->where('deal_start_date','<=',$today);
                $query->where('deal_end_date','>=',$today);
        })->paginate(5)->map(function ($data){
            return [
                'id'=>$data->id,
                'category_id'=>$data->category_id,
                'title'=>$data->title,
                'previous_price'=>$data->previous_price,
                'current_price'=>$data->current_price,
                'previous_coin'=>$data->previous_coin,
                'current_coin'=>$data->current_coin,
                'thumbnail'=>$data->thumbnail,
                'deal_start_date'=>$data->deal_start_date,
                'deal_end_date'=>$data->deal_end_date,
                'deal_amount'=>$data->deal_amount,
                'deal_type'=>$data->deal_type
            ];
        });

        return \response()->json([
            'datas'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function add_to_wishlist(Request $request){

        $validator = Validator::make($request->all(), [
            'product_id'=>'required|integer',
        ]);

        if ($validator->fails()){
            return \response()->json([
                'data'=>$validator->errors()->first(),
                'type'=>'error',
                'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            if ($request->isMethod("POST")){
                try {
                    DB::beginTransaction();
                    if (auth()->guard('api')->check()){
                        $data=Wishlist::where(['product_id'=>$request->product_id,'user_id'=>auth()->guard('api')->user()->id])->first();
                    }else{
                        $data=Wishlist::where(['product_id'=>$request->product_id,'ip_address'=>$request->ip()])->first();
                    }
                    if (is_null($data)){
                        $wishlist=new Wishlist();
                        $wishlist->product_id=$request->product_id;
                        $wishlist->ip_address=$request->ip();
                        $wishlist->user_id=auth()->guard('api')->check() ? auth()->guard('api')->user()->id : null;
                        $wishlist->save();
                        DB::commit();
                        return \response()->json([
                            'message'=>"Successfully added to favorite",
                            'type'=>'success',
                            'status'=>Response::HTTP_OK
                        ],Response::HTTP_OK);

                    }else{
                        return \response()->json([
                            'message'=>"Already added to wishlist",
                            'type'=>'success',
                            'status'=>Response::HTTP_OK
                        ],Response::HTTP_OK);
                    }


                }catch (QueryException $exception){
                    return \response()->json([
                        'message'=>$exception->getMessage(),
                        'type'=>'error',
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        }
    }

    public function view_wishlist(){
        if (auth()->guard('api')->check()){
            $data=Wishlist::with(['product:id,title,previous_price,current_price,thumbnail',])->where(['user_id'=>auth()->guard('api')->user()->id])->get();
        }else{
            $data=Wishlist::with(['product:id,title,previous_price,current_price,thumbnail',])->where('ip_address',\Request::ip())->get();
        }

        return \response()->json([
            'datas'=>$data,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function delete_wishlist(Request $request){
        $data=Wishlist::find($request->wishlist_id);
        if (!is_null($data)){
            $data->delete();
            return \response()->json([
                'message'=>"Successfully delete",
                'type'=>'success',
                'status'=>Response::HTTP_OK
            ],Response::HTTP_OK);
        }else{
            return \response()->json([
                'message'=>"Data not found",
                'type'=>'warning',
                'status'=>Response::HTTP_NO_CONTENT
            ],Response::HTTP_OK);
        }

    }

    public function search_product(Request $request){
        if ($request->isMethod("post")){
            $datas=Product::where('short_description',"LIKE","%$request->keyword%")
                ->orWhere('title',"LIKE","%$request->keyword%")
                ->orWhere('current_price',"LIKE","%$request->keyword%")
                ->where(['status'=>1])->paginate(8);

            $products=ProductResource::collection($datas);

            return \response()->json([
                'products'=>$datas,
                'type'=>'success',
                'status'=>Response::HTTP_OK
            ],Response::HTTP_OK);
        }
    }

    public function provide_review(Request $request){
        $user= auth()->guard('api')->user();
        $product=Product::find($request->product_id);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'ratting' => 'required|integer',
            'comment' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => "error",
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            if ($request->isMethod("post")) {
                try {
                    DB::beginTransaction();
                    $check_order = Order_detail::where('product_id', $request->product_id)
                        ->where(['user_id' => $user->id, 'order_id' => $request->order_id])
                        ->first();
                    if (!is_null($check_order)) {
                        $review = new Review();
                        $review->product_id = $request->product_id;
                        $review->user_id = auth()->user()->id;
                        $review->ratting = $request->ratting;
                        $review->comment = $request->comment;
                        $review->order_id = $check_order->order_id;
                        $review->merchant_id=$product->merchant_id;
                        $review->save();
                        $check_order->review_status = 0;
                        $check_order->save();

                        DB::commit();
                        return response()->json([
                            'message' => "Review added successfully",
                            'type' => "success",
                            'status' => 200
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'message' => "Please buy this product first",
                            'type' => "success",
                            'status' => 201
                        ], Response::HTTP_OK);
                    }
                } catch (\Doctrine\DBAL\Query\QueryException $e) {
                    DB::rollBack();
                    $error = $e->getMessage();
                    return \response()->json([
                        'error' => $error,
                        'type' => 'error',
                        'status_code' => 500
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        }
    }


    public function merchant_product($merchant_id){
        $datas=Product::where('merchant_id',$merchant_id)->where('status',1)->latest()->paginate(8);
        $products=ProductResource::collection($datas);
        $merchant=Merchant::find($merchant_id);
        $merchant_data=[
                'merchant_id'=>$merchant->id,
                'merchant_name'=>$merchant->na,

                'total_product'=>count($merchant->publish_products),
                 'review_detail'=>merchant_ratting($merchant_id),
                'shop'=>$merchant->shop_detail ? [
                    'shop_name'=>$merchant->shop_detail->shop_name,
                    'logo'=>$merchant->shop_detail->logo,
                    'banner'=>$merchant->shop_detail->banner,
                    'help_line'=>$merchant->shop_detail->help_line,
                    'available_time'=>$merchant->shop_detail->available_time
                ] : ''
               ];

        return \response()->json([
            'merchant_data'=>$merchant_data,
            'products'=>$datas,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }
}
