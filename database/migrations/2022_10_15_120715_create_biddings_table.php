<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->unsignedBigInteger('round_id');
            $table->foreign('round_id')->references('id')->on('gamerounds')->onDelete('cascade');
            $table->unsignedBigInteger('board_id');
            $table->foreign('board_id')->references('id')->on('roundludoboards')->onDelete('cascade');
            $table->string('bided_id')->nullable();
            $table->integer('status')->default(0)->comment('0=pending,1=Running,2=Complete');
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
        Schema::dropIfExists('biddings');
    }
}
