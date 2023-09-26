<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnTotournaments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->integer('registration_fee_gift_token')->nullable();
            $table->integer('registration_fee_green_token')->nullable();
            $table->tinyText('winner_price_detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('registration_fee_gift_token');
            $table->dropColumn('registration_fee_green_token');
            $table->dropColumn('winner_price_detail');
        });
    }
}
