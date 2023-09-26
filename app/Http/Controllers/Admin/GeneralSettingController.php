<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankUpdateAdminStore;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;


class GeneralSettingController extends Controller
{


    public function general_setting()
    {
        $setting = Settings::first();
        return view('webend.setting.general_setting', compact('setting'));
    }

    public function update_general_setting(Request $request)
    {

        // return $request->free_login_coin;
        //dd($request->all());

        $this->validate($request, [
            'free_login_coin' => 'required',
            'free_login_diamond' => 'required',
            'min_purchase_diamond' => 'required',
            'min_withdraw_limit' => 'required',
            'max_withdraw_limit' => 'required',
            'referal_bonus' => 'required',
            'diamond_partner_coin' => 'required',
            'admin_store' => 'required',
            'sub_controller_commission' => 'required',
            'controller_commission' => 'required',
            'use_diamond' => 'required',
            'gift_to_win_charge' => 'required',
            'win_to_gift_charge' => 'required',
            'marketing_to_win_charge' => 'required',
            'marketing_to_gift_charge' => 'required',
            'balance_withdraw_charge' => 'required',
            'played_tournament' => 'required',
            'win_game_percentage' => 'required',
            'bidder_commission' => 'required',
            'min_bidding_amount' => 'required',
            'max_bidding_amount' => 'required',
            'coin_convert_to_bdt' => 'required',
            'data_apply_row' => 'required',
            'data_apply_day' => 'required',
            'data_apply_coin' => 'required',
            'tournament_unregistation_commission' => 'required',
            'game_logo' => 'nullable|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->isMethod("post")) {
            DB::beginTransaction();
            try {
                $setting = Settings::find($request->id);
                $setting->free_login_coin = $request->input('free_login_coin');
                $setting->free_login_diamond = $request->input('free_login_diamond');
                $setting->min_purchase_diamond = $request->input('min_purchase_diamond');
                $setting->min_withdraw_limit = $request->input('min_withdraw_limit');
                $setting->max_withdraw_limit = $request->input('max_withdraw_limit');
                $setting->referal_bonus = $request->input('referal_bonus');
                $setting->diamond_partner_coin = $request->input('diamond_partner_coin');
                $setting->admin_store = $request->input('admin_store');
                $setting->sub_controller_commission = $request->input('sub_controller_commission');
                $setting->controller_commission = $request->input('controller_commission');
                $setting->use_diamond = $request->input('use_diamond');
                $setting->gift_to_win_charge = $request->input('gift_to_win_charge');
                $setting->win_to_gift_charge = $request->input('win_to_gift_charge');
                $setting->marketing_to_win_charge = $request->input('marketing_to_win_charge');
                $setting->marketing_to_gift_charge = $request->input('marketing_to_gift_charge');
                $setting->balance_withdraw_charge = $request->input('balance_withdraw_charge');
                $setting->played_tournament = $request->input('played_tournament');
                $setting->win_game_percentage = $request->input('win_game_percentage');
                $setting->min_bidding_amount = $request->input('min_bidding_amount');
                $setting->max_bidding_amount = $request->input('max_bidding_amount');
                $setting->bidder_commission = $request->input('bidder_commission');
                $setting->admin_commission_from_bid = 100 - $request->input('bidder_commission');
                $setting->coin_convert_to_bdt = $request->input('coin_convert_to_bdt');
                $setting->data_apply_row = $request->input('data_apply_row');
                $setting->data_apply_day = $request->input('data_apply_day');
                $setting->data_apply_coin = $request->input('data_apply_coin');
                $setting->tournament_unregistation_commission = $request->input('tournament_unregistation_commission');
                $setting->withdraw_saving = $request->input('withdraw_saving');
                $setting->withdraw_saving_controller = $request->input('withdraw_saving_controller');
                $setting->withdraw_saving_sub_controller = $request->input('withdraw_saving_sub_controller');

                if ($request->game_logo != null) {
                    if ($setting->game_logo != null) {
                        unlink(public_path($setting->game_logo));
                    }
                    $destinationPath = public_path('/uploads/settings');
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath);
                    }
                    $imageName = time() . '.' . $request->game_logo->extension();
                    $path = public_path('uploads/settings/');
                    $request->game_logo->move($path, $imageName);
                    $setting->game_logo = 'uploads/settings/' . $imageName;
                }

                $setting->save();
                DB::commit();
                return response()->json([
                    'message' => "Successfully updated",
                    'type' => "success",
                    "status" => Response::HTTP_OK,
                ], Response::HTTP_OK);
            } catch (QueryException $e) {
                DB::rollBack();
                $error = $e->getMessage();
                return response()->json([
                    'message' => $error,
                    'type' => "error",
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function view_commission_history()
    {

    //    $datas = RankUpdateAdminStore::whereMonth('created_at', Carbon::now())
         //   ->whereStatus(1)
         //   ->latest()->get();

        $datas = RankUpdateAdminStore::query()
            ->whereStatus(1)
            ->latest()->get();
        return view('webend.setting.recovery_fund_history', compact('datas'));
    }

    public function distribute_recovery_fund()
    {

        $datas = RankUpdateAdminStore::whereMonth('created_at', Carbon::now())
            ->whereStatus(1)->latest()->get();

        $users = User::whereHas('rank', function ($q) {
            $q->whereIn('priority', [4, 5]);
        })->get();

        if (count($users) > 0) {
            foreach ($users as $user) {

                $my_referral = count(my_referral($user->user_id));
                $my_played = count(my_played_tournament($user->user_id));
                $my_referral_played = played_from_my_referral($user->user_id);

                if ($my_referral >= setting()->recover_need_referral || $my_played >= setting()->recover_need_my_played || $my_referral_played >= setting()->recover_need_team_played) {

                    $commission = calculate_recovery_fund_commission($datas->sum('commission_amount'), $user->rank->priority);
                    $current_paid_coin = $user->paid_coin;
                    $total_paid_coin = $current_paid_coin + $commission;
                    $user->paid_coin = $total_paid_coin;
                    $user->save();
                    coin_earning_history($user->id, $commission, COIN_EARNING_SOURCE['recovery_fund']);
                }
            }
        }

        foreach ($datas as $data) {
            $data->update(['status' => 0]);
        }
        Alert::success('Successfully distribute.');
        return back();
    }
}
