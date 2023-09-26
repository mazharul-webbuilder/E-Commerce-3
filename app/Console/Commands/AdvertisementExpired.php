<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AdvertisementExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advertisement:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This task schedule will check expired ad';

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


        $datas=Advertisement::where('status',0)
            ->where('ad_end_in','<=',Carbon::now()->format('Y-m-d H:i:s'))
            ->update(['status'=>1]);

    }
}
