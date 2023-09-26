<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToken;
use App\Models\WithdrawHistory;
use App\Models\WithdrawSaving;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use League\Uri\Http;
use PHPUnit\Exception;


class WithdrawHistoryController extends Controller
{

    public $checker=1;
    public $coin=0;
    public $withdrawal_auth_user=null;
    public $child_parent=null;

    public function  index($type=null){

        $withdraws=WithdrawHistory::latest()->get();
        if ($type!==null){
            if ($type==='all'){
                $withdraws=WithdrawHistory::orderBy('id','desc')->get();
            }else{
                $withdraws=WithdrawHistory::where('withdraw_payment_id',$type)->where('status',2)->orderBy('id','desc')->get();
            }
        }else{
            $withdraws=WithdrawHistory::orderBy('id','desc')->get();
        }
        return view("webend.withdraw.index",compact('withdraws'));
    }

    public function manage_withdraw(Request $request){


        $withdraw=WithdrawHistory::with('user')->find($request->withdraw_id);


        if ($request->isMethod("POST")){
            try {
              //  DB::beginTransaction();
                if ($withdraw->status==1 || $withdraw->status==2){

                    if ($request->status==3){

                        if ($withdraw->user_id!=null) {

                            $parant = User::where('id', $withdraw->user->parent_id)->first();


                            WithdrawSaving::create([
                                'withdraw_history_id' => $withdraw->id,
                                'saving_amount' => setting()->withdraw_saving,
                                'status' => 0
                            ]);

                            $type = RANK_COMMISSION_COLUMN[3];
                            $user = User::find($withdraw->user_id);
                            $this->withdrawal_auth_user = $user;
                            $this->coin = $withdraw->withdraw_balance;
                            $this->rank_commission_distribution($withdraw->id,$user,$type);
                        }

                    }elseif ($request->status==4){
                        $user=User::find($withdraw->user_id);
                        $user->win_balance +=$withdraw->withdraw_balance;
                        $user->save();
                    }

                    $withdraw->status=$request->status;
                    $withdraw->save();
                   // DB::commit();
                    return response()->json([
                        'message'=>"Successfully updated!",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);
                }elseif ($withdraw->status==2){
                    return response()->json([
                        'message'=>"You can't change this status anymore!",
                        'type'=>'warning',
                        'status'=>400
                    ],Response::HTTP_OK);
                }elseif($withdraw->status==3){
                    return response()->json([
                        'message'=>"You can't change this status anymore!",
                        'type'=>'warning',
                        'status'=>400
                    ],Response::HTTP_OK);
                }
            }catch (Exception $e){
                $error=$e->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'warning',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function rank_commission_distribution($withdraw_id,$user,$type){

        //$auth_user=$this->auth_user;
        if ($user->rank->priority !==5) {
            if ($this->checker==1){
                $parent=User::where('id',$user->parent_id)->first();
                if (!empty($parent)) {

                    if ($parent->rank->priority>=$this->withdrawal_auth_user->rank->priority){
                        if ($parent->rank->priority !==1 || $parent->rank->priority !==0){

                               UserToken::create([
                                   'user_id'=>$parent->id,
                                   'withdrawal_id'=>$withdraw_id,
                                   'token_number'=>strtoupper(uniqid("GT")),
                                   'getting_source'=>UserToken::getting_source[1],
                                   'type'=>UserToken::token_type[0]
                               ]);

                        }
                    }
                    $this->child_parent=$parent;
                    $this->checker=2;
                    $this->rank_commission_distribution($withdraw_id,$parent,$type);

                }else{
                    //echo "no parent 1";
                }
            }else{

                $parent_one=User::where('id',$this->child_parent->parent_id)->first();
                if (!empty($parent_one)){

                    if ($parent_one->rank->priority > $this->child_parent->rank->priority){
                        if ($parent_one->rank->priority !==1 || $parent_one->rank->priority !==0){

                            UserToken::create([
                                'user_id'=>$parent_one->id,
                                'withdrawal_id'=>$withdraw_id,
                                'token_number'=>strtoupper(uniqid("GT")),
                                'getting_source'=>UserToken::getting_source[1],
                                'type'=>UserToken::token_type[0]
                            ]);
                        }
                    }
                    $this->child_parent=$parent_one;
                    $this->rank_commission_distribution($withdraw_id,$parent_one,$type);
                }else{
                    //echo "no parent 2";
                }
            }
        }
    }


    public function processing_time(Request $request){
       // dd($request->all());
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $data=WithdrawHistory::find($request->withdraw_id);
                $data->processing_time=$request->processing_time;
                $data->save();
                DB::commit();

                return response()->json([
                    'message'=>"Successfully update",
                    'type'=>'success',
                    'status'=>Response::HTTP_OK
                ],Response::HTTP_OK);

            }catch (QueryException $exception){
                DB::rollBack();
                $error=$exception->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'warning',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }


    public function withdraw_saving(){

        $datas=WithdrawSaving::whereMonth('created_at', Carbon::now())
            ->whereStatus(0)->get();
        return view("webend.withdraw.withdraw_saving",compact('datas'));

    }
}
