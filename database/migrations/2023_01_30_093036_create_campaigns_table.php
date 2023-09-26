<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_position_id');
            $table->unsignedBigInteger('tournament_id');
            $table->integer('total_needed_position');
            $table->integer('total_needed_referral');
            $table->string('campaign_title')->nullable();
            $table->integer('duration')->comment('duration will be counted as day');
            $table->string('start_date');
            $table->string('end_date');
            $table->enum('constrain_title',CAMPAIGN_POSITION_CONSTRAIN_TITLE);
            $table->tinyInteger('status')->default(1)->comment('1=active,0=inactive');
            $table->timestamps();
            $table->foreign('campaign_position_id')->references('id')->on('campaign_positions')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
