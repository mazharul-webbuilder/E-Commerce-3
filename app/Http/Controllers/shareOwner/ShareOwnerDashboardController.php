<?php

namespace App\Http\Controllers\shareOwner;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\ShareHolder;
use App\Models\ShareOwner;
use App\Models\ShareTransferHistory;
use App\Models\User;
use App\Models\WithdrawHistory;
use App\Models\WithdrawPayment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ShareOwnerDashboardController extends Controller
{
    protected $usd_rate=0.01;
    public function __construct(){
        $this->middleware('share');
    }
    public function index(){

        return view('webend.share_owner.index');
    }

    public function profile(){
        $data=Auth::guard('share')->user();
        return view('webend.share_owner.profile',compact('data'));
    }

    public function update_profile(Request $request){

            //dd($request->all());
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $data=Auth::guard('share')->user();
                $data->name=$request->name;
                $data->phone=$request->phone;

                if (!empty($request->password)){
                    $data->password=bcrypt($request->password);
                }

                if($request->hasFile('avatar')){

                    if (File::exists(public_path('/uploads/share_owner/'.$data->avatar)))
                    {
                        File::delete(public_path('/uploads/share_owner/'.$data->avatar));
                    }
                    $image=$request->avatar;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();

                    $image_path = public_path().'/uploads/share_owner/'.$image_name;

                    Image::make($image)->save($image_path);

                    $data->avatar=$image_name;

                }

                $data->save();


                DB::commit();
                return response()->json([
                    'data'=>"Successfully Deposit",
                    'type'=>'success',
                    'status'=>200
                ]);
            }catch (QueryException $exception){
                return response()->json([
                    'data'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>500
                ]);
            }
        }
    }

    public function my_share(){

        $user= Auth::guard('share')->user();
        $datas=ShareHolder::where("share_owner_id",$user->id)->orderBy('id','DESC')->get();

        return view('webend.share_owner.my_share',compact('datas'));
    }

    public function add_destination(Request $request){
       $auth_user=Auth::guard('share')->user();
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $to_share_owner=ShareOwner::where('share_owner_number',$request->share_owner_number)->first();

                if (!is_null($to_share_owner)){
                    if ($auth_user->share_owner_number!=$to_share_owner->share_owner_number){
                        return response()->json([
                            'message'=>"The share owner is available",
                            'type'=>"success",
                            'status'=>200
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"you can't transfer your share to yourself",
                            'type'=>"error",
                            'status'=>403
                        ]);
                    }

                }else{
                    return response()->json([
                        'message'=>"The share owner is unavailable",
                        'type'=>"error",
                        'status'=>403
                    ]);
                }

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception,
                    'type'=>"error",
                    'status'=>500
                ],500);
            }
        }
    }

    public function share_transfer_history(){
        $user= Auth::guard('share')->user();
        $datas=ShareTransferHistory::where('share_from',$user->id)->get();

        return view('webend.share_owner.share_transfer_history',compact('datas'));
    }

    public function transfer_share(Request $request){

         $auth_user=Auth::guard('share')->user();

        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $to_share_owner = ShareOwner::where('share_owner_number', $request->share_owner_number)->first();

                $share = ShareHolder::find($request->share_id);
                if ($auth_user->share_owner_number !=$to_share_owner->share_owner_number) {


                    if ($auth_user->balance >= share_holder_setting()->share_transfer_charge) {

                        if (!is_null($to_share_owner)) {
                            if (!is_null($share)) {
                                $share->share_owner_id = $to_share_owner->id;
                                $share->share_type = "transfer";
                                $share->save();

                                ShareTransferHistory::create([
                                    'share_from' => $auth_user->id,
                                    'share_to' => $to_share_owner->id,
                                    'share_holder_id' => $share->id
                                ]);
                                $auth_user->balance=$auth_user->balance-share_holder_setting()->share_transfer_charge;
                                $auth_user->save();

                                DB::commit();;
                                return response()->json([
                                    'message' => "Successfully transfer",
                                    'type' => "success",
                                    'status' => 200
                                ]);
                            } else {
                                return response()->json([
                                    'message' => "Some thing  went wrong",
                                    'type' => "error",
                                    'status' => 403
                                ]);
                            }
                        } else {
                            return response()->json([
                                'message' => "The The share owner is unavailable",
                                'type' => "error",
                                'status' => 403
                            ]);
                        }
                    } else {
                        return response()->json([
                            'message' => "You have enough money to transfer this share",
                            'type' => "error",
                            'status' => 403
                        ]);
                    }
                }else{
                    return response()->json([
                        'message' => "You can't transfer your share yourself ",
                        'type' => "error",
                        'status' => 403
                    ]);
                }

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception,
                    'type'=>"error",
                    'status'=>500
                ],500);
            }
        }
    }

    public function share_balance_withdraw(){
        $payments=WithdrawPayment::query()->get();
        return view('webend.share_owner.withdraw',compact('payments'));
    }

    public function share_charge_convert(Request $request){
      //  dd($request->all());
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $total_charge=($request->withdraw_balance*share_holder_setting()->withdraw_charge)/100;
                $coin_set = setting()->coin_convert_to_bdt;

                $remain_coin = $request->withdraw_balance - $total_charge;
                      //return $remain_coin;
                $total_usd = $remain_coin *$this->usd_rate/$coin_set;


                $total_bdt= currency_code('BDT')->currency_code." ".number_format(currency_convertor($total_usd,'convert_to_bdt'),2);
                $total_inr=currency_code('INR')->currency_code." ".number_format(currency_convertor($total_usd,'convert_to_inr'),2);
                $plain_bdt=number_format(currency_convertor($total_usd,'convert_to_bdt'),2);
                return \response()->json([
                    'total_USD'=>currency_code('USD')->currency_code." ".number_format($total_usd,2),
                    'total_BDT' => $total_bdt,
                    'total_INR'=>$total_inr,
                    'plain_bdt'=>$plain_bdt,
                    'charge_coin'=>$total_charge,
                    'remain'=>$remain_coin,
                    'status' => 'success',
                    'type' => Response::HTTP_OK
                ], Response::HTTP_OK);

            }catch (QueryException $exception){

            }
        }
    }

    public function share_withdraw_request(Request $request){
       // dd($request->all());
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $auth_user = Auth::guard('share')->user();


                if ($request->withdraw_balance <= share_holder_setting()->max_withdraw_amount && $request->withdraw_balance >= share_holder_setting()->min_withdraw_amount) {
                    if ($auth_user->balance >= $request->withdraw_balance) {
                        $total_charge=($request->withdraw_balance*share_holder_setting()->withdraw_charge)/100;
                        $withdraw = new WithdrawHistory();

                        $withdraw->withdraw_balance = $request->withdraw_balance;
                        $withdraw->user_received_balance = $request->withdraw_balance - $total_charge;

                        $withdraw->bdt_amount = $request->bdt_amount;
                        $withdraw->charge = $total_charge;
                        $withdraw->balance_send_type = $request->balance_send_type;
                        $withdraw->status = 1;
                        $withdraw->share_owner_id = $auth_user->id;
                        $withdraw->withdraw_payment_id = $request->payment_id ;

                        $withdraw->bank_detail=$request->account_number;

                        if ($request->balance_send_type == PAYMENT_TYPE[1]) {
                            $mobile_account_detail = [
                                'mobile_account_number' => $request->account_number,
                                'ref_number' => $request->ref_number,
                            ];
                            $withdraw->bank_detail = json_encode($mobile_account_detail);
                        }

                        if ($request->balance_send_type == PAYMENT_TYPE[2]) {
                            $bank_detail = [
                                'bank_holder_name' =>$request->bank_holder_name,
                                'bank_account_number' => $request->bank_account_number,
                                'bank_name' => $request->bank_name,
                                'bank_branch_name' => $request->bank_branch_name,
                                'bank_route_number' => $request->bank_route_number,
                                'bank_swift_code'=>$request->bank_swift_code
                            ];
                            $withdraw->bank_detail = json_encode($bank_detail);
                        }

                        if ($request->balance_send_type == PAYMENT_TYPE[3]) {
                            $paytm_detail = [
                                'code_or_number' =>$request->code_or_number,
                            ];
                            $withdraw->bank_detail = json_encode($paytm_detail);
                        }

                        if ($request->balance_send_type == PAYMENT_TYPE[4]) {
                            $gateway_detail = [
                                'online_gateway_email' =>$request->online_email,
                            ];
                            $withdraw->bank_detail = json_encode($gateway_detail);
                        }

                        if (!empty($request->user_note)) {
                            $withdraw->user_note = $request->user_note;
                        }
                        $withdraw->save();


                        $current_share_balance = $auth_user->balance;
                        $remain_share_balance = $current_share_balance - $request->withdraw_balance;
                        $auth_user->balance = $remain_share_balance;
                        $auth_user->save();
                        DB::commit();
                        return response()->json([
                            'message' => "Your withdraw has been successfully completed",
                            'type' => "success",
                            'status' => Response::HTTP_OK
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'message' => "You have insufficient win balance",
                            'type' => "error",
                            'status' => Response::HTTP_BAD_REQUEST
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'message' => "Your withdraw balance should be between " . share_holder_setting()->min_withdraw_amount . " to " . share_holder_setting()->max_withdraw_amount,
                        'type' => "error",
                        'status' => Response::HTTP_BAD_REQUEST
                    ], Response::HTTP_BAD_REQUEST);
                }

            }catch (QueryException $exception){

            }
        }
    }

    public function share_withdraw_history(){
        $user=Auth::guard('share')->user();
        $withdraws=WithdrawHistory::where('share_owner_id',$user->id)->get();
        return view('webend.share_owner.withdraw_histories',compact('withdraws'));
    }

    public function purchase_share(Request $request){
       if ($request->isMethod('post')){
           try {
               DB::beginTransaction();
               $auth_user=Auth::guard('share')->user();
               if($auth_user->balance>=share_holder_setting()->share_price){
                   ShareHolder::create([
                       'share_owner_id'=>$auth_user->id,
                       'share_purchase_price'=>share_holder_setting()->share_price,
                       'share_number'=>'SH'.rand(100000,999900),
                       'share_type'=>'purchase',
                   ]);
                   $auth_user->balance=$auth_user->balance - share_holder_setting()->share_price;
                   $auth_user->save();
                   DB::commit();
                   return response()->json([
                       'message' => "Your share has successfully purchased",
                       'type' => "success",
                       'status' => Response::HTTP_OK
                   ], Response::HTTP_OK);

               }else{
                   return response()->json([
                       'message' => "You have no enough money to purchase this share",
                       'type' => "error",
                       'status' => Response::HTTP_BAD_REQUEST
                   ], Response::HTTP_OK);
               }

           }catch (QueryException $exception){
                DB::rollBack();
               return response()->json([
                   'message' => "You have insufficient win balance",
                   'type' => "error",
                   'status' => Response::HTTP_INTERNAL_SERVER_ERROR
               ], Response::HTTP_INTERNAL_SERVER_ERROR);
           }
       }

    }
}
