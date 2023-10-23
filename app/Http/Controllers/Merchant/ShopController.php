<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopSettingRequest;
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
            DB::commit();

            if ($request->hasFile('image')) {
                $shop_detail = ShopDetail::where('merchant_id', $merchant->id)->first();

                if (!is_null($shop_detail->logo)) {
                    $original_image_path = "uploads/shop/original/{$shop_detail->logo}";
                    $resize_image_path = "uploads/shop/resize/{$shop_detail->logo}";

                    if (File::exists(public_path($original_image_path))) {
                        // Set permissions before deleting (e.g., set to 0644)
                        File::chmod(public_path($original_image_path), 0644);
                        File::chmod(public_path($resize_image_path), 0644);

                        // Delete the files
                        File::delete(public_path($original_image_path));
                        File::delete(public_path($resize_image_path));
                    }
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
                $shop_detail->save();
            }

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


