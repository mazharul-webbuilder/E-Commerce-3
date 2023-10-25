<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnWithdrawHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('affiliator_id')->nullable();
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
            $table->dropColumn('seller_id');
            $table->dropColumn('merchant_id');
            $table->dropColumn('affiliator_id');
        });
    }
}
