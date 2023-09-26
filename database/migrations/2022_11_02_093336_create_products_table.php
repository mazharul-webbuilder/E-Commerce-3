<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->string('title');
            $table->float('previous_price',11,2)->default(0);
            $table->float('current_price',11,2)->default(0);
            $table->integer('previous_coin')->default(0);
            $table->integer('current_coin',)->default(0);
            $table->float('discount',11,2)->nullable();
            $table->float('weight',11,2)->nullable();
            $table->integer('product_code')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->integer('view')->default(0);
            $table->integer('total_order')->default(0);
            $table->timestamp('last_ordered_at')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=Un publish,1=Publish');
            $table->tinyInteger('flash_deal')->default(0)->comment('1=flash deal,0=Not Flash deal');
            $table->string('deal_start_date')->nullable();
            $table->string('deal_end_date')->nullable();
            $table->enum('deal_type',['flat','percent'])->nullable();
            $table->tinyInteger('best_sale')->default(0)->comment('0=not best sale,1=best sale');
            $table->tinyInteger('most_sale')->default(0)->comment('0=not most sale,1=most sale');
            $table->tinyInteger('recent')->default(0)->comment('0=not not recent sale,1=recent sale');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
