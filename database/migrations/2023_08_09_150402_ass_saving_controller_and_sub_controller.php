<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssSavingControllerAndSubController extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('withdraw_saving_controller',11,2)->nullable();
            $table->float('withdraw_saving_sub_controller',11,2)->nullable();
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
            $table->dropColumn('withdraw_saving_controller');
            $table->dropColumn('withdraw_saving_sub_controller');
        });
    }
}
