<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('share_from')->comment('who will transfer share holder');
            $table->unsignedBigInteger('share_to')->comment('who will get share holder');
            $table->unsignedBigInteger('share_holder_id');
            $table->timestamps();
            $table->foreign('share_from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('share_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('share_holder_id')->references('id')->on('share_holders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_transfer_histories');
    }
}
