<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfer_from_id');
            $table->unsignedBigInteger('transfer_to_id');
            $table->unsignedBigInteger('voucher_request_id');
            $table->timestamps();
            $table->foreign('transfer_from_id')->references('id')->on('share_owners')->onDelete('cascade');
            $table->foreign('transfer_to_id')->references('id')->on('share_owners')->onDelete('cascade');
            $table->foreign('voucher_request_id')->references('id')->on('voucher_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_transfer_histories');
    }
}
