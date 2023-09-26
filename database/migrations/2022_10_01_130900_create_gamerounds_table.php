<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamerounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->string('round_no');
            $table->string('round_end_time')->nullable();
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
        Schema::dropIfExists('gamerounds');
    }
}
