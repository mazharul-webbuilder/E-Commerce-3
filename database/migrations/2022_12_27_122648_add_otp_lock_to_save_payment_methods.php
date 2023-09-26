<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpLockToSavePaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('save_payment_methods', function (Blueprint $table) {
            $table->integer('otp_limit_per_day')->default(3);
            $table->integer('total_otp_sent')->default(0);
            $table->integer('resent_otp_interval')->default(5)->comment('5 will be counted as minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('save_payment_methods', function (Blueprint $table) {
            //
        });
    }
}
