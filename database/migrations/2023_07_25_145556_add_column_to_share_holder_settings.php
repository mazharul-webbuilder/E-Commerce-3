<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToShareHolderSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('share_holder_settings', function (Blueprint $table) {
            $table->float('min_withdraw_amount',11,2)->nullable();
            $table->float('max_withdraw_amount',11,2)->nullable();
            $table->float('withdraw_charge',11,2)->nullable()->comment('count will be as %');
            $table->float('share_transfer_charge',11,2)->nullable()->comment('count will be fix');
            $table->float('live_share_commission',11,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('share_holder_settings', function (Blueprint $table) {
            //
        });
    }
}
