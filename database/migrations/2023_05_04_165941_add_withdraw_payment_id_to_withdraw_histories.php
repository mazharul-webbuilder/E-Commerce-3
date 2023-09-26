<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWithdrawPaymentIdToWithdrawHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('withdraw_payment_id')->nullable()->after('user_id');
            $table->foreign('withdraw_payment_id')->references('id')->on('withdraw_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_histories', function (Blueprint $table) {
            $table->dropColumn('withdraw_payment_id');
        });
    }
}
