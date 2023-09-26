<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('share_owner_id')->nullable();
            $table->string('voucher_number')->unique();
            $table->float('voucher_price',11,2);
            $table->enum('getting_type',['purchase','transfer'])->nullable();
            $table->tinyInteger('using_status')->default(0)->comment('0=not used,1=used');
            $table->tinyInteger('status')->default(0)->comment('0=not assigned,1=assigned');
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
        Schema::dropIfExists('vouchers');
    }
}
