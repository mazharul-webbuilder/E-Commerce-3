<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewCompaignIdToCampaignDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_details', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id')->nullable();
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
        Schema::table('campaign_details', function (Blueprint $table) {
            //
        });
    }
}
