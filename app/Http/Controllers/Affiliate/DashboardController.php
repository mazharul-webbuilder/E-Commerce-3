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
            DB::beginTransaction();
            if ($request->has('password')) {
                $request->merge([
                    'password' => Hash::make($request->password)
                ]);
            }
            $seller = Auth::guard('affiliate')->user();
            $seller->update($request->all());
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
