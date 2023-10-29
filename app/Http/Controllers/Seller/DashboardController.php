<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProfileUpdateRequest;
use App\Models\Seller\Seller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }
    /**
     * Display Seller Dashboard
    */
    public function index(): View
    {
        return view('seller.index');
    }
    /**
     * Display Seller Profile Page
    */
    public function profile(): View
    {
        $data = Auth::guard('seller')->user();

        return \view('seller.profile', compact('data'));
    }
    /**
     * Update Seller Profile
    */
    public function update_profile(SellerProfileUpdateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $seller = Auth::guard('seller')->user();
            /*Image*/
            if ($request->hasFile('image')) {
                delete_2_type_image_if_exist($seller, 'seller');
                $request->merge([
                    'avatar' => store_2_type_image_nd_get_image_name($request, 'seller', 200, 200)
                ]);
            }
            /*Take data without image value*/
            $data = $request->except('image');

            /*Password*/
            if (!is_null($request->password)) {
                $data['password'] = Hash::make($request->password);
            } else {
                $data = $request->except('password', 'image');
            }
            $seller->update($data);
            DB::commit();
            return response()->json([
                'message' => 'Profile Updated Successfully',
                'response' => Response::HTTP_OK,
                'type' => 'success'
            ]);

        } catch (QueryException $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error'
            ]);
        }
    }

}
