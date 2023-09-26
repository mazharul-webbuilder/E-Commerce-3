<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDiamondToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('use_diamond',11,2)->nullable();
            $table->float('gift_to_win_charge',11,2)->nullable()->comment('calculated as percent (%)');
            $table->float('win_to_gift_charge',11,2)->nullable()->comment('calculated as percent (%)');
            $table->float('marketing_to_win_charge',11,2)->nullable()->comment('calculated as percent (%)');
            $table->float('marketing_to_gift_charge',11,2)->nullable()->comment('calculated as percent (%)');
            $table->float('balance_withdraw_charge',11,2)->nullable()->comment('This is flat charge. For any kind of withdraw amount the charge will be deduction flat');
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
            $table->dropColumn('use_diamond');
            $table->dropColumn('gift_to_win_charge');
            $table->dropColumn('win_to_gift_charge');
            $table->dropColumn('marketing_to_win_charge');
            $table->dropColumn('marketing_to_gift_charge');
            $table->dropColumn('balance_withdraw_charge');

        });
    }
}
