<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DataApply extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataApply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This schedule will work each user who has applied for data collection as the users whose are already kept in data application users list';

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
        $applied_users=User::where('apply_data',1)->get();
        if (!empty($applied_users)){
            foreach ($applied_users as $applied_user){
                if (Carbon::now()<=$applied_user->data_apply_expired_date){
                    $application_users=User::where('data_applied_user_id',$applied_user->id)->get();
                    if (!empty($application_users)){
                        foreach ($application_users as $application_user){
                            $application_user->update(['applicable_user'=>1,'data_applied_user_id'=>null,'send_referral_code'=>0]);
                        }
                    }
                    $applied_user->update(['apply_data'=>0,'data_applied_date'=>null,'data_apply_expired_date'=>null]);
                }
            }
        }

    }
}
