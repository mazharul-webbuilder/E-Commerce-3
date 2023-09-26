<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdDuration;
use App\Models\Advertisement;
use App\Models\AdvertisementSetting;
use App\Models\TimeSlot;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Time;

class AdvertisementController extends Controller
{



    public function setting(){
        $data=AdvertisementSetting::query()->first();
        return view('webend.advertisement.setting',compact('data'));
    }

    public function setting_update(Request $request){

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $data=AdvertisementSetting::find($request->id);
                $data->visitor_stay_time=$request->visitor_stay_time;
                $data->ad_stay_time=$request->ad_stay_time;
                $data->minimum_ad_limit=$request->minimum_ad_limit;
                $data->maximum_ad_limit=$request->maximum_ad_limit;
                $data->ad_show_per_day=$request->ad_show_per_day;
                $data->ad_continue_day=$request->ad_continue_day;
                $data->advertiser_referral_commission=$request->advertiser_referral_commission;
                $data->share_holder_fund_commission=$request->share_holder_fund_commission;
                $data->asset_fund_commission=$request->asset_fund_commission;
                $data->visitor_commission=$request->visitor_commission;
                $data->save();

                DB::commit();
                return response()->json([
                    'message'=>"Successfully updated",
                    'type'=>'success',
                    'status'=>200
                ],Response::HTTP_OK);


            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception,
                    'type'=>'error',
                    'status'=>500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }

    }

    public function ad_duration(){
        $datas=AdDuration::get();
        return view('webend.advertisement.ad_duration',compact('datas'));
    }

    public function time_slot($ad_duration_id){
        $datas=TimeSlot::where('ad_duration_id',$ad_duration_id)->get();
        return view('webend.advertisement.time_slot',compact('datas'));

    }

    public function ad_list(){
        $datas=Advertisement::latest()->get();
        return view('webend.advertisement.add_list',compact('datas'));
    }
}
