<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnStatusInRoundSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('round_settings', function (Blueprint $table) {
            $table->integer('status')->default(0);
            $table->integer('used_diamond')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('round_settings', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('used_diamond');
        });
    }
}
