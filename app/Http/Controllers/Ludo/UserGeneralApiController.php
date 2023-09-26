<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataApplyUserResource;
use App\Http\Resources\Ludo\PackageResource;
use App\Models\CoinUseHistory;
use App\Models\DiamondPackage;
use App\Models\DiamondSellHistory;
use App\Models\ShareHolder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Http\Resources\Notificationresource;

class UserGeneralApiController extends Controller
{

    private $data_apply_type=['data_apply','data_info'];
    public function purchase_diamond(Request $request){
        $user=auth()->user();

        $validator = Validator::make($request->all(), [
            'diamond_quantity' => 'required|numeric',
        ]);

        if ($request->isMethod('POST')){
            if (!$validator->fails()){
                if ($user->diamond_purchase==0){
                    if ($request->diamond_quantity>=setting()->min_purchase_diamond){
                            if ($user->diamond_partner==1){
                                $total_price=$request->diamond_quantity*diamond_setting()->partner_price;
                                $current_diamond=$user->paid_diamond;
                                $current_coin=$user->paid_coin;
                                if ($current_coin>=$total_price){
                                    $total_diamond=$current_diamond+$request->diamond_quantity;
                                    $remain_coin=$current_coin-$total_price;
                                    $user->paid_diamond=$total_diamond;
                                    $user->paid_coin=$remain_coin;
                                    $user->diamond_purchase=1;
                                    $user->save();
                                    DiamondSellHistory::create([
                                        'user_id'=>$user->id,
                                        'total_diamond'=>$request->diamond_quantity,
                                        'sub_total'=>$total_price,
                                        'type'=>1
                                    ]);
                                    coin_use_history();
                                    CoinUseHistory::create([
                                        'user_id'=>$user->id,
                                        'user_coin'=>$total_price,
                                        'type'=>'paid_coin',
                                        'purpose'=>'diamond_purchase'
                                    ]);
                                    $datas = [
                                        'user_id'=>$user->id,
                                        'title' => "You have purchased ".$request->diamond_quantity." diamonds successfully",
                                        'type'=>'diamond',
                                        'status'=>0
                                    ];
                                    notification($datas);

                                    return response()->json([
                                        'message' => "Diamond purchased successfully",
                                        'type' => "success",
                                        'status' => 200
                                    ], Response::HTTP_OK);
                                }else{
                                    return response()->json([
                                        'message' => "You have insufficient coin",
                                        'type' => "success",
                                        'status' => 401
                                    ], Response::HTTP_OK);
                                }

                            }else {
                                $total_price = $request->diamond_quantity * diamond_setting()->current_price;
                                $current_diamond = $user->paid_diamond;
                                $current_coin = $user->paid_coin;
                                if ($current_coin >= $total_price) {
                                    $total_diamond = $current_diamond + $request->diamond_quantity;
                                    $remain_coin = $current_coin - $total_price;
                                    $user->paid_diamond = $total_diamond;
                                    $user->paid_coin = $remain_coin;
                                    $user->diamond_purchase = 1;
                                    $user->save();
                                    DiamondSellHistory::create([
                                        'user_id' => $user->id,
                                        'total_diamond' => $request->diamond_quantity,
                                        'sub_total' => $total_price,
                                        'type' => 1
                                    ]);

                                    CoinUseHistory::create([
                                        'user_id'=>$user->id,
                                        'user_coin'=>$total_price,
                                        'type'=>'paid_coin',
                                        'purpose'=>'diamond_purchase'
                                    ]);
                                    $datas = [
                                        'user_id'=>$user->id,
                                        'title' => "You have purchased ".$request->diamond_quantity." diamonds successfully",
                                        'type'=>'diamond',
                                        'status'=>0
                                    ];
                                    notification($datas);
                                    return response()->json([
                                        'message' => "Diamond purchased successfully",
                                        'type' => "success",
                                        'status' => 200
                                    ], Response::HTTP_OK);
                                }else{
                                    return response()->json([
                                        'message' => "You have insufficient coin",
                                        'type' => "success",
                                        'status' => 401
                                    ], Response::HTTP_OK);
                            }

                        }
                    }else{
                        return response()->json([
                            'message' => "You have to purchase minimum ".setting()->min_purchase_diamond." diamond as you are purchasing first time",
                            'type' => "error",
                            'status' => 401
                        ], Response::HTTP_OK);
                    }
                }else{
                    if ($user->diamond_partner==1){
                        $total_price=$request->diamond_quantity*diamond_setting()->partner_price;
                        $current_diamond=$user->paid_diamond;
                        $current_coin=$user->paid_coin;
                        if ($current_coin>=$total_price){
                            $total_diamond=$current_diamond+$request->diamond_quantity;
                            $remain_coin=$current_coin-$total_price;
                            $user->paid_diamond=$total_diamond;
                            $user->paid_coin=$remain_coin;
                            $user->save();

                            DiamondSellHistory::create([
                                'user_id'=>$user->id,
                                'total_diamond'=>$request->diamond_quantity,
                                'sub_total'=>$total_price,
                                'type'=>1
                            ]);
                            CoinUseHistory::create([
                                'user_id'=>$user->id,
                                'user_coin'=>$total_price,
                                'type'=>'paid_coin',
                                'purpose'=>'diamond_purchase'
                            ]);
                            $datas = [
                                'user_id'=>$user->id,
                                'title' => "You have purchased ".$request->diamond_quantity." diamonds successfully",
                                'type'=>'diamond',
                                'status'=>0
                            ];
                            notification($datas);

                            return response()->json([
                                'message' => "Diamond purchased successfully",
                                'type' => "success",
                                'status' => 200
                            ], Response::HTTP_OK);
                        }else{
                            return response()->json([
                                'message' => "You have insufficient coin",
                                'type' => "success",
                                'status' => 401
                            ], Response::HTTP_OK);
                        }

                    }else{
                        $total_price=$request->diamond_quantity*diamond_setting()->current_price;
                        $current_diamond=$user->paid_diamond;
                        $current_coin=$user->paid_coin;
                        if ($current_coin>=$total_price){
                            $total_diamond=$current_diamond+$request->diamond_quantity;
                            $remain_coin=$current_coin-$total_price;
                            $user->paid_diamond=$total_diamond;
                            $user->paid_coin=$remain_coin;
                            $user->save();
                            DiamondSellHistory::create([
                                'user_id'=>$user->id,
                                'total_diamond'=>$request->diamond_quantity,
                                'sub_total'=>$total_price,
                                'type'=>1
                            ]);
                            CoinUseHistory::create(['user_id'=>$user->id, 'user_coin'=>$total_price, 'type'=>'paid_coin', 'purpose'=>'diamond_purchase']);
                            $datas = [
                                'user_id'=>$user->id,
                                'title' => "You have purchased ".$request->diamond_quantity." diamonds successfully",
                                'type'=>'diamond',
                                'status'=>0
                            ];
                            notification($datas);
                            return response()->json([
                                'message' => "Diamond purchased successfully",
                                'type' => "success",
                                'status' => 200
                            ], Response::HTTP_OK);
                        }else{
                            return response()->json([
                                'message' => "You have insufficient coin",
                                'type' => "success",
                                'status' => 401
                            ], Response::HTTP_OK);
                        }

                    }
                }
            }else{
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'type' => "error",
                    'status' => 422
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function get_diamond_package(){

        $packages=DiamondPackage::where('status',1)->latest()->get();
        $packages=PackageResource::collection($packages);
        return response()->json([
            'paid_diamond' =>auth()->user()->paid_diamond,
            'diamond_purchase' =>auth()->user()->diamond_purchase,
            'diamond_partner'=>auth()->user()->diamond_partner,
            'min_purchase_diamond'=>setting()->min_purchase_diamond,
            'diamond_partner_coin'=>setting()->diamond_partner_coin,
            'diamond_price'=>auth()->user()->diamond_partner==1 ?diamond_setting()->partner_price : diamond_setting()->current_price,
            'packages' =>$packages,
            'type' => "success",
            'status' => 200
        ],Response::HTTP_OK);
    }

    public function purchase_diamond_package(Request $request){
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|integer',
        ]);
        $user=auth()->user();

        if (!$validator->fails()){
            $package=DiamondPackage::find($request->package_id);
            if ($user->paid_coin>=$package->price) {
                $current_diamond = $user->paid_diamond;
                $current_coin = $user->paid_coin;
                $total_diamond = $current_diamond + $package->total_diamond;
                $remain_coin = $current_coin - $package->price;
                $user->paid_diamond = $total_diamond;
                $user->paid_coin = $remain_coin;

                $user->save();
                DiamondSellHistory::create([
                    'user_id' => $user->id,
                    'diamond_package_id' => $package->id,
                    'total_diamond' => $package->total_diamond,
                    'sub_total' => $package->price,
                    'type' => 2
                ]);
                CoinUseHistory::create(['user_id'=>$user->id, 'user_coin'=>$package->price, 'type'=>'paid_coin', 'purpose'=>'diamond_purchase']);
                $datas = [
                    'user_id'=>$user->id,
                    'title' => "You have purchased diamond package successfully",
                    'type'=>'diamond',
                    'status'=>0
                ];
                notification($datas);
                return response()->json([
                    'message' => "Package purchased successfully",
                    'type' => "success",
                    'status' => 200
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'message' => "You have no sufficient coin",
                    'type' => "error",
                    'status' => 401
                ], Response::HTTP_OK);
            }
        }else{
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => "error",
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function diamond_partner(Request $request){
       //return auth()->user()->id;
        $diamond_partner_coin=setting()->diamond_partner_coin;
        $user=auth()->user();
        if ($request->isMethod("POST")){
            if ($user->diamond_partner==1)
            {
                if ($user->paid_coin>=$diamond_partner_coin)
                {
                    $current_coin=$user->paid_coin;
                    $remain_coin=$current_coin-$diamond_partner_coin;
                    $user->paid_coin=$remain_coin;
                    $user->diamond_partner=1;
                    $partner=$user->save();
                    CoinUseHistory::create(['user_id'=>$user->id, 'user_coin'=>$diamond_partner_coin, 'type'=>'paid_coin', 'purpose'=>'diamond_partner']);
                    // provide commission till 15 generation
                    if ($partner)
                    {
                        provide_generation_commission($user,$diamond_partner_coin,COIN_EARNING_SOURCE['diamond_partner_updating']);
                        campaign_history($user,CAMPAIGN_TYPE[1]);
                        share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['diamond_partner'],$diamond_partner_coin);
                        $datas = [
                            'user_id'=>$user->id,
                            'title' => "You are now a diamond partner.",
                            'type'=>'diamond',
                            'status'=>0
                        ];
                        notification($datas);
                        return response()->json([
                            'message'=>"You became diamond partner successfully",
                            'type'=>'success',
                            'status'=>200,
                        ],Response::HTTP_OK);
                    }
                }else
                {
                    return response()->json([
                        'message'=>"You have no sufficient balance",
                        'type'=>'error',
                        'status'=>401,
                    ],Response::HTTP_OK);
                }
            }else{
                return response()->json([
                    'message'=>"You are already diamond partner",
                    'type'=>'error',
                    'status'=>401,
                ],Response::HTTP_OK);
            }

        }

    }

    public function my_referral_detail(){
        $user=auth()->user();

        $normal_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',0);
            })->count();$normal_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',0);
            })->count();

        $vip_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',1);
            })->count();

        $partner_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',2);
            })->count();

        $start_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',3);
            })->count();

        $sub_controller_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',4);
            })->count();

        $controller_members=User::where('parent_id',$user->id)
            ->whereHas('rank',function ($data){
                $data->where('priority',5);
            })->get()->count();

        return response()->json([
            'vip_members'=>$vip_members,
            'partner_members'=>$partner_members,
            'start_members'=>$start_members,
            'sub_controller_members'=>$sub_controller_members,
            'controller_members'=>$controller_members,
            'normal_members'=>$normal_members,
            'type'=>'success',
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);

    }


    public function rank_progress()
    {
        $user=auth()->user();
        $current_rank=$user->rank->priority;
        $next_rank=$user->next_rank->priority;
        $current_member=0;
        $needed_member=0;
        $remain_days=0;
        if ($current_rank==1){

            $needed_member=auto_rank_member('vip_to_partner')->member;
            $current_member=$this->get_current_member($user,1);
            $remain_days=$this->remain_days($user,'vip_to_partner');
        }elseif ($current_rank==2){

            $needed_member=auto_rank_member('partner_to_star')->member;
            $current_member=$this->get_current_member($user,2);
            $remain_days=$this->remain_days($user,'partner_to_star');
        }elseif ($current_rank==3){
            $needed_member=auto_rank_member('star_to_sub_controller')->member;
            $current_member=$this->get_current_member($user,3);
            $remain_days=$this->remain_days($user,'star_to_sub_controller');
        }
        elseif ($current_rank==4){
            $needed_member=auto_rank_member('sub_controller_to_controller')->member;
            $current_member=$this->get_current_member($user,4);
            $remain_days=$this->remain_days($user,'sub_controller_to_controller');
        }

        return response()->json([
            'progress'=>$current_member,
            'milestone'=>$needed_member,
            'remain_day'=>$remain_days,
            'current_rank'=>$user->rank->rank_name,
            'next_rank'=>$user->next_rank->rank_name,
            'type'=>'success',
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);

    }
    public function get_current_member($user,$priority){
        $current_member=User::where('parent_id',$user->id)->whereHas('rank',function ($data) use($priority){
            $data->where('priority',$priority);
        })->get()->count();
        return $current_member;
    }


    public function remain_days($user,$constant_title){
        $last_rank_updated_date=$user->last_rank_update_date;
        $need_rank_update_date=Carbon::parse($last_rank_updated_date)->addDays(auto_rank_block_day($constant_title)->duration);
        $remain_day=Carbon::now()->diffInDays($need_rank_update_date, false);
        return $remain_day;
    }

    public function data_apply(Request $request){
            //return auth()->user()->id;

        $auth_user=auth()->user();
        if ($auth_user->is_mobile_verified ==1) {
            if ($request->type == $this->data_apply_type[0]) {
                if ($auth_user->apply_data == 1) {
                    return response()->json([
                        'data' => null,
                        'message' => "You data apply quota exceeded",
                        'type' => 'warning',
                        'status' => Response::HTTP_BAD_REQUEST,
                    ], Response::HTTP_OK);
                } else {
                    if ($auth_user->paid_coin >= setting()->data_apply_coin) {

                        $collection_users = User::where('parent_id', '=', null)
                            ->where('applicable_user', '=', 1)
                            ->where('is_mobile_verified','=',1)
                            ->where('id', '!=', $auth_user->id)
                            ->take(setting()->data_apply_row)
                            ->get();
                       // return count($collection_users);
                        if (count($collection_users)>=setting()->data_apply_row) {

                            if (!empty($collection_users)) {
                                foreach ($collection_users as $collection_user) {
                                    $collection_user->update(['applicable_user' => 0, 'data_applied_user_id' => $auth_user->id]);
                                }
                            }

                            $auth_user->apply_data = 1;
                            $auth_user->data_applied_date = Carbon::now();
                            $auth_user->data_apply_expired_date = Carbon::now()->addDays(setting()->data_apply_day);
                            $auth_user->paid_coin = $auth_user->paid_coin - setting()->data_apply_coin;
                            $auth_user->save();

                            $collection_users = DataApplyUserResource::collection($collection_users);

                            return response()->json([
                                'data' => $collection_users,
                                'data_apply_validity' => $auth_user->data_apply_expired_date,
                                'message' => "Data Applied Successfully",
                                'type' => 'success',
                                'status' => Response::HTTP_OK,
                            ], Response::HTTP_OK);
                        }else{
                            return response()->json([
                                'message' => "Insufficient users",
                                'type' => 'warning',
                                'status' => Response::HTTP_BAD_REQUEST,
                            ], Response::HTTP_OK);
                        }

                    } else {
                        return response()->json([
                            'data' => null,
                            'message' => "You have insufficient balance",
                            'type' => 'warning',
                            'status' => Response::HTTP_BAD_REQUEST,
                        ], Response::HTTP_OK);
                    }
                }
            } else {
                $collection_users = User::where('data_applied_user_id', $auth_user->id)->get();

                $collection_users = DataApplyUserResource::collection($collection_users);
                return response()->json([
                    'data' => $collection_users,
                    'message' => "All users",
                    'data_apply_validity' => $auth_user->data_apply_expired_date,
                    'type' => 'success',
                    'status' => Response::HTTP_OK,
                ], Response::HTTP_OK);
            }
        }else{
            return response()->json([
                'message' => "Please add your phone number",
                'type' => 'success',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    public function send_referral_code(Request $request){
        if ($request->isMethod('post')){
            $user=User::find($request->user_id)->update(['send_referral_code'=>1]);
            return response()->json([
                'message' => "Successfully send",
                'type' => 'success',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    public function data_apply_info(){
        return response()->json([
            'data' => [
                'data_apply_coin'=>setting()->data_apply_coin,
                'data_apply_day'=>setting()->data_apply_day,
                'data_apply_row'=>setting()->data_apply_row,
            ],
            'type' => 'success',
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }


    public function user_notification()
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->latest()->get();
        $unseen_notifications = Notification::where('user_id',auth()->user()->id)->where('status',0)->latest()->count();
        $notifications = Notificationresource::collection($notifications);
        return response()->json([
            'data' => [
                'total_unseen'=>$unseen_notifications,
                'notifications'=>$notifications,
            ],
            'message'=> 'All of your notifications ',
            'type' => 'success',
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function user_notification_status_update()
    {
        $unseen_notifications = Notification::where('user_id',auth()->user()->id)->where('status',0)->get();
        foreach ($unseen_notifications as $data)
        {
            $data->update(['status'=>1]);
        }
        $notifications = Notification::where('user_id',auth()->user()->id)->latest()->get();
        $notifications = Notificationresource::collection($notifications);
        return api_response('success','Status Successfully update.',$notifications,200);
    }

    public function send_referral_invitation(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
        ]);
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $user=Auth::user();
                $datas = [
                    'user_id'=>$request->user_id,
                    'title' => "you've received a referral invitation from <b>".$user->name." (".$user->refer_code.")</b>",
                    'type'=>'referral_invitation',
                    'status'=>0
                ];
                notification($datas);
                DB::commit();
                return response()->json([
                    'message'=>"Invitation sent successfully",
                    'type'=>'success',
                    'status'=>200,
                ],Response::HTTP_OK);

            }catch (QueryException $exception){

            }
        }

    }

    public function my_referred_share(){
        $user=auth()->user();
        $datas=DB::table('share_holders')
         ->join('share_owners','share_holders.share_owner_id','=','share_owners.id')
        ->select('share_holders.share_number','share_holders.created_at','share_owners.name as share_owner_name','share_owners.avatar as avatar')
        ->where('parent_id',$user->id)->get();

        return response()->json([
            'data'=>$datas,
            'type'=>'success',
            'status'=>200,
        ],Response::HTTP_OK);

    }




}
