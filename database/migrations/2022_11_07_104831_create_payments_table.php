<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_name');
            $table->enum('type',PAYMENT_TYPE);
            $table->string('account_number')->comment('admin may add multiple account number on any account');
            $table->string('image');
            $table->integer('priority');
            $table->tinyInteger('status')->default(0)->comment('1=publish,0=Un publish');
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
        Schema::dropIfExists('payments');
    }
}
