<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerifyAccount;
use App\Models\Affiliate\Affiliator;
use App\Models\Merchant\Merchant;
use App\Models\Seller\Seller;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;


class RegisterController extends Controller
{



    public function merchant_register(Request $request){

        if ($request->isMethod("post")){
            $validator = Validator::make($request->all(),[
                'name'          =>'required|string',
                'email'         =>'required|email|unique:merchants',
                'password'      =>'required|min:4|confirmed',
                'avatar'        =>'nullable|mimes:jpeg,png,jpg',
            ]);
            try {
                if (!$validator->fails()){
                    $verification_code=rand(10000,99999);
                    $data                 =new Merchant();
                    $data->name           =$request->name;
                    $data->email          =$request->email;
                    $data->phone          =$request->phone;
                    $data->password       =Hash::make($request->password);
                    $data->merchant_number="M".rand(100000,999990);
                    $data->verification_code=$verification_code;

                    if ($request->hasFile('avatar')) {
                        $avatar=$request->avatar;
                        $avatar_name=strtolower(Str::random(10)).time().".".$avatar->getClientOriginalExtension();
                        $location=public_path().'/uploads/merchant/'.$avatar_name;
                        Image::make($avatar)->save($location);
                        $data->avatar=$avatar_name;
                    }

                    $main_info=[
                        'subject'=>"Netel Mart: Merchant Account Verification code.",
                        'body'=>"Hey ,".$request->name.",your merchant account has been created successfully.
                        \n Please verify your by using this code.\n Verification code.".'<h1>'.$verification_code.'</h1>',
                        'login_link'=>route('merchant.login.show')
                    ];

                    send_mail($main_info,$request->email);

                    $data->save();

                    return response()->json([
                        'message'=>'Your Registration has been successfully',
                        'type'=>"success",
                        'status'=>200],Response::HTTP_OK);
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

    public function email_verification(Request  $request){

        $this->validate($request,[
            'verification_code'=>'required',
            'type'=>'required',
        ]);
            if ($request->isMethod("post")){
                try {
                    DB::beginTransaction();

                    if ($request->type=="merchant"){
                        $data=Merchant::where('verification_code',$request->verification_code)->first();
                    }elseif ($request->type=="affiliate"){
                        $data=Affiliator::where('verification_code',$request->verification_code)->first();
                    }elseif ($request->type=='seller'){
                        $data=Seller::where('verification_code',$request->verification_code)->first();
                    }

                    if (!is_null($data)){
                        $data->verified_at=Carbon::now()->format('Y-m-d H:m:s');
                        $data->verification_code=null;
                        $data->save();
                        DB::commit();

                        return response()->json([
                            'message'=>"Verification success",
                            'type'=>"success",
                            'status'=>200
                        ],Response::HTTP_OK);

                    }else{

                        return response()->json([
                            'message'=>"Verification code not found",
                            'type'=>"warning",
                            'status'=>Response::HTTP_BAD_REQUEST
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


    public function seller_register(Request $request){

        if ($request->isMethod("post")){
            $validator = Validator::make($request->all(),[
                'name'          =>'required|string',
                'email'         =>'required|email|unique:sellers',
                'password'      =>'required|min:4|confirmed',
                'avatar'        =>'nullable|mimes:jpeg,png,jpg',
            ]);
            try {
                if (!$validator->fails()){
                    $verification_code=rand(10000,99999);
                    $data                 =new Seller();
                    $data->name           =$request->name;
                    $data->phone          =$request->phone;
                    $data->email          =$request->email;
                    $data->password       =Hash::make($request->password);
                    $data->seller_number="S".rand(100000,999999);
                    $data->verification_code=$verification_code;

                    if ($request->hasFile('avatar')) {
                        $avatar=$request->avatar;
                        $avatar_name=strtolower(Str::random(10)).time().".".$avatar->getClientOriginalExtension();
                        $location=public_path().'/uploads/seller/'.$avatar_name;
                        Image::make($avatar)->save($location);
                        $data->avatar=$avatar_name;
                    }

                    $main_info=[
                        'subject'=>"Netel Mart: Reseller Account Verification code.",
                        'body'=>"Hey ,".$request->name.",your  Reseller account has been created successfully.
                        \n Please verify your by using this code.\n Verification code.".'<h1>'.$verification_code.'</h1>',
                        'login_link'=>route('seller.login.show')
                    ];

                    send_mail($main_info,$request->email);
                    $data->save();
                    return response()->json([
                        'message'=>'Your Registration has been successfully',
                        'type'=>"success",
                        'status'=>200],Response::HTTP_OK);
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

    public function affiliate_register(Request $request){

        if ($request->isMethod("post")){
            $validator = Validator::make($request->all(),[
                'name'          =>'required|string',
                'email'         =>'required|email|unique:affiliators',
                'password'      =>'required|min:4|confirmed',
                'avatar'        =>'nullable|mimes:jpeg,png,jpg',
            ]);

            try {
                if (!$validator->fails()){
                    $verification_code=rand(10000,99999);
                    $data                 =new Affiliator();
                    $data->name           =$request->name;
                    $data->email          =$request->email;
                    $data->phone          =$request->phone;
                    $data->password       =Hash::make($request->password);
                    $data->affiliate_number="A".rand(100000,999990);
                    $data->verification_code=$verification_code;

                    if ($request->hasFile('avatar')) {
                        $avatar=$request->avatar;
                        $avatar_name=strtolower(Str::random(10)).time().".".$avatar->getClientOriginalExtension();
                        $location=public_path().'/uploads/affiliator/'.$avatar_name;
                        Image::make($avatar)->save($location);
                        $data->avatar=$avatar_name;
                    }

                    $main_info=[
                        'subject'=>"Netel Mart: Affiliate Account Verification code.",
                        'body'=>"Hey ,".$request->name.",your  Affiliate account has been created successfully.
                        \n Please verify your by using this code.\n Verification code.".'<h1>'.$verification_code.'</h1>',
                        'login_link'=>route('affiliate.login.show')
                    ];

                    send_mail($main_info,$request->email);

                    $data->save();
                    return response()->json([
                        'message'=>'Your Registration has been successfully',
                        'type'=>"success",
                        'status'=>200],Response::HTTP_OK);
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

}


