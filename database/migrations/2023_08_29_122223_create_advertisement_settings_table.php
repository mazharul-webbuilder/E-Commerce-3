<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_settings', function (Blueprint $table) {
            $table->id();
            $table->float('per_day_ad_price',8,4);
            $table->integer('ad_stay_time')->comment('This time will be considered as second');
            $table->integer('minimum_ad_limit',);
            $table->integer('maximum_ad_limit');
            $table->integer('ad_show_per_day')->comment('How many times ad will be shown in a day');
            $table->integer('ad_continue_day')->comment('How much day the ad will be running');
            $table->integer('advertiser_referral_commission');
            $table->integer('share_holder_fund_commission');
            $table->integer('asset_fund_commission');
            $table->integer('visitor_commission');
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
        Schema::dropIfExists('advertisement_settings');
    }
}
