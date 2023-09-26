<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoRankUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_rank_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rank_id');
            $table->string('title')->unique();
            $table->enum('constant_title',rank_constant())->unique();
            $table->integer('member');
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
        Schema::dropIfExists('auto_rank_updates');
    }
}
