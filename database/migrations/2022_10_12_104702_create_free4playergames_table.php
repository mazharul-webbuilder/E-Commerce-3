<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFree4playergamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free4playergames', function (Blueprint $table) {
            $table->id();
            $table->integer('player_one');
            $table->integer('player_two')->nullable();
            $table->integer('player_three')->nullable();
            $table->integer('player_four')->nullable();
            $table->integer('first_winner')->nullable();
            $table->integer('second_winner')->nullable();
            $table->integer('third_winner')->nullable();
            $table->integer('loser')->nullable();
            $table->double('first_winner_coin')->nullable();
            $table->double('second_winner_coin')->nullable();
            $table->double('third_winner_coin')->nullable();
            $table->double('loser_coin')->nullable();
            $table->double('entry_fee')->nullable();
            $table->integer('game_no')->nullable();
            $table->string('game_id')->nullable();
            $table->double('first_winner_multiply')->nullable();
            $table->double('second_winner_multiply')->nullable();
            $table->double('third_winner_multiply')->nullable();
            $table->double('looser_multiply')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('free4playergames');
    }
}
