<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRankIdToRankCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rank_commissions', function (Blueprint $table) {
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rank_commissions', function (Blueprint $table) {
            $table->dropColumn('rank_id');
        });
    }
}
