<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToshareHolderFundHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('share_holder_fund_histories', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('1=valid,2=invalid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('share_holder_fund_histories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
