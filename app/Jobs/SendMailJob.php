<?php

namespace App\Jobs;

use App\Mail\Sendmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mail_info=[];
    protected $email_to;
    public function __construct($mail_info,$email_to)
    {
        $this->mail_info=$mail_info;
        $this->email_to=$email_to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        Mail::to($this->email_to)->send(new Sendmail($this->mail_info));

    }
}
