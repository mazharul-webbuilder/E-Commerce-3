<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserConnectCodeVerifyRequest;
use App\Http\Requests\UserConnectRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ConnectionWithUserAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('merchant');
    }

    /**
     * Display Connect with user account page
    */
    public function index(): View|RedirectResponse
    {
        if (isset(get_auth_merchant()->user_id)){
            return redirect()->route('merchant.connected.user.account');
        }
        return \view('merchant.userAccount.index');
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
            $userId = DB::table('users')->where('playerid', $request->playerId)->value('id');
            $merchant = get_auth_merchant();
            $merchant->user_id = $userId;
            $merchant->save();
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
        $connectedUser = User::find(get_auth_merchant()->user_id);

        return \view('merchant.userAccount.connected_user', compact('connectedUser'));
    }

    /**
     * Disconnect User Account
    */
    public function userDisconnect(): JsonResponse
    {
        try {
            $merchant = get_auth_merchant();
            $merchant->user_id = null;
            $merchant->save();
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
