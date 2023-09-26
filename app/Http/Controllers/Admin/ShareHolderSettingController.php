<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\CoinEarningHistory;
use App\Models\Deposit;
use App\Models\Owner;
use App\Models\RankUpdateAdminStore;
use App\Models\ShareHolder;
use App\Models\ShareHolderFundHistory;
use App\Models\ShareHolderIncomeSource;
use App\Models\ShareHolderSetting;
use App\Models\ShareOwner;
use App\Models\ShareTransferHistory;
use App\Models\User;
use App\Models\UserToken;
use App\Models\WithdrawHistory;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use phpseclib3\File\ASN1\Maps\RSAPrivateKey;
use PHPUnit\Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Str;

class ShareHolderSettingController extends Controller
{
    public function setting()
    {
        $setting = ShareHolderSetting::first();
        return view('webend.shareholder.setting', compact('setting'));
    }

    public function update_setting(Request $request)
    {

        $this->validate($request, [
            'share_price' => 'required',
            'share_commission' => 'required',
            'min_withdraw_amount' => 'required',
            'withdraw_charge' => 'required',
            'share_transfer_charge' => 'required',
            'max_withdraw_amount' => 'required',
            'referral_commission' => 'required',
            'live_share_commission' => 'required',
        ]);
        if ($request->isMethod('POST')) {
            try {
                DB::beginTransaction();
                $setting = ShareHolderSetting::find($request->id);
                $setting->share_price = $request->share_price;
                $setting->share_commission = $request->share_commission;
                $setting->min_withdraw_amount = $request->min_withdraw_amount;
                $setting->withdraw_charge = $request->withdraw_charge;
                $setting->share_transfer_charge = $request->share_transfer_charge;
                $setting->max_withdraw_amount = $request->max_withdraw_amount;
                $setting->referral_commission = $request->referral_commission;
                $setting->live_share_commission = $request->live_share_commission;
                $setting->save();
                DB::commit();
                return response()->json([
                    'message' => 'Successfully Updated',
                    'type' => 'success',
                    'status' => Response::HTTP_OK,
                ], Response::HTTP_OK);
            } catch (QueryException $exception) {
                DB::rollBack();
                $e = $exception->getMessage();
                return response()->json([
                    'message' => $e,
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function income_source()
    {
        $income_sources = ShareHolderIncomeSource::latest()->get();
        return view('webend.shareholder.income_source', compact('income_sources'));
    }

    public function update_income_source(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                DB::beginTransaction();
                $income_source = ShareHolderIncomeSource::find($request->id);
                $income_source->commission = $request->commission;
                $income_source->commission_type = $request->commission_type;
                $income_source->save();
                DB::commit();
                return response()->json([
                    'message' => "Successfully Updated",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
            } catch (QueryException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function share_holder()
    {
        $share_holders = ShareHolder::latest()
            ->select('user_id', DB::raw('count(id) as total_share'), DB::raw('sum(share_purchase_price) as total_purchase_cost'))
            ->groupBy('user_id')
            ->get();

        return view('webend.shareholder.share_holder', compact('share_holders'));
    }



    public function share_holder_by_date(Request $request)
    {

        if ($request->isMethod("POST")) {
            $share_holders = ShareHolder::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $share_holders = ShareHolder::query()->orderBy('id', 'DESC')->get();
        }

        return view('webend.shareholder.share_holder', compact('share_holders'));
    }






    public function share_purchased_detail($user_id)
    {

        $datas = ShareHolder::where('user_id', $user_id)->get();
       // return $datas;
        $setItem = '';
        foreach ($datas as $data) {
            $setItem .= '<tr class="text-xs text-black uppercase">
                    <td class="px-6 py-3 whitespace-nowrap">' . date('d-m-Y', strtotime($data->created_at)) . '</td>
                    <td class="px-6 py-3 whitespace-nowrap">' . price_format($data->share_purchase_price) . '</td>
              </tr>';
        }
        return response()->json([
            'data' => $setItem,
            'type' => 'success',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function share_holder_fund_history()
    {
        // old query
      //  $datas = ShareHolderFundHistory::whereMonth('created_at', Carbon::now())
          //  ->whereStatus(1)
           // ->latest()->get();

        $datas = ShareHolderFundHistory::query()
            ->whereStatus(1)
            ->latest()->get();

        return view('webend.shareholder.share_holder_fund_history', compact('datas'));
    }

    public function distribute_share_holder_fund(Request $request)
    {

        $datas = ShareHolderFundHistory::query()
            ->whereStatus(1)
            ->latest()->get();

        $total_amount =$datas->sum('commission_amount')+$request->additional_coin;

        $share_holder_commission =(share_holder_setting()->share_commission*$total_amount)/100;
        $referral_commission =(share_holder_setting()->referral_commission*$total_amount)/100;

        $share_holders = ShareHolder::orderBy('id', 'DESC')->get();

        $total_share=count($share_holders);

        $individual_share_commission=$share_holder_commission/$total_share;
        $individual_referral_commission=$referral_commission/$total_share;

      //  echo $total_amount."=".$share_holder_commission."=".$referral_commission."=".$individual_share_commission."=".$individual_referral_commission;

        if (count($share_holders) > 0) {
            foreach ($share_holders as $share_holder){
                // share owner commission distribution
                $share_owner=ShareOwner::find($share_holder->share_owner_id);
                if (!is_null($share_owner)){
                    $share_owner->balance=$share_owner->balance+$individual_share_commission;
                    $share_owner->save();
                    // coin earn history
                    CoinEarningHistory::create([
                        'share_owner_id'=>$share_owner->id,
                        'earning_coin'=>$individual_share_commission,
                        'balance_type'=>BALANCE_TYPE['share_balance'],
                        'earning_source'=>COIN_EARNING_SOURCE['share_fund_history'],
                        'type'=>'share'
                     ]);
                }

                // share referral commission distribution00
                if ($share_holder->parent_id !=null){
                    $user=User::find($share_holder->parent_id);
                    $user->marketing_balance=$user->marketing_balance+$individual_referral_commission;
                    $user->save();
                    coin_earning_history($user->id,$individual_referral_commission,COIN_EARNING_SOURCE['share_fund_history'],BALANCE_TYPE['marketing']);
                }
            }
        }

         foreach ($datas as $data){
          // $data->update(['status'=>2]);
        }

        return response()->json([
            'message' =>"Successfully distributed",
            'type' => 'success',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);


    }

    public function share_transfer_history()
    {

        $share_transfer_histories =  ShareTransferHistory::latest()->get();
        return view('webend.shareholder.share_transfer_history', compact('share_transfer_histories'));
    }

    public function create_share_owner()
    {

        return view('webend.shareholder.create_share_owner');
    }

    public function store_share_owner(Request  $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'balance' => 'nullable',
            'email' => 'required|unique:share_owners',
            'password' => 'required',
        ]);

        if ($request->isMethod("POST")) {
            try {
                DB::beginTransaction();
                $user = User::find($request->user_id);

                $share_owner = new ShareOwner();
                $share_owner->name = $request->name;
                $share_owner->email = $request->email;
                $share_owner->password = bcrypt($request->password);
                $share_owner->balance = $request->balance;
                $share_owner->voucher_eligible = $request->voucher_eligible;
                $share_owner->share_owner_number = 'SO'.rand(10000,99999);
                $share_owner->save();

                DB::commit();
                return response()->json([
                    'message' => "Successfully added",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
            } catch (QueryException $exception) {
                DB::rollBack();
                return response()->json([
                    'message' => $exception->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function user_all_share($user_id){
        $datas=ShareHolder::where('share_owner_id',$user_id)->get();
        return view('webend.shareholder.all_share', compact('datas'));
    }

    public function add_parent(Request $request){
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $user=User::where('playerid',$request->parent_number)->first();
                if (!is_null($user)){
                    $share_holder=ShareHolder::find($request->share_holder_id);
                    $share_holder->parent_id=$user->id;
                    $share_holder->save();
                    DB::commit();
                    return response()->json([
                        'message' =>"Successfully added",
                        'type' => 'success',
                        'status' => Response::HTTP_OK
                    ], Response::HTTP_OK);
                }else{
                    return response()->json([
                        'message' =>"Parent user not found",
                        'type' => 'error',
                        'status' => Response::HTTP_BAD_REQUEST
                    ], Response::HTTP_OK);
                }
            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message' => $exception->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function share_owner(){
        $datas=ShareOwner::orderBy('id','DESC')->get();
        $shares=ShareHolder::query()->get();
        return view('webend.shareholder.all_owner', compact('datas','shares'));
    }

    public function provide_share(Request $request){
            if ($request->isMethod("POST")){
                try {
                    DB::beginTransaction();
                    $share_owner=ShareOwner::find($request->share_owner_id);

                    ShareHolder::create([
                        'share_owner_id'=>$request->share_owner_id,
                        'share_purchase_price'=>$request->share_price,
                        'share_number'=>'SH'.rand(100000,999999),
                        'share_type'=>'purchase',
                    ]);

                    DB::commit();
                    return response()->json([
                        'message'=>'Share purchased successfully',
                        'type'=>'success',
                        'status'=>Response::HTTP_OK,
                    ],Response::HTTP_OK);
                }catch (QueryException $exception){
                    DB::rollBack();
                    return response()->json([
                        'message'=>'Share purchased successfully',
                        'type'=>'error',
                        'status'=>Response::HTTP_OK,
                    ],Response::HTTP_OK);
                }
            }
    }

    public function deposit_history(){
        $datas=Deposit::query()->orderBy('id','DESC')->get();
        return view('webend.shareholder.deposit_history',compact('datas'));
    }

    public function manage_deposit(Request $request){

        $data=Deposit::find($request->deposit_id);

        if ($request->isMethod("POST")){
            try {
                  DB::beginTransaction();
                if ($data->status==1 || $data->status==2){

                    if ($request->status==3){
                        $share_owner=ShareOwner::find($data->share_owner_id);
                        $share_owner->balance=$share_owner->balance+$data->deposit_amount;
                        $share_owner->save();
                    }
                    $data->status=$request->status;
                    $data->save();
                    DB::commit();
                    return response()->json([
                        'message'=>"Successfully updated!",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);
                }
            }catch (Exception $e){
                DB::rollBack();
                $error=$e->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'warning',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit_share_owner($id){
        $data=ShareOwner::find($id);
        return view('webend.shareholder.edit_share_owner',compact('data'));
    }

    public function  update_share_owner(Request $request){

        $data=ShareOwner::find($request->id);

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();

                    $data->name=$request->name;
                    $data->balance=$request->balance;
                    $data->phone=$request->phone;
                    $data->email=$request->email;
                    $data->voucher_eligible=$request->voucher_eligible;

                    if (!empty($request->password)){
                        $data->password=bcrypt($request->password);
                    }
                    $data->save();


                    DB::commit();
                    return response()->json([
                        'message'=>"Successfully updated!",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);

            }catch (Exception $e){
                DB::rollBack();
                $error=$e->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'warning',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function coin_earning_history(){
        $datas=CoinEarningHistory::whereType('share')->latest()->get();
        return view('webend.shareholder.coin_earning_history',compact('datas'));
    }
}
