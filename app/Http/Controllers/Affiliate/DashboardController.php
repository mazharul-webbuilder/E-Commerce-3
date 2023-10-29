<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliatorProfileUpdateRequest;
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
        $this->middleware('affiliate');
    }

    /**
     * Display Affiliator Dashboard
    */
    public function index(): View
    {
        return view('affiliate.index');
    }
    /**
     * Display Affiliator Profile Page
    */
    public function profile(): View
    {
        $data = Auth::guard('affiliate')->user();

        return \view('affiliate.profile', compact('data'));
    }
    /**
     * Update Affiliator Profile
    */
    public function update_profile(AffiliatorProfileUpdateRequest $request): JsonResponse
    {
        try {
            $affiliator = Auth::guard('affiliate')->user();
            DB::beginTransaction();

            /*Image*/
            if ($request->hasFile('image')) {
                delete_2_type_image_if_exist($affiliator, 'affiliator');
                $request->merge([
                    'avatar' => store_2_type_image_nd_get_image_name($request, 'affiliator', 200, 200)
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

            $affiliator->update($data);
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
