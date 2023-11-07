<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminLoginController extends Controller
{
    /**
     * Show Application Admin User Login page Or Admin Dashboard
    */
    public function showForm(): View | RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        } else {
            return view('webend.login');
        }
    }


    /**
     * Admin Auth Check
    */
    public function auth_login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required',
        ],[
            'email.exists' => 'Email not found'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'Welcome to Admin Dashboard'
            ]);
        } else {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error',
                'message' => 'Credential not match'
            ]);
        }
    }


    public function admin_logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            Alert::success('Admin loged out.');
            return redirect()->route('show.login');
        } else {
            Alert::warning('Something went A wrong!.');
            return back();
        }
    }
}
