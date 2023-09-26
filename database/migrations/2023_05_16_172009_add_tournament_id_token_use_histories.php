<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTournamentIdTokenUseHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_use_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('token_use_histories', function (Blueprint $table) {
            $table->dropColumn('tournament_id');
        });
    }
}
