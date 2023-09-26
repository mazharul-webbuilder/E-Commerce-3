<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpSendLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_send_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('save_payment_method_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('save_payment_method_id')->references('id')->on('save_payment_methods')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otp_send_limits');
    }
}
