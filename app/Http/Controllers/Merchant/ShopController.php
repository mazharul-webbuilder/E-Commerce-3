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
                    'trade_licence_issued' => $request->trade_licence_issued,
                    'trade_licence_expired' => $request->trade_licence_expired,
                    'help_line' => $request->help_line,
                    'available_time' => $request->available_time,
                ]
            );
            DB::commit();

            if ($request->hasFile('image')) {
                $shop_detail = ShopDetail::where('merchant_id', $merchant->id)->first();
                $shop_detail->image = $shop_detail->logo;
                if (!is_null($shop_detail)) {
                    delete_2_type_image_if_exist($shop_detail, 'shop');
                }
                $shop_detail->logo = store_2_type_image_nd_get_image_name($request, 'shop', 200, 200);
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


