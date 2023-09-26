<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTournamentUnregistrationCommissionToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('tournament_unregistation_commission',11,2)->nullable()->comment('when any user will unregister
            any tournament this kind of amount will cut');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
          //  $table->dropColumn('tournament_unregistration_commission');
        });
    }
}
