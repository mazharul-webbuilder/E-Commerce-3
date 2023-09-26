<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biding_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid')->nullable();//who can bid
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tournament_id')->nullable();//tournament id
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->unsignedBigInteger('game_id')->nullable(); // game id under tournament
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->unsignedBigInteger('round_id')->nullable();  // round under game
            $table->foreign('round_id')->references('id')->on('gamerounds')->onDelete('cascade');
            $table->unsignedBigInteger('board_id')->nullable();  // board under round
            $table->foreign('board_id')->references('id')->on('roundludoboards')->onDelete('cascade');
            $table->unsignedBigInteger('bided_to')->nullable(); //which player to bid
            $table->foreign('bided_to')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status')->default(0)->comment('0=Pending,1=Complete');
            $table->double('bid_amount')->default(0);
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
        Schema::dropIfExists('biding_details');
    }
}
