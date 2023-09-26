<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxPerDayAdShowOnScreen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisement_settings', function (Blueprint $table) {
            $table->string('max_per_day_ad_show')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisement_settings', function (Blueprint $table) {
            $table->dropColumn('max_per_day_ad_show');
        });
    }
}
