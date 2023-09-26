<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterToOfferTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_to_offer_tournaments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('who has become eligible');
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('campaign_id')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1=valid,0=invalid');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_to_offer_tournaments');
    }
}
