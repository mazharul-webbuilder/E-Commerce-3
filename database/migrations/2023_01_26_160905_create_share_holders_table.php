<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_holders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('share_owner_id');
            $table->float('share_purchase_price',11,2)->nullable();
            $table->timestamps();
            $table->foreign('share_owner_id')->references('id')->on('share_owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_holders');
    }
}
