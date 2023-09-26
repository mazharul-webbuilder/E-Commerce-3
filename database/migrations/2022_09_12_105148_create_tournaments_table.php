<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('tournament_name');
            $table->string('game_type');
            $table->string('game_start_delay_time');
            $table->integer('game_sub_type')->nullable();
            $table->string('player_type');
            $table->integer('player_limit');
            $table->integer('player_enroll')->default(0);
            $table->integer('registration_use')->default(1);
            $table->integer('diamond_use')->default(1);
            $table->double('registration_fee');
            $table->double('winning_prize');
            $table->integer('diamond_limit')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('tournaments');
    }
}
