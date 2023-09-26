<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankUpdateDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_update_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rank_id');
            $table->string('title')->unique();
            $table->enum('constant_title',rank_constant())->unique();
            $table->integer('duration')->comment('duration will be counted as day');
            $table->timestamps();
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rank_update_days');
    }
}
