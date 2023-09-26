<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBdtAmountToWithdrawHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_histories', function (Blueprint $table) {
            $table->float('bdt_amount')->nullable()->after('user_received_balance');
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
            $table->dropColumn('bdt_amount');
        });
    }
}
