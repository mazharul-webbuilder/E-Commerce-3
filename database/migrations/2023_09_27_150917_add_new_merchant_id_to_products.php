<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewMerchantIdToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('product_type',['in_house','merchant'])->nullable();
            $table->tinyInteger('is_reseller')->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('is_affiliate')->default(0)->comment('0=no,1=yes');
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
