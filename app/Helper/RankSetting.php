<?php
use App\Models\CoinRankUpdate;
use App\Models\Rank;
use App\Models\RankUpdateHistory;
use App\Models\RankUpdateToken;
use App\Models\AutoRankUpdate;
use Carbon\Carbon;
use App\Models\RankUpdateDay;
use App\Models\RankCommission;
use App\Models\User;
use App\Models\CoinEarningHistory;
use Illuminate\Support\Facades\DB;

const RANK_COMMISSION_COLUMN=['registration_commission','diamond_commission','betting_commission','withdraw_commission','game_asset_commission','updating_commission'];


function rank_update_coin($rank_id){
    $rank_coin=CoinRankUpdate::where('rank_id',$rank_id)->first();
    return $rank_coin;
}
function rank_update_token($rank_id){
    $rank_token=RankUpdateToken::where('rank_id',$rank_id)->first();
    return $rank_token;
}
function auto_rank_member($constant_title){
    $auto_rank_member=AutoRankUpdate::where('constant_title',$constant_title)->first();
    return $auto_rank_member;
}
function auto_update_user_rank($user){
    $current_game_asset=$user->game_asset;
    $user->game_asset=$current_game_asset+$user->hold_coin;
    $user->hold_coin=0;
    $user->block_commission=1;

    $user->rank_id=$user->next_rank_id;
    $user->last_rank_update_date=Carbon::now()->format('Y-m-d h:i:s');
    if ($user->next_rank->priority !==5){
        $next_rank=Rank::where('priority',$user->next_rank->priority+1)->first();
        $user->next_rank_id=$next_rank->id;

    }else{
        $user->next_rank_id=$user->rank_id;
        $user->next_rank_status="stop";
    }


    if (!empty($next_rank)){
        $user->next_rank_id=$next_rank->id;
    }
    $update_user=$user->save();
    // campaign history
    if ($update_user){
        campaign_history(User::find($user->id),CAMPAIGN_TYPE[0]);
    }

}

function rank_update_history($user){
     RankUpdateHistory::create([
        'user_id'=>$user->id,
        'previous_rank_id'=>$user->rank_id,
        'current_rank_id'=>$user->next_rank_id,
         'type'=>'auto_update'
    ]);
}

function auto_rank_block_day($constant_title)
{
    $auto_rank_day=RankUpdateDay::where('constant_title',$constant_title)->first();
    return $auto_rank_day;
}
function auto_block_user_asset_commission($user,$constant_title){
    $today=date('Y-m-d h:i:s');
    $last_rank_update_date=$user->last_rank_update_date;
    $date_diff=strtotime($today)-strtotime($last_rank_update_date);
    $last_updated_day= round($date_diff / (60 * 60 * 24));
    $required_day=auto_rank_block_day($constant_title)->duration;
    if ($last_updated_day>=$required_day){
        $user->block_commission=0;
        $user->save();
    }
}
function rank_commission($rank_id){
    $commission=RankCommission::where('rank_id',$rank_id)->first();
    return $commission;
}
function rank_commission_calculation($type,$commission,$coin)
{
    $total_commission=0;
    if ($type==RANK_COMMISSION_COLUMN[0]){
        $total_commission=(($coin*$commission)/100);
    }elseif ($type==RANK_COMMISSION_COLUMN[1]){
        $total_commission=$coin*$commission;
        //$total_commission=$commission;
    }elseif ($type==RANK_COMMISSION_COLUMN[2]){
        $total_commission=(($coin*$commission)/100);
    }elseif ($type==RANK_COMMISSION_COLUMN[3]){
        $total_commission=(($coin*$commission)/100);
    }elseif ($type==RANK_COMMISSION_COLUMN[4]){
        $total_commission=$commission;
    }

    return $total_commission;
}

// this function fronted users
function commission_by_column_name($type,$user,$coin){
         $commission_column=0;

        if ($type==RANK_COMMISSION_COLUMN[0]){
            $commission_column=rank_commission_calculation($type,rank_commission($user->rank_id)->registration_commission,$coin);
        }elseif($type==RANK_COMMISSION_COLUMN[1]){
            $commission_column=rank_commission_calculation($type,rank_commission($user->rank_id)->diamond_commission,$coin);
        }elseif ($type==RANK_COMMISSION_COLUMN[2]){
            $commission_column=rank_commission_calculation($type,rank_commission($user->rank_id)->betting_commission,$coin);
        }elseif ($type==RANK_COMMISSION_COLUMN[3]){
            $commission_column=rank_commission_calculation($type,rank_commission($user->rank_id)->withdraw_commission,$coin);
        }elseif ($type==RANK_COMMISSION_COLUMN[4]){
            $commission_column=rank_commission_calculation($type,rank_commission($user->rank_id)->game_asset_commission,$coin);
        }
        return $commission_column;


}

function calculate_recovery_fund_commission($amount,$rank){
    if ($rank===5){
       return ((setting()->controller_commission*$amount)/100);
    }elseif($rank===4){
      return ((setting()->sub_controller_commission*$amount)/100);
    }
}


function get_rank_wise_user($rank_name, $type){

    if ($type==='diamond_partner'){
        $users=User::where('diamond_partner',$rank_name)->get();
    }else{
        $users=User::whereHas('rank',function ($query) use ($rank_name){
            $query->where('priority',$rank_name);
        })->get();
    }

    return $users;
}
function get_rank_name($rank_name,$type){
        if ($type==='diamond_partner'){
            return "Diamond Partner";
        }
        switch ($rank_name){
            case 0:
                return "Normal User";
            case 1:
                return "VIP";
            case 2:
                return "Partner";
            case 3:
                return "Start";
            case 4:
                return "Sub Controller";
            case 5:
                return "Controller";
        }
}

if (!function_exists('updateUserRank')) {
    function updateUserRank(User $user, string $rankUpdatedType): void
    {
        $previousRank = $user->rank_id;

        $user->rank_id = DB::table('ranks')->where('priority', 1)->value('id');
        $user->next_rank_id = DB::table('ranks')->where('priority', 2)->value('id');
        $user->save();

        DB::table('rank_update_histories')->insert([
            'user_id' => $user->id,
            'previous_rank_id' => $previousRank,
            'current_rank_id' => $user->rank_id,
            'type' => $rankUpdatedType,
            'created_at' => \Illuminate\Support\Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}


