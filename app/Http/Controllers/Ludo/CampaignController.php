<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Campaignlistresource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignTournament;
use App\Models\Campaign;
use App\Models\CampaignDetail;
use App\Models\CampaignPosition;
use App\Models\OfferTournament;
use App\Models\RegisterToOfferTournament;
use App\Models\Tournament;
use http\Client\Curl\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RealRashid\SweetAlert\Facades\Alert;

class CampaignController extends Controller
{

    public function get_tournament_type(){

      $game_types=config('app.game_type');

        return response()->json([
            'data'=>$game_types,
            'type'=>'success',
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);

    }

    public function tournament($type){
        $tournaments=Tournament::where(['game_type'=>$type,'status'=>1])->get();
        $tournaments=CampaignTournament::collection($tournaments);

        return response()->json([
            'data'=>$tournaments,
            'type'=>'success',
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);
    }

    public function campaign_info($id){

        $campaign=Campaign::find($id);
        $referral= $this->campaign_referral($campaign,"download");
        $position = $this->campaign_position($campaign);
        $eligible_status = $this->is_eligible($campaign,$referral,$position);
        $enroled = RegisterToOfferTournament::where('tournament_id',$campaign->tournament->id)->where('user_id',auth()->user()->id)->first();
        $total_enroled = RegisterToOfferTournament::where('tournament_id',$campaign->tournament->id)->count();

        $campaign=new CampaignResource($campaign);

        return response()->json([
            'campaign'=>$campaign,
            'enroled_status'=>$enroled != null ? "yes":'no',
            'total_enroled'=>$total_enroled,
            'eligible_status'=>$eligible_status,
            'your_total_position'=>count($position),
            'your_total_referral'=>count($referral),
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }
    public function campaign_detail($campaign){
        $user= auth()->user();
        $campaign_details=CampaignDetail::where('constrain_title',$campaign->constrain_title)
            ->where('parent_id',$user->id)
            ->whereDate('created_at','>=',$campaign->start_date)
            ->whereDate('created_at','<=',$campaign->end_date)
            ->where('status',1)
            ->get();
        return $campaign_details;
    }

    public function campaign_referral($campaign,$constrain_title){
        $user= auth()->user();
        $referrals=CampaignDetail::where('constrain_title',$constrain_title)
            ->where('parent_id',$user->id)
            ->whereDate('created_at','>=',$campaign->start_date)
            ->whereDate('created_at','<=',$campaign->end_date)
            ->where('status',1)
            ->get();
        return $referrals;
    }

    public function campaign_position($campaign){
        $user= auth()->user();
        $positions = CampaignDetail::where('constrain_title',$campaign->constrain_title)
            ->where('parent_id',$user->id)
            ->whereDate('created_at','>=',$campaign->start_date)
            ->whereDate('created_at','<=',$campaign->end_date)
            ->where('status',1)
            ->get();
        return $positions;
    }
    public function is_eligible($campaign,$referral,$position)
    {
        return count($position)>=$campaign->total_needed_position && count($referral)>=$campaign->total_needed_referral ? 1 : 0;
    }

    public function register_to_offer_tournament(Request $request)
    {

        $check_registration_available=RegisterToOfferTournament::where('campaign_id',$request->campaign_id)
             ->where('tournament_id',$request->tournament_id)
            ->get();

        $tournament=Tournament::where('id',$request->tournament_id)
            ->first();
        $user=auth()->user();

        if (count($check_registration_available)>=$tournament->player_limit){
            return response()->json([
                'data'=>"This tournament already house full",
                'type'=>'warning',
                'status'=>Response::HTTP_BAD_REQUEST,
            ],Response::HTTP_OK);
        }else{
            $exist_user=RegisterToOfferTournament::where('campaign_id',$request->campaign_id)
                ->where('tournament_id',$request->tournament_id)
                ->where('user_id',$user->id)
                ->first();

            if (empty($exist_user)){
                $register=new RegisterToOfferTournament();
                $register->campaign_id=$request->campaign_id;
                $register->tournament_id=$request->tournament_id;
                $register->user_id=$user->id;
                $register->save();

                $total_registrations=RegisterToOfferTournament::where('campaign_id',$request->campaign_id)
                    ->where('tournament_id',$request->tournament_id)
                    ->get();

                if (count($total_registrations)>=$tournament->player_limit){

                    $campaign=Campaign::where('id',$request->campaign_id)
                        ->where('tournament_id',$request->tournament_id)
                        ->first();
                    if (!empty($campaign)){
                        $campaign->update(['status'=>0]);
                    }
                }
                return response()->json([
                    'data'=>"Successfully registered",
                    'type'=>'success',
                    'status'=>Response::HTTP_OK,
                ],Response::HTTP_OK);
            }else{
                return response()->json([
                    'data'=>"You have already registered",
                    'type'=>'warning',
                    'status'=>Response::HTTP_BAD_REQUEST,
                ],Response::HTTP_OK);
            }
        }
    }

    public function get_campaign_position()
    {
        $positions = CampaignPosition::get();
        return view('webend.campaign.index',compact('positions'));
    }


    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return view('webend.campaign.campaign_index',compact('campaigns'));
    }

    public function create_campaign()
    {
        $exist_campaign_position = Campaign::where('status',1)->pluck('campaign_position_id');
        $campaign_position = CampaignPosition::where('status',1)->whereNotIn('id',$exist_campaign_position)->get();
        $exist_tournament = Campaign::where('status',1)->pluck('tournament_id');
        $tournaments = Tournament::where('game_type',4)->latest()->where('status',1)->whereNotIn('id',$exist_tournament)->get();
        return view('webend.campaign.create',compact('tournaments','campaign_position'));
    }

    public function store_campaign(Request $request)
    {
        $request->validate([
            'start_date' =>'required',
            'campaign_title' =>'required',
            'end_date' =>'required',
            'total_needed_position' =>'required',
            'total_needed_referral' =>'required',
            'duration' =>'required',
            'status' =>'required',
        ]);
        $create = new Campaign();
        $create->tournament_id = $request->tournament_id;
        $create->campaign_title = $request->campaign_title;
        $create->campaign_position_id = $request->position_id;
        $create->start_date = $request->start_date;
        $create->end_date = $request->end_date;
        $create->total_needed_position = $request->total_needed_position;
        $create->total_needed_referral = $request->total_needed_referral;
        $create->duration = $request->duration;
        $create->constrain_title = CampaignPosition::find($request->position_id)->position_name;
        // if (($create->status == 0) &&  $request->status == 1){
        //  $title = 'New offer Created for this tournament';
        //notification_store($title,'campaign',$request->tournament_id,$create->id);
        // }
        $create->status = $request->status;
        $create->save();
        if ($create)
        {
            Alert::success("Created Successfully!");
            return redirect()->route('campaign.index');
        }
    }

    public function edit($id)
    {
        $campaign = Campaign::find($id);
        return view('webend.campaign.edit',compact('campaign'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'start_date' =>'required',
            'end_date' =>'required',
            'total_needed_position' =>'required',
            'total_needed_referral' =>'required',
            'duration' =>'required',
            'status' =>'required',
        ]);
        $campaign = Campaign::find($id);
        $campaign->start_date = $request->start_date;
        $campaign->end_date = $request->end_date;
        $campaign->duration = $request->duration;
        $campaign->total_needed_position = $request->total_needed_position;
        $campaign->total_needed_referral = $request->total_needed_referral;
        // if (($offer_target->status == 0) &&  $request->status == 1){
        //  $title = 'New offer Created for this tournament';
        //notification_store($title,'campaign',$request->tournament_id,$offer_target->id);
        // }
        $campaign->status = $request->status;
        $campaign->save();
        if ($campaign)
        {
            Alert::success("Updated Successfully!");
            return redirect()->route('campaign.index');
        }
    }

    public function all_campaign()
    {
        $campaigns  = Campaign::whereDate('end_date','>',Carbon::today())->where('status',1)->get();
        $campaigns = Campaignlistresource::collection($campaigns);
        return api_response('success','All Campaigns.',$campaigns,200);
    }



}
