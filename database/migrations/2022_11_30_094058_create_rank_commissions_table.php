<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_commissions', function (Blueprint $table) {
            $table->id();
            $table->string("rank_name")->unique();
            $table->float('registration_commission',11,2)->nullable();
            $table->float('diamond_commission',11,2)->nullable();
            $table->float('betting_commission',11,2)->nullable();
            $table->float('withdraw_commission',11,2)->nullable();
            $table->float('game_asset_commission',11,2)->nullable();
            $table->float('updating_commission',11,2)->nullable();
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
        Schema::dropIfExists('rank_commissions');
    }
}
