<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Review;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function get_recent_product()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'recent' => 1, 'flash_deal' => 0])
            ->take(8)
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function get_recent_product_all()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'recent' => 1, 'flash_deal' => 0])
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function get_most_sale_product()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'most_sale' => 1, 'flash_deal' => 0])
            ->take(8)
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function get_most_sale_product_all()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'most_sale' => 1, 'flash_deal' => 0])
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function get_best_sale_product()
    {

        $products = DB::table('products')
            ->where(['status' => 1, 'best_sale' => 1, 'flash_deal' => 0])
            ->take(8)
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function get_best_sale_product_all()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'best_sale' => 1, 'flash_deal' => 0])
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }


    public function get_flash_deal_product()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'flash_deal' => 1])
            ->take(8)
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function get_flash_deal_product_all()
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'flash_deal' => 1])
            ->latest()->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }

    public function category_wise_product($id)
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'category_id' => $id])
            ->latest()
            ->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }


    public function subcategory_wise_product($id)
    {
        $products = DB::table('products')
            ->where(['status' => 1, 'sub_category_id' => $id])
            ->latest()
            ->get();
        $data = ProductResource::collection($products);
        return response()->json([
            'products' => $data,
            'status' => 200
        ], Response::HTTP_OK);
    }


    public function provide_review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'ratting' => 'required',
            'comment' => 'required'
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
                        ->where(['user_id' => auth()->user()->id, 'order_id' => $request->order_id])
                        ->first();
                    if (!is_null($check_order)) {
                        $review = new Review();
                        $review->product_id = $request->product_id;
                        $review->user_id = auth()->user()->id;
                        $review->ratting = $request->ratting;
                        $review->comment = $request->comment;
                        $review->order_id = $check_order->order_id;
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
                } catch (QueryException $e) {
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

    public function search_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => "error",
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $products = Product::where('title', "LIKE", "%$request->keyword%")
                ->orWhere('title', "LIKE", "%$request->keyword%")
                ->orWhere('previous_price', "LIKE", "%$request->keyword%")
                ->orWhere('current_price', "LIKE", "%$request->keyword%")
                ->orWhere('previous_coin', "LIKE", "%$request->keyword%")
                ->orWhere('current_coin', "LIKE", "%$request->keyword%")
                ->where(['status' => 0])->get();

            $data = ProductResource::collection($products);
            return response()->json([
                'products' => $data,
                'status' => 200,
                'type' => 'success',
            ], Response::HTTP_OK);
        }
    }

    public function product_detail($id)
    {
        $product = Product::find($id);
        $review = Review::where('product_id', $id)->with('user:id,name,avatar')->get();
        $five_star_review = Review::where('product_id', $id)->where('ratting', 5)->get();
        $four_star_review = Review::where('product_id', $id)->where('ratting', 4)->get();
        $three_star_review = Review::where('product_id', $id)->where('ratting', 3)->get();
        $two_star_review = Review::where('product_id', $id)->where('ratting', 2)->get();
        $one_star_review = Review::where('product_id', $id)->where('ratting', 1)->get();

        $product = new ProductDetailResource($product);
        $average_review = 0;
        if (count($review) > 0) {
            $average_review = number_format($review->sum('ratting') / count($review), 2);
        }
        return response()->json([
            'product' => $product,
            'all_review' => [
                'review' => $review->map(function ($data) {
                    return [
                        "id"  => $data->id,
                        "product_id"  => $data->product_id,
                        "reviewer_name"  => $data->user->name,
                        "avatar"  => $data->user->avatar,
                        "ratting"  => $data->ratting,
                        "comment"  => $data->comment,
                        "status"  => $data->status,
                        "coin_added"  => $data->coin_added,
                        "created_at"  => $data->created_at->format('d-m-Y, g:i A'),

                    ];
                }),
                'total_review' => count($review),
                '5_star_ratting' => count($five_star_review),
                '4_star_ratting' => count($four_star_review),
                '3_star_ratting' => count($three_star_review),
                '2_star_ratting' => count($two_star_review),
                '1_star_ratting' => count($one_star_review),
            ],
            'average_ratting' => $average_review,
            'status' => 200,
            'type' => 'success',
        ], Response::HTTP_OK);
    }
    public function my_review($id)
    {
        $review = Review::where('product_id', $id)->where('user_id', Auth::user()->id)->get();
        $five_star_review = Review::where('product_id', $id)->where('user_id', Auth::user()->id)->where('ratting', 5)->get();
        $four_star_review = Review::where('product_id', $id)->where('user_id', Auth::user()->id)->where('ratting', 4)->get();
        $three_star_review = Review::where('product_id', $id)->where('user_id', Auth::user()->id)->where('ratting', 3)->get();
        $two_star_review = Review::where('product_id', $id)->where('user_id', Auth::user()->id)->where('ratting', 2)->get();
        $one_star_review = Review::where('product_id', $id)->where('user_id', Auth::user()->id)->where('ratting', 1)->get();
        return response()->json([
            'message' => "All My review Details",
            'data' => [
                'review_details' => [
                    'review' => $review->map(function ($data) {
                        return [
                            "id"  => $data->id,
                            "product_id"  => $data->product_id,
                            "reviewer_name"  => $data->user->name,
                            "avatar"  => $data->user->avatar,
                            "ratting"  => $data->ratting,
                            "comment"  => $data->comment,
                            "status"  => $data->status,
                            "coin_added"  => $data->coin_added,
                            "created_at"  => $data->created_at->format('d-m-Y, g:i A'),
                        ];
                    }),
                    'total_review' => count($review),
                    '5_star_ratting' => count($five_star_review),
                    '4_star_ratting' => count($four_star_review),
                    '3_star_ratting' => count($three_star_review),
                    '2_star_ratting' => count($two_star_review),
                    '1_star_ratting' => count($one_star_review),
                ],
            ],
            'status' => 200,
            'type' => 'success',
        ], Response::HTTP_OK);
    }
}
