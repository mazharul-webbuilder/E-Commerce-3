<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->integer('board_quantity');
            $table->string('round_type');
            $table->string('time_gaping')->nullable();
            $table->integer('diamond_limit')->nullable();
            $table->double('first_bonus_point')->nullable();
            $table->double('second_bonus_point')->nullable();
            $table->double('third_bonus_point')->nullable();
            $table->double('fourth_bonus_point')->nullable();
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
        Schema::dropIfExists('round_settings');
    }
}
