<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('admin_store')->nullable()->comment('When any user update rank.This amount will be counted as percent (%)');
            $table->float('sub_controller_commission')->nullable()->comment('This amount will be counted as percent (%)');
            $table->float('controller_commission')->nullable()->comment('This amount will be counted as percent (%)');

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
            $table->dropColumn('admin_store');
            $table->dropColumn('sub_controller_commission');
            $table->dropColumn('controller_commission');
        });
    }
}
