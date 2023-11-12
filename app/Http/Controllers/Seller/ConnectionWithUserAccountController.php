<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserConnectCodeVerifyRequest;
use App\Http\Requests\UserConnectRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ConnectionWithUserAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Display Connect with user account page
     */
    public function index(): View
    {
        return \view('seller.userAccount.index');
    }

    /**
     * Send verification code to connect user account
     */
    public function sendVerificationCode(UserConnectRequest $request): JsonResponse
    {
        if (sendVerificationCode($request)) {
            return \response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'playerId' => $request->playerId,
                'message' => 'Verification code send to user email'
            ]);
        } else {
            return \response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }
    }
    /**
     * Verify Code
     */
    public function verifyCode(UserConnectCodeVerifyRequest $request): JsonResponse
    {
        if (verifyCode($request->verifyCode)) {
            $user = User::where('playerid', $request->playerId)->first();
            $seller = get_auth_seller();
            $seller->user_id = $user->id;
            $seller->save();

            if ($user->rank->priority < 1) {
                updateUserRank($user, 'seller_update');
            }

            return \response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'Your Account Successfully Connected'
            ]);
        } else {
            return \response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }
    }

    /**
     * Display Connected user account info
     */
    public function connectedAccount(): View
    {
        $connectedUser = User::find(get_auth_seller()->user_id);

        return \view('seller.userAccount.connected_user', compact('connectedUser'));
    }

    /**
     * Disconnect User Account
     */
    public function userDisconnect(): JsonResponse
    {
        try {
            $seller = get_auth_seller();
            $seller->user_id = null;
            $seller->save();
            return \response()->json([
                'response' => Response::HTTP_OK,
                'message' => 'User Disconnected Successfully',
                'type' => 'success'
            ]);
        } catch (\Exception $exception) {
            return \response()->json();
        }
    }
}
