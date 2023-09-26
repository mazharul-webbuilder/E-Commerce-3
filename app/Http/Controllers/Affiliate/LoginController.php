<?php

namespace App\Http\Controllers\Affiliate;

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
        if (Auth::guard('affiliate')->check()) {
            return redirect()->route('affiliate.dashboard');
        }
        else{
            return view('affiliate.auth.login');
        }

    }

    public function show_form_submit(Request $request){


        if ($request->isMethod('post')){
            try {
                DB::beginTransaction();
                $credentials = $request->only('email', 'password');
                if (Auth::guard('affiliate')->attempt($credentials)) {
                    return response()->json([
                        'message'=>'Successfully login',
                        'route'=>route('affiliate.dashboard'),
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

        if (Auth::guard('affiliate')->check()) {
            Auth::guard('affiliate')->logout();
            Alert::success('Successfully Logout');
            return redirect()->route('affiliate.login.show');
        }
        else{
            Alert::warning('Something went A wrong!.');
            return back();
        }
    }
}
