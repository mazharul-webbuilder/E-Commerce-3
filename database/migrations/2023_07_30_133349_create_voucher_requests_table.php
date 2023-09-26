<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('share_owner_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->float('voucher_price',11,2);
            $table->enum('getting_source',['purchase','transfer']);
            $table->tinyInteger('status')->default(0)->comment('0=not used=1=used');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_requests');
    }
}
