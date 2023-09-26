<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerenrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playerenrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->integer('user_id');
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
        Schema::dropIfExists('playerenrolls');
    }
}
