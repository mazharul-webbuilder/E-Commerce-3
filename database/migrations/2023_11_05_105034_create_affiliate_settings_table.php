<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_settings', function (Blueprint $table) {
            $table->id();
            $table->float('company_commission',8,2);
            $table->float('generation_commission',8,2);
            $table->float('game_asset_commission',8,2);
            $table->float('top_seller_commission',8,2);
            $table->float('share_holder_commission',8,2);
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
        Schema::dropIfExists('affiliate_settings');
    }
}
