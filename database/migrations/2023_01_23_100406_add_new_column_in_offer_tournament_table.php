<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnInOfferTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_tournaments', function (Blueprint $table) {
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 inactive and one is active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_tournaments', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
}
