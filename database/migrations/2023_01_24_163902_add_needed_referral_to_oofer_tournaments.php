<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeededReferralToOoferTournaments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_tournaments', function (Blueprint $table) {
            $table->integer('total_needed_referral')->nullable()->after('total_needed_position');
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
            $table->dropColumn('total_needed_referral');
        });
    }
}
