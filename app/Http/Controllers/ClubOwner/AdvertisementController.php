<?php

namespace App\Http\Controllers\ClubOwner;

use App\Http\Controllers\Controller;
use App\Models\AdDuration;
use App\Models\Advertisement;
use App\Models\BalanceTransferHistory;
use App\Models\BoastingMoney;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Ecommerce\Payment;
use App\Models\TimeSlot;
use App\Models\TimeSlotSection;
use App\Models\User;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdvertisementController extends Controller
{


    public function advertisement_list (){
        $auth_user=Auth::guard('owner')->user();
        $datas=Advertisement::where('owner_id',$auth_user->id)->latest()->get();

        $check_current_ad=Advertisement::where(['owner_id'=>$auth_user->id,'status'=>0])->first();

        return view('webend.club_owner.advertisement.advertisement_list',compact('datas','check_current_ad'));
    }

    public function ad_request()
    {
        $ad_durations=AdDuration::query()->get();
        $time_slot_sections=TimeSlotSection::query()->get();
        return view('webend.club_owner.advertisement.ad_request',compact('ad_durations','time_slot_sections'));
    }

    public function advertisement_calculation(Request $request){
        if ($request->isMethod("POST")){
            try {
                if (empty($request->total_ad) || empty($request->total_day)){
                    return response()->json([
                        'message'=>'Something went wrong',
                        'type'=>'error',
                        'status'=>Response::HTTP_FORBIDDEN
                    ]);
                }else{

                    return response()->json([
                        'total_cost'=> $this->get_ad_calculation($request),
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ]);
                }

            }catch (QueryException $exception){
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ]);
            }
        }
    }

    public function get_ad_calculation($request){

        $percent_money=$request->total_day;

        $ad_duration=AdDuration::find($request->ad_duration_id);
        $total_cost=$ad_duration->per_ad_price*$request->total_ad;

        $total_percent=($total_cost*$percent_money)/100;
        $grand_total=$total_cost+$total_percent;


        return $grand_total;
    }

    public function get_time_slot(Request $request){
        if ($request->isMethod("POST")){
            try {
                    $datas=TimeSlot::where('time_slot_section_id',$request->time_slot_selection_id)->get();


                    $option='';

                    if (count($datas)>0){
                        $option.='<option value="">==Select time Slot==</option>';
                        foreach ($datas as $data){
                            $option.='<option value="'.$data->id.'">'.$data->time_slot_from. ($data->time_slot_section_id==1 ?' AM': ' PM')." to ".$data->time_slot_to.($data->time_slot_section_id==1 ? ' PM': ' AM').'</option>';
                        }

                    }else{
                        $option.='<option value="">No slot found</option>';
                    }

                    return response()->json([
                        'data'=> $option,
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ]);


            }catch (QueryException $exception){
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ]);
            }
        }
    }

    public function submit_ad_request(Request $request){


        $user=Auth::guard('owner')->user();

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $data=new Advertisement();
                $data->club_id=$user->club_id;
                $data->owner_id=$user->id;
                $data->total_ad=$request->total_ad;
                $data->total_day=$request->total_day;
                $data->total_day=$request->total_day;
                $data->ad_show_per_day=$request->ad_show_per_day;
                $data->total_cost=$request->total_cost;
                $data->remain_ad=$request->total_ad;

                $data->ad_duration_id=$request->ad_duration_id;
                $data->time_slot_section_id=$request->time_slot_section_id;
                $data->time_slot_id=$request->time_slot_id;

                $ad_duration=AdDuration::find($request->ad_duration_id);


                if ($ad_duration->has_slot==0){

                    $ad_start_from=Carbon::now()->format('Y-m-d H:i:s');
                    $ad_end_in=Carbon::now()->addDays($request->total_day)->format('Y-m-d H:i:s');
                    $data->ad_start_from=$ad_start_from;
                    $data->ad_end_in=$ad_end_in;


                }else{

                    $time_slot_section=TimeSlotSection::find($request->time_slot_section_id);
                    $time_slot=TimeSlot::find($request->time_slot_id);

                    $now_date=Carbon::now()->format('Y-m-d');

                    $ad_start_from=$now_date." ".$time_slot->time_slot_from;
                    $ad_end_in=Carbon::now()->addDays($request->total_day)->format('Y-m-d')." ".$time_slot->time_slot_to;;

                    $data->ad_start_from=$ad_start_from;
                    $data->ad_end_in=$ad_end_in;

                }
                $data->save();
                DB::commit();
                return response()->json([
                    'message'=>"Request sent successfully",
                    'status'=>200,
                    'type'=>'success'
                ]);

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'status'=>500,
                    'type'=>'error'
                ]);
            }
        }
    }

    public function boasting_money(){
        $datas=BoastingMoney::query()->where('owner_id',Auth::guard('owner')->user()->id)
            ->orderBy('id','DESC')->get();
        return view('webend.club_owner.advertisement.boasting',compact('datas'));
    }

    public function boasting_money_request(){
        $payments=Payment::where('status',1)->orderBy('id','desc')->get();
        $datas=BoastingMoney::where('owner_id',Auth::guard('owner')->user()->id)->latest()->get();
        return view('webend.club_owner.advertisement.boasting_request',compact('payments','datas'));
    }

    public function dollar_convert(Request $request){
        if ($request->isMethod("POST")){
            try {

                //$total_dollar=(1*$request->boasting_amount)/default_currency()->convert_to_bdt;

                $data=dollar_to_other($request->boasting_amount);

                return response()->json([
                    'total_bdt'=>$data['total_bdt'],
                    'total_inr'=>$data['total_inr'],
                    'status'=>500,
                    'type'=>'error'
                ]);
            }catch (QueryException $exception){

                return response()->json([
                    'message'=>'Something went wrong',
                    'status'=>500,
                    'type'=>'error'
                ]);
            }
        }
    }

    public function send_boasting_request(Request $request){
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $image_name=null;
                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();

                    $image_path = public_path().'/uploads/boasting/'.$image_name;

                    Image::make($image)->save($image_path);

                }
                BoastingMoney::create([
                    'owner_id'=>Auth::guard('owner')->user()->id,
                    'payment_id'=>$request->payment_id,
                    'boasting_amount'=>$request->boasting_amount,
                    'boasting_dollar'=>$request->boasting_amount,
                    'transaction_number'=>$request->transaction_number,
                    'image'=>$image_name,
                    'status'=>1
                ]);

                DB::commit();
                return response()->json([
                    'data'=>"Boasting successfully",
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

    public function import_paid_coin(){
        $auth_user=Auth::guard('owner')->user();

        $datas=BalanceTransferHistory::where('user_id',$auth_user->origin_id)->get();
        $user=User::find($auth_user->origin_id);

        return view('webend.club_owner.advertisement.import_paid_coin',compact('user','datas'));
    }

    public function import_paid_calculation(Request $request){

        if ($request->isMethod("POST")){
            try {
                $total_charged=($request->gift_coin*setting()->gift_to_dollar)/100;

               $remain_coin=$request->gift_coin-$total_charged;
               $total_used=$remain_coin*COIN_USD_RATE;

                $data=dollar_to_other($total_used);

                return response()->json([
                    'total_bdt'=>$data['total_bdt'],
                    'total_inr'=>$data['total_inr'],
                    'total_usd'=>$total_used,
                    'status'=>500,
                    'type'=>'error'
                ]);
            }catch (QueryException $exception){

                return response()->json([
                    'message'=>'Something went wrong',
                    'status'=>500,
                    'type'=>'error'
                ]);
            }
        }

    }

    public function import_coin_store(Request $request){
      //  dd($request->all());
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $total_charged=($request->gift_coin*setting()->gift_to_dollar)/100;

                $auth_user=Auth::guard('owner')->user();
                $auth_user->balance=$auth_user->balance+$request->import_dollar;
                $auth_user->save();

                $user=User::find($auth_user->origin_id);

                $user->paid_coin=$user->paid_coin-$request->gift_coin;
                $user->save();

                $history = new BalanceTransferHistory();
                $history->user_id = $user->id;
                $history->depart_from = 'paid_coin';
                $history->destination_to = 'dollar';
                $history->transfer_balance = $request->gift_coin;
                $history->deduction_charge = $total_charged;
                $history->stored_balance = $request->import_dollar;
                $history->constant_title = BalanceTransferHistory::balance_transfer_constant[4];
                $history->save();

                DB::commit();


                return response()->json([
                    'message'=>'Coin imported successfully',
                    'status'=>200,
                    'type'=>'success'
                ]);

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'status'=>500,
                    'type'=>'error'
                ]);
            }
        }
    }
}
