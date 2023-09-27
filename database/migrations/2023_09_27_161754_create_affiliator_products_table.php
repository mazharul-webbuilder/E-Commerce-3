<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliatorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliator_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliator_id');
            $table->foreignId('product_id')->cascadeOnDelete('products');
            $table->timestamps();
            $table->foreign('affiliator_id')->references('id')->on('affiliators')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliator_products');
    }
}
