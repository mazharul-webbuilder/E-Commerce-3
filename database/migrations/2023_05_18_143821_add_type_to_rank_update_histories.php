<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToRankUpdateHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rank_update_histories', function (Blueprint $table) {
            $table->enum('type',['auto_update','coin_update'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rank_update_histories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
