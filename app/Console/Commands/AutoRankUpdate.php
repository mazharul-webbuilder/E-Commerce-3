<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AutoRankUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoRankUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This schedule is will check each uses who are already become VIP member.If these uses will full fill any rank update condition there rank will be updated';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // priority 1=vip.2=partner,3=star,4=sub controller,5=controller;
        $users=User::where('vip_member',1)->get();

        foreach ($users as $user){
            if ($user->rank->priority==1)
            {
                $vip_members=User::where('parent_id',$user->id)
                    ->whereHas('rank',function ($q){
                        $q->where('priority',1);
                    })->count();
                $require_member=auto_rank_member('vip_to_partner')->member;
                if ($vip_members>=$require_member){
                    auto_update_user_rank($user);
                    rank_update_history($user);
                }
            }elseif($user->rank->priority==2)
            {
                $partners=User::where('parent_id',$user->id)
                    ->whereHas('rank',function ($q){
                        $q->where('priority',2);
                    })->count();
                $require_member=auto_rank_member('partner_to_star')->member;
                if ($partners>=$require_member){
                    auto_update_user_rank($user);
                    rank_update_history($user);
                }
            }elseif ($user->rank->priority==3)
            {

                $stars=User::where('parent_id',$user->id)
                    ->whereHas('rank',function ($q){
                        $q->where('priority',3);
                    })->count();
                $require_member=auto_rank_member('star_to_sub_controller')->member;
                if ($stars>=$require_member){
                    auto_update_user_rank($user);
                    rank_update_history($user);
                }
            }elseif ($user->rank->priority==4)
            {

                $sub_controller=User::where('parent_id',$user->id)
                    ->whereHas('rank',function ($q){
                        $q->where('priority',4);
                    })->count();
                $require_member=auto_rank_member('sub_controller_to_controller')->member;

                if ($sub_controller>=$require_member){
                    auto_update_user_rank($user);
                    rank_update_history($user);
                }
            }

        }
    }

}
