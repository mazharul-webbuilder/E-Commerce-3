<?php

namespace App\Console;

use App\Console\Commands\AdvertisementExpired;
use App\Console\Commands\AutoRankUpdate;
use App\Console\Commands\BlockUserAsset;
use App\Console\Commands\DataApply;
use App\Console\Commands\TestCommand;
use App\Console\Commands\WithdrawSavigDistribute;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AutoRankUpdate::class,
        BlockUserAsset::class,
        DataApply::class,
        WithdrawSavigDistribute::class,
        AdvertisementExpired::class,
        TestCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('autoRankUpdate')->everyMinute();
        $schedule->command('blockUserAssetCommission')->everyMinute();
        $schedule->command('dataApply')->everyMinute();
        $schedule->command('withdrawSaving')->lastDayOfMonth('23:59')->timezone('Asia/Dhaka');
        $schedule->command('advertisement:expired')->everyMinute();
       // $schedule->command('test:command')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
