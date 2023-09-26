<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position_name')->unique();
            $table->enum('constrain_title',CAMPAIGN_POSITION_CONSTRAIN_TITLE);
            $table->tinyInteger('status')->default(1)->comment('1=active,0=inactive');
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
        Schema::dropIfExists('campaign_positions');
    }
}
