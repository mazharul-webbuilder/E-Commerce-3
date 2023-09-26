<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidderCommissionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidder_commission_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidder_id');
            $table->unsignedBigInteger('bidded_to_id');
            $table->unsignedBigInteger('board_id');
            $table->float('bid_amount');
            $table->float('bidder_amount');
            $table->float('admin_commission');
            $table->timestamps();
            $table->foreign('bidder_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bidded_to_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('board_id')->references('id')->on('roundludoboards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidder_commission_histories');
    }
}
