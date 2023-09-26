<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{

    public function show_form()
    {
        if (Auth::guard('merchant')->check()) {
            return redirect()->route('merchant.dashboard');
        }
        else{
            return view('merchant.auth.login');
        }

    }

    public function show_form_submit(Request $request){


        if ($request->isMethod('post')){
            try {
                DB::beginTransaction();
                $credentials = $request->only('email', 'password');
                if (Auth::guard('merchant')->attempt($credentials)) {
                    return response()->json([
                        'message'=>'Successfully login',
                        'route'=>route('merchant.dashboard'),
                        'status'=>Response::HTTP_OK,
                        'type'=>'success'
                    ],Response::HTTP_OK);
                }else{
                    return response()->json([
                        'message'=>'Credential Not match',
                        'route'=>null,
                        'status'=>Response::HTTP_BAD_REQUEST,
                        'type'=>'error'
                    ],Response::HTTP_OK);
                }

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'route'=>null,
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                    'type'=>'error'
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function logout(Request $request)
    {

        if (Auth::guard('merchant')->check()) {
            Auth::guard('merchant')->logout();
            Alert::success('Successfully Logout');
            return redirect()->route('merchant.login.show');
        }
        else{
            Alert::warning('Something went A wrong!.');
            return back();
        }
    }
}
