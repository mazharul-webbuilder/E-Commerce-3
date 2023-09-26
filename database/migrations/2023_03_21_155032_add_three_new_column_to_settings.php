<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreeNewColumnToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('recover_need_referral')->nullable();
            $table->integer('recover_need_my_played')->nullable();
            $table->integer('recover_need_team_played')->nullable();
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
            $table->dropColumn('recover_need_referral');
            $table->dropColumn('recover_need_my_played');
            $table->dropColumn('recover_need_team_played');
        });
    }
}
