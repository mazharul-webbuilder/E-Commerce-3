<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinningPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winning_percentages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('free2pgame_id')->nullable();
            $table->unsignedBigInteger('free3pgame_id')->nullable();
            $table->unsignedBigInteger('free4pgame_id')->nullable();
            $table->unsignedBigInteger('player_id');
            $table->string('room_number');
            $table->enum('game_type',['2p','3p','4p']);
            $table->float('wining_percentage',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winning_percentages');
    }
}
