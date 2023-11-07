<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function auth_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
//            Alert::success('Welcome to Admin Panel.');
            return redirect()->route('dashboard');
        } else {
            Alert::warning('Credential not matched.')->persistent('dismiss');
            return redirect()->route('show.login');
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
