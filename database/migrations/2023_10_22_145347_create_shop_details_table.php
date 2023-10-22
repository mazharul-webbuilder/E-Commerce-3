<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('logo')->nullable();
            $table->string('shop_name');
            $table->string('legal_name')->nullable();
            $table->text('detail')->nullable();
            $table->string('address')->nullable();
            $table->string('trade_licence')->nullable()->unique();
            $table->string('help_line')->nullable();
            $table->string('available_time')->nullable()->comment('it means the shop close and open time');
            $table->dateTime('trade_licence_issued')->nullable();
            $table->dateTime('trade_licence_expired')->nullable();
            $table->tinyInteger('is_verified')->default(1)->comment('1=verified,0=unverified');
            $table->tinyInteger('status')->default(1)->comment('1=active,0=inactive');
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
        Schema::dropIfExists('shop_details');
    }
}
