<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataApplyToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('data_apply_row')->nullable();
            $table->integer('data_apply_day')->nullable();
            $table->float('data_apply_coin',11,2)->nullable();
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
            $table->dropColumn('data_apply_row');
            $table->dropColumn('data_apply_day');
            $table->dropColumn('data_apply_coin');
        });
    }
}
