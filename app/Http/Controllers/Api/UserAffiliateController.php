<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Affiliate\Affiliator;
use App\Models\EcommerceBalanceTransfer;
use App\Models\Merchant\Merchant;
use App\Models\Seller\Seller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAffiliateController extends Controller
{



    public function user_balance(){
        $user=auth()->user();
        return response()->json([
            'balance'=>$user->user_detail->ecommerce_balance ?? '',
            'status'=>Response::HTTP_OK,
            'type'=>'success'
        ]);
    }

    public function money_transaction(Request $request){


         $user=auth()->user();

        try {
            if ($request->type=='add_money'){
                $user_detail=UserDetail::where('user_id',$user->id)->first();
                if (!is_null($user_detail)){

                    if ($request->destination==ECOMMERCE_BALANCE_DESTINATION['merchant_to_user']){
                        $data=Merchant::where('user_id',$user->is)->first();
                        if (!is_null($data)){
                            if ($data->balance>=$request->amount){

                                $user_detail->ecommerce_balance=$user_detail->ecommerce_balance+$request->amount;
                                $user_detail->save();

                                $data->balance=$data->balance-$request->amount;
                                $data->save();
                            }else{
                                return response()->json([
                                    'message'=>"Insufficient balance",
                                    'status'=>Response::HTTP_BAD_REQUEST,
                                    'type'=>'warning'
                                ],Response::HTTP_OK);
                            }
                        }else{
                            return response()->json([
                                'message'=>"No connection with account",
                                'status'=>Response::HTTP_BAD_REQUEST,
                                'type'=>'warning'
                            ],Response::HTTP_OK);
                        }

                    }elseif ($request->destination==ECOMMERCE_BALANCE_DESTINATION['seller_to_user']){
                        $data=Seller::where('user_id',$user->is)->first();
                        if (!is_null($data)){
                            if ($data->balance>=$request->amount){

                                $user_detail->ecommerce_balance=$user_detail->ecommerce_balance+$request->amount;
                                $user_detail->save();

                                $data->balance=$data->balance-$request->amount;
                                $data->save();
                            }else{
                                return response()->json([
                                    'message'=>"Insufficient balance",
                                    'status'=>Response::HTTP_BAD_REQUEST,
                                    'type'=>'warning'
                                ],Response::HTTP_OK);
                            }
                        }else{
                            return response()->json([
                                'message'=>"No connection with account",
                                'status'=>Response::HTTP_BAD_REQUEST,
                                'type'=>'warning'
                            ],Response::HTTP_OK);
                        }
                    }elseif ($request->destination==ECOMMERCE_BALANCE_DESTINATION['affiliate_to_user']){
                        $data=Affiliator::where('user_id',$user->is)->first();
                        if (!is_null($data)){
                            if ($data->balance>=$request->amount)
                            {

                                $user_detail->ecommerce_balance=$user_detail->ecommerce_balance+$request->amount;
                                $user_detail->save();

                                $data->balance=$data->balance-$request->amount;
                                $data->save();
                            }else{
                                return response()->json([
                                    'message'=>"Insufficient balance",
                                    'status'=>Response::HTTP_BAD_REQUEST,
                                    'type'=>'warning'
                                ],Response::HTTP_OK);
                            }
                        }else{
                            return response()->json([
                                'message'=>"No connection with account",
                                'status'=>Response::HTTP_BAD_REQUEST,
                                'type'=>'warning'
                            ],Response::HTTP_OK);
                        }
                    }


                }
            }else{
                if ($request->destination==ECOMMERCE_BALANCE_DESTINATION['user_to_merchant']){
                    $data=Merchant::where('user_id',$user->id)->first();
                    $data->balance=$data->balance+$request->amount;
                    $data->save();

                }elseif ($request->destination==ECOMMERCE_BALANCE_DESTINATION['user_to_seller']){
                    $data=Seller::where('user_id',$user->id)->first();
                    $data->balance=$data->balance+$request->amount;
                    $data->save();

                }elseif ($request->destination==ECOMMERCE_BALANCE_DESTINATION['user_to_affiliate']){
                    $data=Affiliator::where('user_id',$user->id)->first();
                    $data->balance=$data->balance+$request->amount;
                    $data->save();
                }

            }

        }catch (\Exception $exception){


        }
    }
}
