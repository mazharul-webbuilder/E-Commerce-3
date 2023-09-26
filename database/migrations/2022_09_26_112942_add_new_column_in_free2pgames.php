<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnInFree2pgames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free2pgames', function (Blueprint $table) {
            $table->double('winner_coin')->nullable();
            $table->double('entry_coin')->nullable();
            $table->double('multiply_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free2pgames', function (Blueprint $table) {
            $table->dropColumn('winner_coin');
            $table->dropColumn('entry_coin');
            $table->dropColumn('multiply_by');
        });
    }
}
