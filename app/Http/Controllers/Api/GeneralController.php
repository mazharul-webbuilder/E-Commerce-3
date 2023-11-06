<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Models\Affiliate\Affiliator;
use App\Models\Merchant\Merchant;
use App\Models\Seller\Seller;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    public function send_verification_code(Request $request){

        if ($request->isMethod("post")){
            $validator =Validator::make($request->all(),[
                'email_or_phone'=>'required',
            ]);

            try {
                if (!$validator->fails()){

                    if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)){

                          $verify_code=rand(10000,99999);
                          $data  =new VerificationCode();
                          $data->verify_code=$verify_code;
                          $data->email_or_phone=$request->email_or_phone;
                          $data->type='email';

                          $mail_info=[
                                'subject'=>"Netel Mart: Email verification  code.",
                                'body'=>"Hey dear, valuable user your verification code is"."<h1>".$verify_code."</h2>"
                          ];

                        send_mail($mail_info,$request->email_or_phone);
                        //dispatch(new SendMailJob($mail_info,$request->email_or_phone));

                        $data->save();

                    return response()->json([
                        'message'=>'You have been sent a verification code to email.',
                        'type'=>"success",
                        'status'=>200],Response::HTTP_OK);
                    }else{
                        return "Phone verification code";
                    }

                }else {

                    return response()->json([
                        'message'       =>$validator->errors()->first(),
                        'type'          =>"error",
                        'status' =>422
                    ],Response::HTTP_UNPROCESSABLE_ENTITY);
                }

            }catch (QueryException $exception){
                return response()->json([
                    'message'       =>$exception->getMessage(),
                    'type'          =>"error",
                    'status' =>500
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }




    public function verify_email_phone(Request  $request){

        $this->validate($request,[
            'verify_code'=>'required',
        ]);
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();

                    $data=VerificationCode::where('verify_code',$request->verify_code)->first();

                if (!is_null($data)){
                    $data->delete();
                    DB::commit();
                    return response()->json([
                        'message'=>"Successfully verified",
                        'type'=>"success",
                        'status'=>200,
                        'verified'=>1,
                    ],Response::HTTP_OK);

                }else{

                    return response()->json([
                        'message'=>"Invalid verification code",
                        'type'=>"error",
                        'status'=>200,
                        'verified'=>0,
                    ],Response::HTTP_OK);

                }
            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'       =>$exception->getMessage(),
                    'type'          =>"error",
                    'status' =>500
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function check_user_account(Request $request){
        $this->validate($request,[
            'player_number'=>'required',
        ]);
        try {
            DB::beginTransaction();

            $user_account=User::where('playerid',$request->player_number)->first();

            if (!is_null($user_account)){
                $verify_code=rand(10000,99999);
                $data  =new VerificationCode();
                $data->verify_code=$verify_code;
                $data->email_or_phone=$user_account->email;
                $data->type='email';
               $data->save();

                $data=[
                    'subject'=>"Netel Mart: User account checking code",
                    'body'=>'Hello,'.$user_account->name.'. Your are going create affiliates account by using your user account. Please use this code'.'<h1>'.$verify_code.'</h1>'.' to verify your identification'
                ];

                mail_template($data,$user_account->email);
                DB::commit();
                return response()->json([
                    'message'=>"You have been sent a OTP to your user account phone",
                    'type'=>"success",
                    'status'=>Response::HTTP_CREATED,
                ],Response::HTTP_CREATED);

            }else{
                return response()->json([
                    'message'=>"User account not found",
                    'type'=>"warning",
                    'status'=>Response::HTTP_NO_CONTENT,
                ],Response::HTTP_OK);
            }

        }catch (QueryException $exception){
            DB::rollBack();
            return response()->json([
                'message'       =>$exception->getMessage(),
                'type'          =>"error",
                'status' =>500
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
