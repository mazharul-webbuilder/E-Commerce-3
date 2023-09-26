<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecoveryFundEligibleToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('played_tournament',11,2)->nullable()->comment('Every controller or sub-controller must have joined this amount pf tournament');
            $table->float('win_game_percentage',11,2)->nullable()->comment('Every controller or sub-controller must have won this amount of game won percent.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('played_tournament');
            $table->dropColumn('win_game_percentage');
        });
    }
}
