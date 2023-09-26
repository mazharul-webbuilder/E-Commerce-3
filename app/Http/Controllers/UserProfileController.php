<?php

namespace App\Http\Controllers;

use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\u;

class UserProfileController extends Controller
{


    public function add_mobile(Request $request){
        $user=auth()->user();
       $this->validate($request,[
           'mobile'=>'required|unique:users,mobile,'.$user->id,
       ]);
       if ($request->isMethod("post")){

           try {
               if ($user->is_mobile_verified==0) {
                   DB::beginTransaction();
                   $mobile_otp = rand(999999, 10000);
                   $user->mobile = $request->mobile;
                   $user->mobile_otp = $mobile_otp;
                   $user->save();
                   DB::commit();
                   $text = 'Dear ' . $user->name . ' Your OTP code is ' . $mobile_otp . '.Please verify your mobile number.';
                   send_sms($request->mobile, $text);
                   return response()->json([
                       'message' => "You have been sent an OTP code",
                       'type' => 'success',
                       'status' => Response::HTTP_OK,
                   ], Response::HTTP_OK);
               }else{
                   return response()->json([
                       'message' => "You have already added your phone number",
                       'type' => 'warning',
                       'status' => Response::HTTP_OK,
                   ], Response::HTTP_OK);
               }
           }catch (QueryException $exception){
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
           }
       }
    }

    public function verify_mobile(Request $request){
        $this->validate($request,[
            'mobile_otp'=>'required',
        ]);
        if ($request->isMethod("POST")){
            try{
                    $user=User::where('mobile_otp',$request->mobile_otp)->first();

                    if (!empty($user)){
                        DB::beginTransaction();
                        $user->mobile_otp = null;
                        $user->is_mobile_verified = 1;
                        $user->save();
                        DB::commit();
                        return response()->json([
                            'message' => "Your mobile has been successfully verified",
                            'type' => 'success',
                            'status' => Response::HTTP_OK,
                        ], Response::HTTP_OK);
                    }else{
                        return response()->json([
                            'message' => "Otp not found",
                            'type' => 'error',
                            'status' => Response::HTTP_OK,
                        ], Response::HTTP_OK);
                    }


            }catch (QueryException $exception){
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
