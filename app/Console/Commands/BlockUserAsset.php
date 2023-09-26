<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class BlockUserAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockUserAssetCommission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This schedule will check each user last rank update date and time.
    If any users does not update their next rank with particular time their asset commission will be blocked till they update next rank';

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
        $users=User::where(['vip_member'=>1,'block_commission'=>1])->get();

        foreach ($users as $user){
            if ($user->rank->priority==1)
            {
                auto_block_user_asset_commission($user,'vip_to_partner');
            }elseif($user->rank->priority==2)
            {
                auto_block_user_asset_commission($user,'partner_to_star');

            }elseif ($user->rank->priority==3)
            {
                auto_block_user_asset_commission($user,'star_to_sub_controller');

            }elseif ($user->rank->priority==4)
            {
                auto_block_user_asset_commission($user,'sub_controller_to_controller');

            }
        }
    }
}
