<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToken;
use App\Models\WithdrawHistory;
use App\Models\WithdrawSaving;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use League\Uri\Http;
use PHPUnit\Exception;
use Yajra\DataTables\Facades\DataTables;


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

    /**
     * All type of User Withdraw
    */
    public function allWithdraw(): View
    {
        $date_range = null;

        return \view('webend.ecommerce.withdraw.all-user.index', compact('date_range'));
    }

    /**
     * Load Datatable of all type of User
    */
    public function allWithdrawDatatable(Request $request): JsonResponse
    {
        $withdraw_lists = null;

        switch($request->filter){
            case 'all':
                $withdraw_lists = WithdrawHistory::all();
                break;
            case 'merchant':
                $withdraw_lists = WithdrawHistory::where('merchant_id', '!=', null)->get();
                break;
            case 'seller':
                $withdraw_lists = WithdrawHistory::where('seller_id', '!=', null)->get();
                break;
            case 'affiliator':
                $withdraw_lists = WithdrawHistory::where('affiliator_id', '!=', null)->get();
                break;
            case 'shareOwner':
                $withdraw_lists = WithdrawHistory::where('share_owner_id', '!=', null)->get();
                break;
            case 'normalUser':
                $withdraw_lists = WithdrawHistory::where('user_id', '!=', null)->get();
                break;
        }

        $userType = null;

        if (isset($request->startDate) & isset($request->endDate)) {
            $withdraw_lists = WithdrawHistory::whereDate('created_at', '>=', $request->startDate)
                ->whereDate('created_at', '<=', $request->endDate)->get();
        }

        return DataTables::of($withdraw_lists)
            ->addIndexColumn()
            ->addColumn('user_name', function ($withdraw) use (&$userType){
                if (isset($withdraw->user_id)) {
                    $userType = 'Normal User';
                    return $withdraw->user->name;
                } elseif (isset($withdraw->share_owner_id)) {
                    $userType = 'Share Owner';
                    return $withdraw?->share_owner->name;
                } elseif (isset($withdraw->seller_id)) {
                    $userType = 'Seller';
                    return $withdraw?->seller->name;
                } elseif (isset($withdraw->merchant_id)) {
                    $userType = 'Merchant';
                    return $withdraw->merchant->name;
                } elseif (isset($withdraw->affiliator_id)) {
                    $userType = 'Affiliator';
                    return $withdraw->affiliator->name;
                }
                return null;
            })
            ->addColumn('user_type', function () use (&$userType){
                return $userType;
            })
            ->addColumn('status', function ($withdraw) {
                $statusOptions = [
                    1 => 'Pending',
                    2 => 'Processing',
                    3 => 'Accept',
                    4 => 'Reject',
                ];
                $statusSelect = '<select class="status-select form-control" data-id="'.$withdraw->id.'" style="background: #FFE5E5;
                                    padding: 7px;
                                    border: 1px solid transparent;
                                    border-radius: 10px;
                                    color: black;" data-id="' . $withdraw->id . '">';

                foreach ($statusOptions as $value => $label) { // $value = array_key && $label = published or unpublished
                    $selected = $withdraw->status == $value ? 'selected' : '';
                    $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                }
                $statusSelect .= '</select>';
                return $statusSelect;
            })
            ->addColumn('bank_detail', function ($withdraw){
                /*Get Bank Details Array Banking or Mobile Banking*/
                $banking_details = (array) json_decode($withdraw->bank_detail, true);

                switch ($withdraw->balance_send_type){
                    case "Banking":
                        return '
                            <p class="py-1">Bank Name: '.(array_key_exists('bank_name', $banking_details) ? $banking_details['bank_name'] : null).'</p>
                            <p class="py-1">Account Holder Name: '.(array_key_exists('bank_holder_name', $banking_details) ? $banking_details['bank_holder_name'] : null).'</p>
                            <p class="py-1">Account Number: '.(array_key_exists('bank_account_number', $banking_details) ? $banking_details['bank_account_number'] : null).'</p>
                            <p class="py-1">Branch Name: '.(array_key_exists('bank_branch_name', $banking_details) ? $banking_details['bank_branch_name'] : null).'</p>
                            <p class="py-1">Routing Number: '.(array_key_exists('bank_route_number', $banking_details) ? $banking_details['bank_route_number'] : null).'</p>
                            <p class="py-1">Swift Code: '.(array_key_exists('bank_swift_code', $banking_details) ? $banking_details['bank_swift_code'] : null).'</p>
                        ';
                    case "Mobile Banking":
                        return '
                            <p class="py-1">Account Number: '.(array_key_exists('mobile_account_number', $banking_details) ? $banking_details['mobile_account_number'] : null).'</p>
                            <p class="py-1">Reference: '.(array_key_exists('ref_number', $banking_details) ? $banking_details['ref_number']: null).'</p>
                        ';
                }
            })
            ->rawColumns(['status', 'bank_detail', 'user_type'])->make(true);

    }
}
