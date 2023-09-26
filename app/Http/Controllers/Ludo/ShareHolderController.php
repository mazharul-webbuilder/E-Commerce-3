<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mytransferlist;
use App\Models\ShareHolder;
use App\Models\ShareTransferHistory;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShareHolderController extends Controller
{
    public function purchase_share(Request $request){

       // return share_holder_setting()->share_price;

        if ($request->isMethod('post')){
            try {
                DB::beginTransaction();
                $user=auth()->user();

                $already_purchase=ShareHolder::where('user_id',$user->id)->count();
                if (share_holder_setting()->share_purchase_limit>$already_purchase)
                {
                    if ($user->paid_coin>=share_holder_setting()->share_price){
                        ShareHolder::create([
                            'user_id'=>$user->id,
                            'share_purchase_price'=>share_holder_setting()->share_price,
                            'share_number'=>'SH'.rand(1000,9999),
                            'share_type'=>'purchase',
                        ]);
                        $user->paid_coin=$user->paid_coin-share_holder_setting()->share_price;
                        $user->save();
                        DB::commit();
                        return response()->json([
                            'message'=>'Share purchased successfully',
                            'type'=>'success',
                            'status'=>Response::HTTP_OK,
                        ],Response::HTTP_OK);

                    }else{
                        return response()->json([
                            'message'=>'Insufficient balance to purchase share',
                            'type'=>'warning',
                            'status'=>Response::HTTP_BAD_REQUEST,
                        ],Response::HTTP_OK);
                    }

                }else{
                    return response()->json([
                        'message'=>'Your share purchase limited exceeded',
                        'type'=>'warning',
                        'status'=>Response::HTTP_ALREADY_REPORTED,
                    ],Response::HTTP_OK);
                }
            }catch (QueryException $e){
                DB::rollBack();
            }
        }
    }

    public function get_my_shareholder_list()
    {
        $shareholder = ShareHolder::where('user_id',Auth::user()->id)->get();

        return response()->json([
            'data'=>$shareholder,
            'type'=>'success',
            'status'=>Response::HTTP_OK,
            'share_purchase_cost'=>share_holder_setting()->share_price,
        ],Response::HTTP_OK);

    }

    public function get_my_transfer_list()
    {
        $shareholder = ShareTransferHistory::where('share_from',Auth::user()->id)->get();
        $shareholder = Mytransferlist::collection($shareholder);
        return api_response('success','My share transfer list.',$shareholder,200);
    }


    public function share_transfer(Request $request)
    {
      //  return auth()->user();
        $request->validate([
            'receiver_id' => 'required',
            'share_id' => 'required',
        ]);
        $exist =  ShareHolder::where('id',$request->share_id)->where('user_id',Auth::user()->id)->first();
        if($exist != null)
        {
            $already_purchase=ShareHolder::where('user_id',$request->receiver_id)->count();
            if($already_purchase < share_holder_setting()->share_purchase_limit)
            {
                Db::beginTransaction();

                $share_transfer = ShareTransferHistory::create([
                    'share_from' => Auth::user()->id,
                    'share_to' => $request->receiver_id,
                    'share_holder_id' => $request->share_id,
                ]);
                if($share_transfer){
                    $update = ShareHolder::find($request->share_id)->update([
                        'user_id'=> $request->receiver_id,
                        'share_type'=>'transfer',
                    ]);
                    DB::commit();
                    return api_response('success','Share transfer successfully done!.',null,200);
                }
                else{
                    DB::rollBack();
                    return api_response('warning','Share transfer failed!.',null,200);
                }
            }else{
                return api_response('warning','Receiver Share holder limit exceed.',null,200);
            }
        }else{
            return api_response('warning','You dont have this share.!',null,200);
        }

    }

    public function share_transfer_history()
    {

        $share_transfer_histories =  ShareTransferHistory::latest()->get();
        return view('webend.shareholder.share_transfer_history',compact('share_transfer_histories'));

    }


}
