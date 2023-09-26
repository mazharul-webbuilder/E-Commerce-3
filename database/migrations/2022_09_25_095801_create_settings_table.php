<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->double('free_login_coin')->default(0);
            $table->double('free_login_diamond')->default(0);
            $table->double('max_withdraw_limit')->default(0);
            $table->double('min_withdraw_limit')->default(0);
            $table->double('referal_bonus')->default(0);
            $table->string('game_logo')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
