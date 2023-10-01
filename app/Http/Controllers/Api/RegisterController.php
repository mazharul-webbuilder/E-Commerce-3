<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Affiliate\Affiliator;
use App\Models\Merchant\Merchant;
use App\Models\Seller\Seller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                    $data                 =new Merchant();
                    $data->name           =$request->name;
                    $data->email          =$request->email;
                    $data->password       =Hash::make($request->password);
                    $data->merchant_number="M".rand(100000,999990);

                    if ($request->hasFile('avatar')) {
                        $avatar=$request->avatar;
                        $avatar_name=strtolower(Str::random(10)).time().".".$avatar->getClientOriginalExtension();
                        $location=public_path().'/uploads/merchant/'.$avatar_name;
                        Image::make($avatar)->save($location);
                        $data->avatar=$avatar_name;
                    }
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
                    $data                 =new Seller();
                    $data->name           =$request->name;
                    $data->email          =$request->email;
                    $data->password       =Hash::make($request->password);
                    $data->seller_number="S".rand(100000,999999);

                    if ($request->hasFile('avatar')) {
                        $avatar=$request->avatar;
                        $avatar_name=strtolower(Str::random(10)).time().".".$avatar->getClientOriginalExtension();
                        $location=public_path().'/uploads/seller/'.$avatar_name;
                        Image::make($avatar)->save($location);
                        $data->avatar=$avatar_name;
                    }
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
                    $data                 =new Affiliator();
                    $data->name           =$request->name;
                    $data->email          =$request->email;
                    $data->password       =Hash::make($request->password);
                    $data->affiliate_number="A".rand(100000,999990);

                    if ($request->hasFile('avatar')) {
                        $avatar=$request->avatar;
                        $avatar_name=strtolower(Str::random(10)).time().".".$avatar->getClientOriginalExtension();
                        $location=public_path().'/uploads/affiliator/'.$avatar_name;
                        Image::make($avatar)->save($location);
                        $data->avatar=$avatar_name;
                    }
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


