<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoundStartTileGamerounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamerounds', function (Blueprint $table) {
            $table->string('round_start_time')->nullable()->after('round_no');
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
            $table->dropColumn('round_start_time');
        });
    }
}
