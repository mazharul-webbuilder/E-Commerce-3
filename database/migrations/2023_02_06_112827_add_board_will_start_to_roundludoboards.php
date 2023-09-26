<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoardWillStartToRoundludoboards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roundludoboards', function (Blueprint $table) {
            $table->string('board_will_start')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roundludoboards', function (Blueprint $table) {
            $table->dropColumn('board_will_start');
        });
    }
}
