<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diamond_uses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid')->nullable();//who can bid
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tournament_id')->nullable();//tournament id
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->unsignedBigInteger('game_id')->nullable(); // game id under tournament
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->unsignedBigInteger('round_id')->nullable();  // round under game
            $table->foreign('round_id')->references('id')->on('gamerounds')->onDelete('cascade');
            $table->string('diamond_use')->nullable();
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
        Schema::dropIfExists('diamond_uses');
    }
}
