<?php
use App\Models\Generation_commission;
use App\Models\User;
use App\Models\RankUpdateAdminStore;

// time format 24 hours


function generation_commission($generation)
{
    $generation_commission=Generation_commission::where('generation_level',$generation)->first();
    return $generation_commission;
}

function calculate_commission($fix_commission,$coin)
{
   // $commission=(float)(number_format((($coin*$fix_commission)/100),2));
    $commission=($fix_commission*$coin)/100;
    return $commission;
}

function rank_update_admin_store($rank_update_history,$rank_update_coin){

    $rank_update_admin_store=new RankUpdateAdminStore();
    // $commission_amount=(float)(number_format((($rank_update_coin*setting()->admin_store)/100),2));
    $commission_amount=$rank_update_coin*setting()->admin_store/100;
    $rank_update_admin_store->rank_update_history_id=$rank_update_history->id;
    $rank_update_admin_store->commission_amount=$commission_amount;
    $rank_update_admin_store->save();
}

function distribute_commission($generation_user,$commission,$coin_earning_source){

        $current_marketing_coin=$generation_user->marketing_balance;
        $total_marketing_coin=$current_marketing_coin+$commission;
        $generation_user->marketing_balance=$total_marketing_coin;
        $generation_user->save();
        coin_earning_history($generation_user->id,$commission,$coin_earning_source,BALANCE_TYPE['marketing']);
}

function provide_generation_commission($user,$coin,$coin_earning_source){

    //$generation_one=User::where('id',$user->parent_id)->first();
    $generation=$user;
    for ($i=1;$i<=15;$i++)
    {
        $generation=User::where('id',$generation->parent_id)->first();
        if (!empty($generation)){
            if ($i===1){
                $commission=calculate_commission(generation_commission('1st')->commission,$coin);
            }elseif ($i===2){
                $commission=calculate_commission(generation_commission('2nd')->commission,$coin);
            }elseif ($i===3){
                $commission=calculate_commission(generation_commission('3rd')->commission,$coin);
            }else{
                $commission=calculate_commission(generation_commission($i.'th')->commission,$coin);
            }
            distribute_commission($generation,$commission,$coin_earning_source);
        }else{
            break;
        }
    }

}



function provide_generation_commission_secound($user,$coin){

    $generation_one=User::where('id',$user->parent_id)->first();

    if (!empty($generation_one))
    {
        $commission=calculate_commission(generation_commission('1st')->commission,$coin);
        distribute_commission($generation_one,$commission);

        $generation_two=User::where('id',$generation_one->parent_id)->first();
        if (!empty($generation_two))
        {
            $commission=calculate_commission(generation_commission('2nd')->commission,$coin);
            distribute_commission($generation_two,$commission);
            $generation_three=User::where('id',$generation_two->parent_id)->first();
            if (!empty($generation_three))
            {
                $commission=calculate_commission(generation_commission('3rd')->commission,$coin);

                distribute_commission($generation_three,$commission);

                $generation_four=User::where('id',$generation_three->parent_id)->first();
                if (!empty($generation_four))
                {
                    $commission=calculate_commission(generation_commission('4th')->commission,$coin);
                    distribute_commission($generation_four,$commission);

                    $generation_five=User::where('id',$generation_four->parent_id)->first();
                    if (!empty($generation_five)){
                        $commission=calculate_commission(generation_commission('5th')->commission,$coin);
                        distribute_commission($generation_five,$commission);

                        $generation_six=User::where('id',$generation_five->parent_id)->first();

                        if (!empty($generation_six)){
                            $commission=calculate_commission(generation_commission('6th')->commission,$coin);
                            distribute_commission($generation_six,$commission);

                            $generation_seven=User::where('id',$generation_six->parent_id)->first();
                            if (!empty($generation_seven)){
                                $commission=calculate_commission(generation_commission('7th')->commission,$coin);
                                distribute_commission($generation_seven,$commission);

                                $generation_eight=User::where('id',$generation_seven->parent_id)->first();
                                if (!empty($generation_eight)){
                                    $commission=calculate_commission(generation_commission('8th')->commission,$coin);
                                    distribute_commission($generation_eight,$commission);

                                    $generation_nine=User::where('id',$generation_eight->parent_id)->first();
                                    if (!empty($generation_nine)){
                                        $commission=calculate_commission(generation_commission('9th')->commission,$coin);
                                        distribute_commission($generation_nine,$commission);

                                        $generation_ten=User::where('id',$generation_nine->parent_id)->first();
                                        if (!empty($generation_ten)){
                                            $commission=calculate_commission(generation_commission('10th')->commission,$coin);
                                            distribute_commission($generation_ten,$commission);

                                            $generation_eleven=User::where('id',$generation_ten->parent_id)->first();
                                            if (!empty($generation_eleven)){
                                                $commission=calculate_commission(generation_commission('11th')->commission,$coin);

                                                distribute_commission($generation_eleven,$commission);

                                                $generation_twelve=User::where('id',$generation_eleven->parent_id)->first();
                                                if (!empty($generation_twelve)){
                                                    $commission=calculate_commission(generation_commission('12th')->commission,$coin);
                                                    distribute_commission($generation_twelve,$commission);

                                                    $generation_thirteen=User::where('id',$generation_twelve->parent_id)->first();
                                                    if (!empty($generation_thirteen)){
                                                        $commission=calculate_commission(generation_commission('13th')->commission,$coin);
                                                        distribute_commission($generation_thirteen,$commission);

                                                        $generation_fourteen=User::where('id',$generation_thirteen->parent_id)->first();
                                                        if (!empty($generation_fourteen)){
                                                            $commission=calculate_commission(generation_commission('14th')->commission,$coin);
                                                            distribute_commission($generation_fourteen,$commission);

                                                            $generation_fifteen=User::where('id',$generation_fourteen->parent_id)->first();
                                                            if (!empty($generation_fifteen)){
                                                                $commission=calculate_commission(generation_commission('15th')->commission,$coin);
                                                                distribute_commission($generation_fifteen,$commission);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                    }
                                }
                            }
                        }
                    }
                }

            }

        }

    }
}


