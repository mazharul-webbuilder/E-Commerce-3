<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_winners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_room_code_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('position',[1,2,3,4]);
            $table->enum('type',['2p','4p','team']);
            $table->timestamps();
           // $table->foreign('track_room_code_id')->references('id')->on('track_room_codes')->onDelete('cascade');
          //  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_winners');
    }
}
