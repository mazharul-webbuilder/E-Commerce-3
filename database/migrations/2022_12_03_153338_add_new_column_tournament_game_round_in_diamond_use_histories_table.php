<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnTournamentGameRoundInDiamondUseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diamond_use_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->unsignedBigInteger('round_id')->nullable();
            $table->foreign('round_id')->references('id')->on('gamerounds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diamond_use_histories', function (Blueprint $table) {
            $table->dropColumn('tournament_id');
            $table->dropColumn('game_id');
            $table->dropColumn('round_id');
        });
    }
}
