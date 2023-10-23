<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLicenceIssueDateExpiredDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_details', function (Blueprint $table) {
            $table->string('trade_licence_issued')->nullable()->change();
            $table->string('trade_licence_expired')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_details', function (Blueprint $table) {
            //
        });
    }
}
