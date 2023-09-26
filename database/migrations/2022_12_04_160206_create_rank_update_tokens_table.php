<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankUpdateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_update_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rank_id');
            $table->string('title')->unique();
            $table->enum('constant_title',rank_constant())->unique();
            $table->integer('gift_token');
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
        Schema::dropIfExists('rank_update_tokens');
    }
}
