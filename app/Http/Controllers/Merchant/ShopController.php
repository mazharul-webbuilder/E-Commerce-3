<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopSettingRequest;
use App\Models\Ecommerce\Product;
use App\Models\ShopDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('merchant');
    }

    /**
     * Show Merchant Shop In Merchant Dashboard
    */
    public function myShop(): View
    {
        $merchant = Auth::guard('merchant')->user();

        $shop = ShopDetail::where('merchant_id', $merchant->id)->first();

        $products = Product::where('merchant_id', $merchant->id)->where('status', 1)->get();

        return  \view('merchant.shop.my_shop', compact('shop', 'products'));
    }

    /**
     * Shop Active Product Details
    */
    public function productDetails($id): View
    {
        $product = Product::find($id);

        return  view('merchant.shop.detail', compact('product'));
    }

    /**
     * Merchant Shop Setting Page Load
    */
    public function setting(): View
    {
        $data = ShopDetail::where('merchant_id', Auth::guard('merchant')->user()->id)->first();

        return \view('merchant.shop.index', compact('data'));
    }

    /**
     * Store Shop Setting
    */
    public function settingPost(ShopSettingRequest $request): JsonResponse
    {
        $merchant = Auth::guard('merchant')->user();
        try {
            DB::beginTransaction();
            DB::table('shop_details')->updateOrInsert(
                ['merchant_id' => Auth::guard('merchant')->user()->id],
                [
                    'shop_name' => $request->shop_name,
                    'legal_name' => $request->legal_name,
                    'detail' => $request->detail,
                    'address' => $request->address,
                    'trade_licence' => $request->trade_licence,
                    'trade_licence_issued' => date("d-m-Y",strtotime($request->trade_licence_issued)),
                    'trade_licence_expired' => date("d-m-Y",strtotime($request->trade_licence_expired)),
                    'help_line' => $request->help_line,
                    'available_time' => $request->available_time,
                ]
            );
            /*Get Merchant Shop Details*/
            $shop_detail = ShopDetail::where('merchant_id', $merchant->id)->first();

            if ($request->hasFile('image')) {
                if (!is_null($shop_detail->logo)) {
                    delete_2_type_image_if_exist_latest($shop_detail->logo, 'shop');
                }

                $image = $request->file('image');
                $image_name = strtolower(Str::random(10)) . time() . "." . $image->getClientOriginalExtension();

                $original_directory = "uploads/shop/original";
                $resize_directory = "uploads/shop/resize";

                if (!File::exists(public_path($original_directory))) {
                    File::makeDirectory(public_path($original_directory), 0777, true);
                    File::makeDirectory(public_path($resize_directory), 0777, true);
                }
                $original_image_path = public_path("{$original_directory}/{$image_name}");
                $resize_large_path = public_path("{$resize_directory}/{$image_name}");

                Image::make($image)->save($original_image_path);
                Image::make($image)->resize(200, 200)->save($resize_large_path);

                $shop_detail->logo = $image_name;

            }
            /*Add Banner*/
            if ($request->hasFile('banner')) {
                if (!is_null($shop_detail->banner)) {
                    delete_2_type_image_if_exist_latest(imageName: $shop_detail->banner, folderName:  'shop/banner');
                }
                /*Store Banner New Image*/
                $image = $request->file('banner');
                $image_name = strtolower(Str::random(10)) . time() . "." . $image->getClientOriginalExtension();

                $original_directory = "uploads/shop/banner/original";
                $resize_directory = "uploads/shop/banner/resize";

                if (!File::exists(public_path($original_directory))) {
                    File::makeDirectory(public_path($original_directory), 0777, true);
                    File::makeDirectory(public_path($resize_directory), 0777, true);
                }
                $original_image_path = public_path("{$original_directory}/{$image_name}");
                $resize_large_path = public_path("{$resize_directory}/{$image_name}");

                Image::make($image)->save($original_image_path);
                Image::make($image)->resize(1080, 720)->save($resize_large_path);

                $shop_detail->banner = $image_name;
            }

            /*Shop Save*/
            $shop_detail->save();

            DB::commit();
            return  response()->json([
                'message' => 'Setting Successfully',
                'type' => 'success',
                'response' => Response::HTTP_OK
            ]);
        } catch (QueryException $exception) {
            DB::rollBack();
            return  response()->json([
               'message' => $exception->getMessage(),
               'type' => 'error',
               'response' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

}


