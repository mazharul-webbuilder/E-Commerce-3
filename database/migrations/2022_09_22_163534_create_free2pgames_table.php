<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFree2pgamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free2pgames', function (Blueprint $table) {
            $table->id();
            $table->integer('player_one')->nullable();
            $table->integer('player_two')->nullable();
            $table->integer('winner')->nullable();
            $table->integer('looser')->nullable();
            $table->integer('game_no');
            $table->string('game_id');
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
        Schema::dropIfExists('free2pgames');
    }
}
