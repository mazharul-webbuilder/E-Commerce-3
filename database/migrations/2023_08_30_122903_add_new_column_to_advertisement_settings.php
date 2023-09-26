<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToAdvertisementSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisement_settings', function (Blueprint $table) {
            $table->integer('visitor_stay_time')->nullable()->comment('This time will be counted as second');
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
            $table->dropColumn('visitor_stay_time');
        });
    }
}
