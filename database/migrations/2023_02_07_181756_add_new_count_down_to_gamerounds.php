<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewCountDownToGamerounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamerounds', function (Blueprint $table) {
            $table->tinyInteger('count_down')->default(0)->comment('0=count down start 1=count down not start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gamerounds', function (Blueprint $table) {
            $table->dropColumn('count_down');
        });
    }
}
