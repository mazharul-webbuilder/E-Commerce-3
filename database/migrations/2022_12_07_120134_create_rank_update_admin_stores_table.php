<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankUpdateAdminStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_update_admin_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rank_update_history_id');
            $table->float('commission_amount');
            $table->timestamps();
            $table->foreign('rank_update_history_id')->references('id')->on('rank_update_histories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rank_update_admin_stores');
    }
}
