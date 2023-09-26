<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order;
use App\Models\ShareHolder;
use App\Models\TokenTransferHistory;
use App\Models\User;
use App\Http\Resources\Referrallist;
use App\Models\UserDevice;
use App\Models\UserReferralBonus;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return  view('webend.user.user', compact('users'));
    }


    public function users_by_date(Request $request)
    {
        if ($request->isMethod("POST")) {
            $users = User::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();
        } else {
            $users = User::query()->orderBy('id', 'DESC')->get();
        }

        return  view('webend.user.user', compact('users'));
    }


    public function add_share(Request $request)
    {
        $already_purchase = ShareHolder::where('user_id', $request->user_id)->count();
        if (share_holder_setting()->share_purchase_limit > $already_purchase) {
            ShareHolder::create([
                'user_id' => $request->user_id,
                'share_number' => 'SH' . rand(1000, 9999),
                'share_type' => 'admin',
            ]);

            return response()->json([
                'data' => 'You have provided a share successfully',
                'title' => 'Success',
                'type' => 'success',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'data' => 'This user already exceeded shareholder limit',
                'title' => 'Warning',
                'type' => 'warning',
                'status' => Response::HTTP_FORBIDDEN,
            ], Response::HTTP_OK);
        }
    }

    public function referral_link()
    {
        if (Auth::user()->vip_member == 1) {
            if (Auth::user()->refer_code == 0) {
                Auth::user()->update(['refer_code' => rand(10000, 99999)]);
            }
            $refercode['code'] = Auth::user()->refer_code;
            $refercode['referral_bonus'] = setting()->referal_bonus;
            $refercode['total_referral_reward'] = UserReferralBonus::where('parent_id', auth()->user()->id)->sum('reward');
            return api_response('success', 'Referel Code', $refercode, Response::HTTP_OK);
        }
    }

    public function refer_code_use(Request $request)
    {
        // return auth()->user();
        $validator = Validator::make($request->all(), [
            'refer_code' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if ((Auth::user()->parent_id == null) && (Auth::user()->used_reffer_code == 0)) {
            $referar  = User::where('refer_code', $request->refer_code)->first();
            if ($referar != null) {
                if (($referar->parent_id != null) && ($referar->parent_id == Auth::user()->id)) {
                    return api_response('success', 'You are not able to use your referrer referel code.', null, Response::HTTP_OK);
                } else {
                    Auth::user()->update([
                        'used_reffer_code' => $request->refer_code,
                        'parent_id' => $referar->id,
                        'applicable_user' => 0,
                    ]);
                    $referar->paid_coin = $referar->paid_coin + setting()->referal_bonus;
                    $referar->save();
                    campaign_history(auth()->user(), CAMPAIGN_TYPE[2]);
                    coin_earning_history($referar->id, setting()->referal_bonus, COIN_EARNING_SOURCE['referral_code_use'],BALANCE_TYPE['paid']);
                    UserReferralBonus::create([
                        'parent_id' => $referar->id,
                        'child_id' => Auth::user()->id,
                        'reward' => setting()->referal_bonus,
                    ]);
                    return api_response('success', 'Referel Code used Successfully.', null, Response::HTTP_OK);
                }
            } else {
                return api_response('success', 'No player found of this refer code.', null, Response::HTTP_OK);
            }
        } else {
            return api_response('warning', 'You are already referred', null, Response::HTTP_OK);
        }
    }

    public function user_referral_list($id)
    {
        $user = User::find($id);
        $referral_user = User::where('parent_id', $id)->where('used_reffer_code', $user->refer_code)->latest()->get();
        return view('webend.user.referal_list', compact('referral_user', 'user'));
    }

    public function my_referral_list()
    {
        $referral_user = User::where('parent_id', Auth::user()->id)->where('used_reffer_code', Auth::user()->refer_code)->latest()->get();
        $referral_user = Referrallist::collection($referral_user);
        return api_response('success', 'All my referral player list', $referral_user, Response::HTTP_OK);
    }

    public function all_referral_history()
    {
        $referral_user = User::where('parent_id', '!=', null)->where('used_reffer_code', '!=', null)->latest()->get();
        return view('webend.referral_history', compact('referral_user'));
    }


    public function token_transfer_history($id)
    {
        $user = User::find($id)->only(['name', 'playerid', 'id']);
        //        dd($user);
        $histories = TokenTransferHistory::where('provider_id', $id)->orWhere('receiver_id', $id)->latest()->get();
        return view('webend.user.token_transfer_history', compact('histories', 'user'));
    }


    public function edit($id)
    {
        $user = User::find($id);
        return view('webend.user.edit', compact('user'));
    }

    public function update_user(Request $request)
    {
        //dd($request->all());
        if ($request->isMethod("POST")) {
            try {
                DB::beginTransaction();
                $user = User::find($request->user_id);
                // return $user->paid_coin+$request->paid_coin;
                $user->name = $request->name;
                $user->gender = $request->gender;
                $user->dob = $request->dob;
                $user->max_loos = $request->max_loos;
                $user->max_win = $request->max_win;
                $user->max_Hit = $request->max_hit;

                $user->win_balance = $request->win_balance;
                $user->crypto_asset = $request->crypto_asset;
                $user->free_diamond = $request->free_diamond;
                $user->paid_diamond = $request->paid_diamond;
                $user->free_coin = $request->free_coin;
                $user->paid_coin = $request->paid_coin;

                $user->save();
                DB::commit();
                Alert::warning('Successfully updated!.');
                return back();
            } catch (QueryException $exception) {
                DB::rollBack();
                $error = $exception->getMessage();
                Alert::warning($error);
                return back();
            }
        }
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $user  = User::find($id);
        if ($user->devices != null) {
            foreach ($user->devices as $data) {
                UserDevice::find($data->id)->delete();
            }
        }
        $user->delete();
        return response()->json(['type' => "success", 'message' => "Deleted Successfully!"]);
    }

    public function data_applied_list($user_id)
    {
        $datas = User::where('data_applied_user_id', $user_id)->get();
        $user = User::find($user_id);
        return view('webend.user.data_applied_user', compact('datas', 'user'));
    }

    public function user_daily_order($user_id)
    {
        $orders = Order::where('user_id', $user_id)->whereDate('created_at', Carbon::today())->get();
        return view('webend.user.daily_order', compact('orders'));
    }
}
