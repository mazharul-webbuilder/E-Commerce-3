<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareHolderSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_holder_settings', function (Blueprint $table) {
            $table->id();
            $table->float('share_price',11,2);
            $table->float('share_commission',11,2)->comment("The share holder will be provided this percent of amount when distributed share holder's fund");
            $table->float('referral_commission',11,2)->comment("Share holder's parent user will be provided this percent of amount when distributed share holder's fund");
            $table->integer('share_purchase_limit')->comment('Every user can purchase this amount of share');
            $table->integer('minimum_referral')->comment("Every user needs to have minimum this number of users of his/her own referral when he/she will withdraw share holder's balance");
            $table->integer('minimum_tournament_play')->comment("Every user needs to have play minimum this number of tournaments when he/she will withdraw share holder's balance");
            $table->integer('minimum_tournament_team_play')->comment("Every user's team needs to play minimum this number of tournaments when he/she will withdraw share holder's balance");
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
        Schema::dropIfExists('share_holder_settings');
    }
}
