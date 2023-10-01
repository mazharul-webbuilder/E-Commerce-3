<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\If_;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{

    public function showForm()
    {
        if (Auth::guard('seller')->check()) {

            return redirect()->route('seller.dashboard');
        }
        else{
             return view('seller.Auth.login_form');
        }

    }

    public function formSubmit(Request $request){
        if ($request->isMethod('post')){
            try {
                DB::beginTransaction();
                $credentials = $request->only('email', 'password');
                if (Auth::guard('seller')->attempt($credentials)) {
                    return response()->json([
                        'message'=>'Successfully login',
                        'route'=>route('seller.dashboard'),
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
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'route'=>null,
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                    'type'=>'error'
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function sellerLogout(Request $request)
    {

        if (Auth::guard('seller')->check()) {
            Auth::guard('seller')->logout();
            Alert::success('Successfully Logout');
            return redirect()->route('seller.login.show');
        }
        else{
            Alert::warning('Something went A wrong!.');
            return back();
        }


    }
}
