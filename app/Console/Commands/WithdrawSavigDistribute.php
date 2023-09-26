<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\WithdrawSaving;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WithdrawSavigDistribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'withdrawSaving';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Last day of the month all withdraw saving will be distributed to sub controller and controller';

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
        $datas=WithdrawSaving::whereMonth('created_at', Carbon::now())
            ->whereStatus(0)->get();

        if (count($datas)>0) {


            $total_saving = $datas->sum('saving_amount');

            $controllers = User::whereHas('rank', function ($q) {
                $q->where('priority', 5);
            })->get();

            $sub_controllers = User::whereHas('rank', function ($q) {
                $q->where('priority', 4);
            })->get();


            $controller_commission_percent = setting()->withdraw_saving_controller;
            $sub_controller_commission_percent = setting()->withdraw_saving_sub_controller;

            $controller_amount = ($total_saving * $controller_commission_percent) / 100;
            $sub_controller_amount = ($total_saving * $sub_controller_commission_percent) / 100;


            $total_controller = count($controllers);
            $total_sub_controller = count($sub_controllers);

            if ($total_controller > 0) {
                $per_controller_commission = $controller_amount / $total_controller;

                foreach ($controllers as $controller) {
                    $controller->marketing_balance = $controller->marketing_balance + $per_controller_commission;
                    $controller->save();
                    coin_earning_history($controller->id,$per_controller_commission,COIN_EARNING_SOURCE['withdraw_saving'],BALANCE_TYPE['marketing']);
                }
            }

            if ($total_sub_controller > 0) {
                $per_sub_controller_commission = $sub_controller_amount / $total_sub_controller;
                foreach ($sub_controllers as $sub_controller) {

                    $sub_controller->marketing_balance = $sub_controller->marketing_balance + $per_sub_controller_commission;
                    $sub_controller->save();
                    coin_earning_history($sub_controller->id,$per_sub_controller_commission,COIN_EARNING_SOURCE['withdraw_saving'],BALANCE_TYPE['marketing']);
                }
            }

            foreach ($datas as $data) {
                $data->status = 1;
                $data->save();
            }

        }

    }
}
