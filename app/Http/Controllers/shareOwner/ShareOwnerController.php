<?php

namespace App\Http\Controllers\shareOwner;

use App\Http\Controllers\Controller;
use App\Models\CoinEarningHistory;
use App\Models\Deposit;
use App\Models\Ecommerce\Payment;
use App\Models\ShareHolder;
use App\Models\ShareOwner;
use App\Models\ShareTransferHistory;
use App\Models\Voucher;
use App\Models\VoucherRequest;
use App\Models\VoucherTransferHistory;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ShareOwnerController extends Controller
{


    public function deposit(){

        $datas=Deposit::query()->where('share_owner_id',Auth::guard('share')->user()->id)
            ->orderBy('id','DESC')->get();
        return view('webend.share_owner.deposit',compact('datas'));
    }

    public function get_payment_detail(Request $request){
        if ($request->isMethod("post")){
            try {
                $data=Payment::find($request->payment_id);
                return response()->json([
                    'data'=>$data,
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

    public function deposit_request(){
        $payments=Payment::where('status',1)->orderBy('id','desc')->get();
        return view('webend.share_owner.deposit_request',compact('payments'));
    }
    public function send_deposit_request(Request $request){

        //dd($request->all());
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $image_name=null;
                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();

                    $image_path = public_path().'/uploads/deposit/'.$image_name;

                    Image::make($image)->save($image_path);

                }
                Deposit::create([
                    'share_owner_id'=>Auth::guard('share')->user()->id,
                    'payment_id'=>$request->payment_id,
                    'deposit_amount'=>$request->deposit_amount,
                    'transaction_number'=>$request->transaction_number,
                    'image'=>$image_name,
                    'status'=>1
                ]);
                DB::commit();
                return response()->json([
                    'data'=>"Deposit successfully",
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



    public function voucher(){

        $datas=VoucherRequest::where('share_owner_id',Auth::guard('share')->user()->id)
            ->orderBy('id','DESC')->get();
        return view('webend.share_owner.voucher_request',compact('datas'));
    }


    public function voucher_request(Request $request){

        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                VoucherRequest::create([
                    'share_owner_id'=>Auth::guard('share')->user()->id,
                    'voucher_price'=>$request->voucher_price,
                ]);
                DB::commit();
                return response()->json([
                    'message'=>"Successfully created",
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


public function voucher_collect(Request $request){
    if ($request->isMethod("post")){
        try {
            DB::beginTransaction();
            $data=VoucherRequest::find($request->request_id);
            $share_owner=ShareOwner::find($data->share_owner_id);
            $share_owner->balance=$share_owner->balance+$data->voucher_price;
            $share_owner->save();
            $data->status=1;
            $data->save();
            DB::commit();
            return response()->json([
                'message'=>$data->voucher_price." has been added in your balance.",
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

public function transfer_voucher(Request $request){
    $auth_user=Auth::guard('share')->user();
    if ($request->isMethod("post")){
        try {
            DB::beginTransaction();
            $to_share_owner = ShareOwner::where('share_owner_number', $request->share_owner_number)->first();

            if ($auth_user->share_owner_number !=$to_share_owner->share_owner_number) {

                $voucher_request=VoucherRequest::find($request->request_id);

                    if (!is_null($to_share_owner)) {

                        if (!is_null($voucher_request)){

                            VoucherTransferHistory::create([
                                'transfer_from_id' => $auth_user->id,
                                'transfer_to_id' => $to_share_owner->id,
                                'voucher_request_id' => $request->request_id
                            ]);

                            $voucher_request->share_owner_id=$to_share_owner->id;
                            $voucher_request->getting_source="transfer";
                            $voucher_request->save();


                            DB::commit();
                            return response()->json([
                                'message' => "Successfully transfer",
                                'type' => "success",
                                'status' => 200
                            ]);
                        }else{
                            return response()->json([
                                'message' => "Something went wrong",
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

            }else{
                return response()->json([
                    'message' => "You can't transfer your voucher to yourself ",
                    'type' => "error",
                    'status' => 403
                ]);
            }

        }catch (\Illuminate\Database\QueryException $exception){
            DB::rollBack();
            return response()->json([
                'message'=>$exception,
                'type'=>"error",
                'status'=>500
            ],500);
        }
    }
}


public function transfer_voucher_history(){
        $datas=VoucherTransferHistory::where('transfer_from_id',Auth::guard('share')->user()->id)->orderBy('id','desc')->get();
        return view('webend.share_owner.transfer_voucher_history',compact('datas'));
}

public function coin_earning_history(){
    $datas = CoinEarningHistory::where('share_owner_id',Auth::guard('share')->user()->id)
        ->where('type','share')->orderBy('id', 'DESC')->get();
    return view('webend.share_owner.coin_earning_history', compact('datas'));
}


}
