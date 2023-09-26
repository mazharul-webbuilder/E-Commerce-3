<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerWiningPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_wining_percentages', function (Blueprint $table) {
            $table->id();
            $table->string('room_code')->unique();
            $table->float('player_1_winning_chance')->nullable();
            $table->float('player_2_winning_chance')->nullable();
            $table->float('player_3_winning_chance')->nullable();
            $table->float('player_4_winning_chance')->nullable();
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
        Schema::dropIfExists('player_wining_percentages');
    }
}
