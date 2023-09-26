<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceTypeToCoinEarningHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coin_earning_histories', function (Blueprint $table) {
            $table->string('balance_type')->nullable()->after('earning_coin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coin_earning_histories', function (Blueprint $table) {
            $table->dropColumn('balance_type');
        });
    }
}
