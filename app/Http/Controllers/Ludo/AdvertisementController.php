<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Models\AdvertisementSetting;
use App\Models\Club;
use App\Models\Owner;
use App\Models\UserSeenAdTrack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdvertisementController extends Controller
{


    public function get_ad(Request $request){


    if (count($request->ad_seen_user_devices)>0){



        for ($i=0; $i<count($request->ad_seen_user_devices);$i++){

            UserSeenAdTrack::create([
                'user_id'=>$request->ad_seen_user_devices[$i]['user_id'],
                'advertisement_id'=>$request->ad_seen_user_devices[$i]['advertisement_id'],
                'device_number'=>$request->ad_seen_user_devices[$i]['device_number'],
            ]);

        }
    }


        $now_date_time=Carbon::now()->format('Y-m-d H:i:s');
        $now_time=Carbon::now()->format('H:i:s');
        $now_time_format=Carbon::now()->format('A');
//        if ($now_time_format=="AM"){
//            $now_time_format="PM";
//        }elseif($now_time_format=="PM"){
//            $now_time_format="AM";
//        }



        $ads=Advertisement::where('status',0)
            ->where('ad_start_from','<=',$now_date_time)
            ->where('ad_end_in','>=',$now_date_time)
            ->latest()
            ->paginate(2,['*'],"page",$request->page)
            ->through(function ($ad) use ($now_time,$now_time_format){
                if ($ad->ad_duration->has_slot==0){
                    return [
                        'id'=>$ad->id,
                        'club_name'=>$ad->club->club_name,
                        'club_logo'=>$ad->club->logo,
                        'ad_duration'=>$ad->ad_duration->title,
                        'time_slot_section'=>$ad->time_slot_section->section_name ?? 'null',
                        'time_slot_from'=>$ad->time_slot->time_slot_from ?? 'null',
                        'time_slot_to'=>$ad->time_slot->time_slot_to ?? 'null',
                        'total_ad'=>$ad->total_ad,
                        'total_day'=>$ad->total_day,
                        'ad_show_per_day'=>$ad->ad_show_per_day,
                        'ad_start_from'=>$ad->ad_start_from,
                        'ad_end_in'=>$ad->ad_end_in,
                        'user_seen_ad_track_today'=>$ad->user_seen_ad_track_today->map(function ($seen){
                            return[
                                'id'=>$seen->id,
                                'user_id'=>$seen->user_id,
                                'advertisement_id'=>$seen->advertisement_id,
                                'device_number'=>$seen->device_number
                            ];
                        })
                    ];
                }else{
                    if ($ad->time_slot_section->section_name==$now_time_format){
                        if ($now_time>=$ad->time_slot->time_slot_from){
                        return[
                            'id'=>$ad->id,
                            'club_name'=>$ad->club->club_name,
                            'club_logo'=>$ad->club->logo,
                            'ad_duration'=>$ad->ad_duration->title,
                            'time_slot_section'=>$ad->time_slot_section->section_name ?? 'null',
                            'time_slot_from'=>$ad->time_slot->time_slot_from ?? 'null',
                            'time_slot_to'=>$ad->time_slot->time_slot_to ?? 'null',
                            'total_ad'=>$ad->total_ad,
                            'total_day'=>$ad->total_day,
                            'ad_show_per_day'=>$ad->ad_show_per_day,
                            'ad_start_from'=>$ad->ad_start_from,
                            'ad_end_in'=>$ad->ad_end_in,
                            'user_seen_ad_track_today'=>$ad->user_seen_ad_track_today->map(function ($seen){
                                return[
                                    'id'=>$seen->id,
                                    'user_id'=>$seen->user_id,
                                    'advertisement_id'=>$seen->advertisement_id,
                                    'device_number'=>$seen->device_number
                                ];
                            })
                        ];
                        }
                   }

                }
            });



        $extra_clubs=[];
        if (count($ads)<2){
            $clubs=Owner::latest()->get();
            foreach ($clubs as $club){
                array_push($extra_clubs,['club_id'=>$club->club->id,'club_name'=>$club->club->club_name]);
            }
        }


        return response()->json([

            'extra_clubs'=>$extra_clubs,
            'datas'=>$ads,
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);
    }

    public function club_ad_setting(){
        $data=AdvertisementSetting::first(['ad_stay_time','ad_show_per_day','visitor_stay_time','max_per_day_ad_show']);
        return response()->json([
            'data'=>$data,
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);
    }

    public function club_detail($id){
        $club=Club::with('owner','club_tournaments')->find($id);

        return response()->json([
            'data'=>$club,
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);


    }

}
