<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnTournamentIdInOfferTournament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_tournaments', function (Blueprint $table) {
            $table->foreignId('tournament_id')->nullable()->constrained('tournaments')->onDelete('cascade');


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
           // $table->dropColumn('tournament_id');
        });
    }
}
