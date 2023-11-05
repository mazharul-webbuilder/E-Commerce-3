<?php
use App\Models\ShareHolderIncomeSource;
use App\Models\ShareHolderFundHistory;
use App\Models\User;
use App\Models\Playerinboard;
use App\Models\RoundSettings;
use App\Models\Gameround;
use App\Models\ClubSetting;
use Carbon\Carbon;

const SHARE_HOLDER_INCOME_SOURCE=[
    'rank_update'            =>'rank_update',
    'tournament_registration'=>'tournament_registration',
    'diamond_use'            =>'diamond_use',
    'bidding'                =>'bidding',
    'club_registration'      =>'club_registration',
    'diamond_partner'        =>'diamond_partner'
];
const CAMPAIGN_POSITION_CONSTRAIN_TITLE=[
    'vip'            =>'vip',
    'partner'        =>'partner',
    'star'           =>'star',
    'sub_controller' =>'sub_controller',
    'controller'     =>'controller',
    'diamond_partner'=>'diamond_partner'
];


/**
 * @author DEV3
 * List of source by which commission can be distribution to all over the application,
 * Don't change any value, if needed you can add a new
*/
const COMMISSION_SOURCE = [
    'admin' => 'admin',
    'merchant' => 'merchant',
    'seller' => 'seller',
    'affiliator' => 'affiliator',
    'shareOwner' => 'shareOwner',
    'clubOwner' => 'clubOwner'
];

function share_holder_fund_history($income_source_type,$coin){
    $income_source=ShareHolderIncomeSource::where('constrain_title',$income_source_type)->first();
    if ($income_source->commission_type==1){
        if ($income_source_type==SHARE_HOLDER_INCOME_SOURCE['club_registration']){
            $total_commission=$coin;
        }else {
            $total_commission=($income_source->commission*$coin)/100;
        }
    }else{
        $total_commission=$coin*$income_source->commission;
    }
    ShareHolderFundHistory::create([
        'income_source_id'=>$income_source->id,
        'commission_amount'=>$total_commission,
        'commission_based_on'=>$coin,
        'commission_source'=>$income_source_type
    ]);

}

function my_referral($user_id){

    $referral=User::whereMonth('created_at',Carbon::now()->month)
    ->where('parent_id',$user_id)->get();
    return $referral;
}
function my_played_tournament($user_id){

    $tournaments=Playerinboard::whereMonth('created_at',Carbon::now()->month)
                ->where(function ($query) use($user_id){
                    $query->where('player_one',$user_id)
                    ->orWhere('player_two',$user_id)
                    ->orWhere('player_three',$user_id)
                    ->orWhere('player_four',$user_id)
                    ->get();
                })
                ->groupBy('tournament_id')
                ->get();
        return $tournaments;

}
function played_from_my_referral($user_id){

    $referrals=User::where('parent_id',$user_id)->get();
    $referral_played=0;
    if (count($referrals)>0){
        foreach ($referrals as $referral){
            $tournaments=Playerinboard::whereMonth('created_at',Carbon::now()->month)
                ->where(function ($query) use ($referral){
                    $query->where('player_one',$referral->id)
                        ->orWhere('player_two',$referral->id)
                        ->orWhere('player_three',$referral->id)
                        ->orWhere('player_four',$referral->id)
                        ->get();
                })
                 ->groupBy('tournament_id')
                 ->get();
            if (count($tournaments)>0){
                $referral_played=$referral_played+count($tournaments);
            }
        }
    }
    return $referral_played;
}
function calculate_share_commission($commission,$commission_percent){
    $coin=($commission*$commission_percent)/100;
    return $coin;
}

function tournament_round($tournament_id,$game_id){
    $rounds=RoundSettings::where('tournament_id',$tournament_id)->get();
    if (count($rounds)>0){
       foreach ($rounds as $round){
           Gameround::create([
               'tournament_id'=>$tournament_id,
               'game_id'=>$game_id,
               'round_no'=>$round->round_type,
               'status'=>0
           ]);
       }
    }
   //return $rounds;
}

function club_setting(){
    return ClubSetting::first();
}

function deposit_withdraw_status($status){
    switch ($status){
        case 1:
            return "Pending";
        case 2:
            return "Processing";
        case 3:
            return "Accepted";
        case 4:
            return "Rejected";

    }
}

