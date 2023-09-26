<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnGameId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playerenrolls', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playerenrolls', function (Blueprint $table) {
            $table->dropColumn('game_id');
        });
    }
}
